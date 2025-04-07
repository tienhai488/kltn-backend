<?php

namespace App\Services;

use App\DTOs\MomoApiConfigDTO;
use App\Enum\PaymentMethodCode;
use App\Enum\PaymentStatus;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Repositories\Donation\DonationRepositoryInterface;
use App\Repositories\PaymentMethod\PaymentMethodRepositoryInterface;
use Carbon\Carbon;

class MomoPaymentService
{
    protected $apiConfig;
    protected $endpoint;
    protected $partnerCode;
    protected $accessKey;
    protected $secretKey;
    protected $returnUrl;
    protected $notifyUrl;
    protected $requestType;

    public function __construct(
        protected PaymentMethodRepositoryInterface $paymentMethodRepository,
        protected DonationRepositoryInterface $donationRepository,
    ) {
        $paymentMethod = $this->paymentMethodRepository->advancedGetFirst([
            'conditions' => [
                'where' => [
                    'code' => PaymentMethodCode::MOMO->value,
                ],
            ],
        ]);
        $this->apiConfig = MomoApiConfigDTO::fromArray($paymentMethod->api_config ?? []);
        $this->endpoint = $this->apiConfig->endpoint;
        $this->partnerCode = $this->apiConfig->partnerCode;
        $this->accessKey = $this->apiConfig->accessKey;
        $this->secretKey = $this->apiConfig->secretKey;
        $this->returnUrl = route('payment_method.momo.return');
        $this->notifyUrl = route('api.payment_method.momo.ipn');
        $this->requestType = config('momo.request_type');
        // $this->notifyUrl = "https://030f-116-110-41-181.ngrok-free.app/api/v1/payment-method/momo/ipn";
    }

    /**
     * Tạo URL thanh toán MoMo.
     *
     * @param int $orderId
     * @param int $amount
     * @return array
     */
    public function createPayment($orderId, $amount)
    {
        $orderInfo = '#' . $orderId;
        $orderId = $orderId . '_' . Carbon::now()->format('YmdHis');
        $requestId = time() . "";
        $rawHash = "accessKey=" . $this->accessKey . "&amount=" . $amount . "&extraData=&ipnUrl=" . $this->notifyUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $this->partnerCode . "&redirectUrl=" . $this->returnUrl . "&requestId=" . $requestId . "&requestType=" . $this->requestType;

        $signature = hash_hmac('sha256', $rawHash, $this->secretKey);

        $requestData = [
            'partnerCode' => $this->partnerCode,
            'partnerName' => 'MomoTest',
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

    /**
     * Process the return URL from MoMo to process the payment result.
     *
     * @param array $momoData
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processReturnUrl($momoData)
    {
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
        if ($calculatedSignature != $signature) {
            return redirect()->away($this->apiConfig->returnUrl)->with([
                'success' => false,
                'message' => 'Chữ ký không hợp lệ',
                'donation_id' => $orderId
            ]);
        }

        $orderId = explode('_', $momoData['orderId'])[0] ?? null;

        // Find the donation/order
        $donation = $this->donationRepository->find($orderId);

        if (!$donation) {
            return redirect()->away($this->apiConfig->returnUrl)->with([
                'success' => false,
                'message' => 'Không tìm thấy đơn hàng',
                'donation_id' => $orderId,
            ]);
        }

        if ($resultCode != 0) {
            return redirect()->away($this->apiConfig->returnUrl)->with([
                'success' => false,
                'message' => 'Thanh toán không thành công: ' . $message,
                'donation_id' => $donation->id,
                'order_id' => $orderId,
                'result_code' => $resultCode
            ]);
        }

        return redirect()->away($this->apiConfig->returnUrl)->with([
            'success' => true,
            'message' => 'Thanh toán thành công',
            'donation_id' => $donation->id,
            'order_id' => $orderId
        ]);
    }

    /**
     * Xử lý IPN trả về từ MoMo.
     */
    public function processIpn($momoData)
    {
        Log::info('Momo IPN Request', ['request' => $momoData]);

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

        Log::info('Momo IPN Signature Verification', [
            'calculated_signature' => $calculatedSignature,
            'signature' => $signature,
        ]);

        // Check if signature is valid
        if ($calculatedSignature != $signature) {
            Log::error('Momo IPN Signature Verification Failed', [
                'calculated_signature' => $calculatedSignature,
                'signature' => $signature,
                'donation_id' => $orderId,
            ]);

            return [
                'success' => false,
                'message' => 'Chữ ký không hợp lệ',
                'donation_id' => $orderId
            ];
        }

        $orderId = explode('_', $momoData['orderId'])[0] ?? null;

        // Find the donation/order
        $donation = $this->donationRepository->find($orderId);

        if (!$donation) {
            Log::error('Momo IPN Donation Not Found', [
                'donation_id' => $orderId,
            ]);

            return [
                'success' => false,
                'message' => 'Không tìm thấy đơn hàng',
                'donation_id' => $orderId
            ];
        }

        if ($resultCode != 0) {
            Log::error('Momo IPN Payment Failed', [
                'donation_id' => $donation->id,
                'order_id' => $orderId,
                'result_code' => $resultCode,
            ]);

            return [
                'success' => false,
                'message' => 'Thanh toán không thành công: ' . $message,
                'donation_id' => $donation->id,
                'order_id' => $orderId,
                'result_code' => $resultCode
            ];
        }

        $this->donationRepository->update($donation, [
            'status' => PaymentStatus::PAID->value,
            'payment_method_code' => PaymentMethodCode::MOMO->value,
            'amount' => $amount,
        ]);

        Log::info('Momo IPN Payment Successful', [
            'donation_id' => $donation->id,
            'order_id' => $orderId,
        ]);

        return [
            'success' => true,
            'message' => 'Thanh toán thành công',
            'donation_id' => $donation->id,
            'order_id' => $orderId,
        ];
    }
}
