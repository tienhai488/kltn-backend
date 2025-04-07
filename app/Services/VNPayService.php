<?php

namespace App\Services;

use App\DTOs\VNPayApiConfigDTO;
use App\Enum\PaymentMethodCode;
use App\Enum\PaymentStatus;
use App\Models\Donation;
use App\Repositories\Donation\DonationRepositoryInterface;
use App\Repositories\PaymentMethod\PaymentMethodRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class VNPayService
{
    protected $apiConfig;

    public function __construct(
        protected PaymentMethodRepositoryInterface $paymentMethodRepository,
        protected DonationRepositoryInterface $donationRepository,
    ) {
        $paymentMethod = $this->paymentMethodRepository->advancedGetFirst([
            'conditions' => [
                'where' => [
                    'code' => PaymentMethodCode::VNPAY->value,
                ],
            ],
        ]);
        $this->apiConfig = VNPayApiConfigDTO::fromArray($paymentMethod->api_config ?? []);
    }

    /**
     * Tạo URL thanh toán VNPay
     *
     * @param array $data
     * @return string
     */
    public function createPaymentUrl($data)
    {
        $vnp_Url = $this->apiConfig->vnpUrl;
        $vnp_HashSecret = $this->apiConfig->vnpHashSecret;
        $vnp_TmnCode = $this->apiConfig->vnpTmnCode;
        $vnp_ReturnUrl = route('payment_method.vnpay.return');

        $vnp_TxnRef = '#' . $data['donation_id']; // Mã đơn hàng
        $vnp_OrderInfo = $data['order_desc'] ?? 'Thanh toán đơn hàng'; // Thông tin đơn hàng
        $vnp_OrderType = $data['order_type'] ?? 'other'; // Loại hàng hóa
        $vnp_Amount = $data['amount'] * 100; // Số tiền * 100
        $vnp_Locale = 'vn'; // Ngôn ngữ
        $vnp_IpAddr = $data['ip_addr']; // Địa chỉ IP
        $vnp_BankCode = $data['bank_code'] ?? ''; // Mã ngân hàng (tùy chọn)

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => Carbon::now()->format('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_ReturnUrl,
            "vnp_TxnRef" => $vnp_TxnRef,
        ];

        if (!empty($vnp_BankCode)) {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        // Sắp xếp dữ liệu theo thứ tự a-z
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";

        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        // Tạo chuỗi hash để kiểm tra
        $vnp_Url = $vnp_Url . "?" . $query;
        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;

        return $vnp_Url;
    }

    /**
     * Xử lý dữ liệu trả về từ VNPay
     *
     * @param array $vnpayData
     */
    public function processReturnUrl($vnpayData)
    {
        // {
        //     "vnp_Amount": "4032400",
        //     "vnp_BankCode": "NCB",
        //     "vnp_BankTranNo": "VNP14892673",
        //     "vnp_CardType": "ATM",
        //     "vnp_OrderInfo": "Thanh toán đơn hàng",
        //     "vnp_PayDate": "20250406222110",
        //     "vnp_ResponseCode": "00",
        //     "vnp_TmnCode": "P8ANVBP7",
        //     "vnp_TransactionNo": "14892673",
        //     "vnp_TransactionStatus": "00",
        //     "vnp_TxnRef": "#25",
        //     "vnp_SecureHash": "531bcd7cd775fa1bc3f182a7d453591d47add76cbecf8300f83e4dc24be305eb2307433c5b882eb118d8cba3081e7758a8b36850ae096fd39b5881a56771934b"
        //   }

        $vnp_HashSecret = $this->apiConfig->vnpHashSecret;
        $vnp_SecureHash = $vnpayData['vnp_SecureHash'];
        $donation_id = str_replace('#', '', $vnpayData['vnp_TxnRef']);

        // Xóa vnp_SecureHash để tạo chuỗi hash mới
        unset($vnpayData['vnp_SecureHash']);

        // Sắp xếp dữ liệu theo thứ tự a-z
        ksort($vnpayData);
        $i = 0;
        $hashData = "";

        foreach ($vnpayData as $key => $value) {
            if ($i == 1) {
                $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        // Tạo chuỗi hash mới để so sánh
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        if ($secureHash != $vnp_SecureHash) {
            return redirect()->away($this->apiConfig->vnpReturnUrl)
                ->with([
                    'success' => false,
                    'message' => 'Chữ ký không hợp lệ',
                    'donation_id' => $donation_id,
                ]);
        }

        if ($vnpayData['vnp_ResponseCode'] != '00') {
            return redirect()->away($this->apiConfig->vnpReturnUrl)
                ->with([
                    'success' => false,
                    'message' => 'Thanh toán không thành công',
                    'donation_id' => $donation_id,
                    'response_code' => $vnpayData['vnp_ResponseCode'],
                ]);
        }

        $this->updateDonation($donation_id, $vnpayData);

        return redirect()->away($this->apiConfig->vnpReturnUrl)
            ->with([
                'success' => true,
                'message' => 'Thanh toán thành công',
                'donation_id' => $donation_id
            ]);
    }

    /**
     * Update donation status after payment success.
     *
     * @param int $donationId
     * @param array $data
     */
    private function updateDonation($donationId, $data)
    {
        try {
            $donation = Donation::findOrFail($donationId);

            $dataUpdate = [
                'status' => PaymentStatus::PAID->value,
                'amount' => $data['vnp_Amount'] / 100,
                'payment_method_code' => PaymentMethodCode::VNPAY->value,
            ];

            $this->donationRepository->update($donation, $dataUpdate);

            // Ghi log thành công
            Log::info("Cập nhật đơn hàng {$donationId} thành công với dữ liệu: " . json_encode($data));
        } catch (\Exception $e) {
            // Ghi log lỗi
            Log::error("Lỗi cập nhật đơn hàng {$donationId}: " . $e->getMessage());
        }
    }
}
