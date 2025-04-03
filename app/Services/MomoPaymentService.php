<?php

namespace App\Services;

use App\Enum\ActiveStatus as EnumActiveStatus;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Enums\ActiveStatus;
use App\Models\Donation;

class MomoPaymentService
{
    protected $endpoint;
    protected $partnerCode;
    protected $accessKey;
    protected $secretKey;
    protected $returnUrl;
    protected $notifyUrl;
    protected $requestType;

    public function __construct()
    {
        $this->endpoint = config('momo.endpoint');
        $this->partnerCode = config('momo.partner_code');
        $this->accessKey = config('momo.access_key');
        $this->secretKey = config('momo.secret_key');
        $this->returnUrl = env('APP_URL') . '/api/v1/payment/momo/return';
        $this->notifyUrl = env('APP_URL') . '/api/v1/payment/momo/ipn';
        $this->requestType = config('momo.request_type');
    }

    public function createPayment($orderId, $amount, $orderInfo)
    {
        $requestId = time() . "";
        $rawHash = "accessKey=" . $this->accessKey . "&amount=" . $amount . "&extraData=&ipnUrl=" . $this->notifyUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $this->partnerCode . "&redirectUrl=" . $this->returnUrl . "&requestId=" . $requestId . "&requestType=" . $this->requestType;

        $signature = hash_hmac('sha256', $rawHash, $this->secretKey);

        $requestData = [
            'partnerCode' => $this->partnerCode,
            'partnerName' => "Test",
            'storeId' => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $this->returnUrl,
            'ipnUrl' => $this->notifyUrl,
            'lang' => 'vi',
            'extraData' => '',
            'requestType' => $this->requestType,
            'signature' => $signature
        ];

        try {
            $response = Http::post($this->endpoint . '/create', $requestData);

            Log::info('MoMo Payment Request', [
                'request' => $requestData,
                'response' => $response->json()
            ]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('MoMo Payment Error', ['error' => $e->getMessage()]);
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    public function processReturnUrl($momoData)
    {
        Log::info('Momo Return Data', ['data' => $momoData]);

        $orderId = $momoData['orderId'] ?? null;
        $requestId = $momoData['requestId'] ?? null;
        $amount = $momoData['amount'] ?? 0;
        $orderInfo = $momoData['orderInfo'] ?? '';
        $orderType = $momoData['orderType'] ?? '';
        $transId = $momoData['transId'] ?? '';
        $resultCode = $momoData['resultCode'] ?? 99;
        $message = $momoData['message'] ?? '';
        $payType = $momoData['payType'] ?? '';
        $responseTime = $momoData['responseTime'] ?? 0;
        $extraData = $momoData['extraData'] ?? '';
        $signature = $momoData['signature'] ?? '';

        // Build raw hash data for verification
        $rawHash = "accessKey=" . $this->accessKey . "&amount=" . $amount . "&extraData=" . $extraData .
            "&message=" . $message . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo .
            "&orderType=" . $orderType . "&partnerCode=" . $this->partnerCode .
            "&payType=" . $payType . "&requestId=" . $requestId .
            "&responseTime=" . $responseTime . "&resultCode=" . $resultCode .
            "&transId=" . $transId;

        // Generate signature for comparison
        $calculatedSignature = hash_hmac('sha256', $rawHash, $this->secretKey);

        // Check if signature is valid
        if ($calculatedSignature !== $signature) {
            Log::error('Momo Payment: Invalid signature', [
                'calculated' => $calculatedSignature,
                'received' => $signature
            ]);

            return [
                'success' => false,
                'message' => 'Chữ ký không hợp lệ',
                'order_id' => $orderId
            ];
        }

        // Find the donation/order
        $donation = Donation::find('id', $orderId);

        if (!$donation) {
            Log::error('Momo Payment: Order not found', ['order_id' => $orderId]);
            return [
                'success' => false,
                'message' => 'Không tìm thấy đơn hàng',
                'order_id' => $orderId
            ];
        }

        // // Verify payment amount
        // if ($donation->amount != $amount) {
        //     Log::error('Momo Payment: Amount mismatch', [
        //         'expected' => $donation->amount,
        //         'received' => $amount
        //     ]);

        //     return [
        //         'success' => false,
        //         'message' => 'Số tiền thanh toán không khớp',
        //         'order_id' => $orderId
        //     ];
        // }

        // Check payment result
        if ($resultCode == 0) {
            // Payment successful
            // $donation->payment_status = ActiveStatus::ACTIVE;
            // $donation->transaction_id = $transId;
            // $donation->payment_method = 'momo';
            // $donation->payment_date = now();
            // $donation->save();

            $donation->update([
                'status' => EnumActiveStatus::ACTIVE,
                'amount' => $amount,
            ]);

            Log::info('Momo Payment: Payment successful', [
                'order_id' => $orderId,
                'trans_id' => $transId
            ]);

            return [
                'success' => true,
                'message' => 'Thanh toán thành công',
                'donation_id' => $donation->id,
                'order_id' => $orderId
            ];
        } else {
            // // Payment failed
            // $donation->payment_status = ActiveStatus::INACTIVE;
            // $donation->transaction_id = $transId;
            // $donation->payment_method = 'momo';
            // $donation->save();

            Log::error('Momo Payment: Payment failed', [
                'order_id' => $orderId,
                'result_code' => $resultCode,
                'message' => $message
            ]);

            return [
                'success' => false,
                'message' => 'Thanh toán không thành công: ' . $message,
                'donation_id' => $donation->id,
                'order_id' => $orderId,
                'result_code' => $resultCode
            ];
        }
    }

    public function verifyIpn($requestData)
    {
        try {
            // Extract signature from request
            $receivedSignature = $requestData['signature'];
            Log::info('Received IPN data', ['requestData' => $requestData]);

            // Build raw hash data
            $rawHash = "accessKey=" . $this->accessKey . "&amount=" . $requestData['amount'] . "&extraData=" . $requestData['extraData'] . "&orderId=" . $requestData['orderId'] . "&orderInfo=" . $requestData['orderInfo'] . "&orderType=" . $requestData['orderType'] . "&partnerCode=" . $requestData['partnerCode'] . "&payType=" . $requestData['payType'] . "&requestId=" . $requestData['requestId'];
            Log::info('Raw hash data', ['rawHash' => $rawHash]);

            // Generate signature
            $signature = hash_hmac('sha256', $rawHash, $this->secretKey);
            Log::info('Generated signature', ['signature' => $signature]);

            // Verify signature
            if ($signature === $receivedSignature) {
                Log::info('Signature verified successfully');
                return [
                    'status' => 'success',
                    'message' => 'Signature Verified',
                    'data' => $requestData
                ];
            }

            Log::warning('Signature verification failed', [
                'calculated' => $signature,
                'received' => $receivedSignature
            ]);

            return [
                'status' => 'error',
                'message' => 'Invalid Signature',
            ];
        } catch (\Exception $e) {
            Log::error('Error verifying IPN', ['error' => $e->getMessage()]);
            return [
                'status' => 'error',
                'message' => 'An error occurred during signature verification',
            ];
        }
    }
}
