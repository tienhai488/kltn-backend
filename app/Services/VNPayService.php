<?php

namespace App\Services;

use App\Enum\ActiveStatus;
use App\Models\Donation;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class VNPayService
{
    /**
     * Tạo URL thanh toán VNPay
     *
     * @param array $data
     * @return string
     */
    public function createPaymentUrl($data)
    {
        $vnp_Url = config('vnpay.vnp_Url');
        $vnp_HashSecret = config('vnpay.vnp_HashSecret');
        $vnp_TmnCode = config('vnpay.vnp_TmnCode');
        $vnp_ReturnUrl = config('vnpay.vnp_ReturnUrl');

        $vnp_TxnRef = $data['donation_id']; // Mã đơn hàng
        $vnp_OrderInfo = $data['order_desc']; // Thông tin đơn hàng
        $vnp_OrderType = $data['order_type'] ?? 'other'; // Loại hàng hóa
        $vnp_Amount = $data['amount'] * 100; // Số tiền * 100
        $vnp_Locale = $data['language'] ?? 'vn'; // Ngôn ngữ
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
     * @return array
     */
    public function processReturnUrl($vnpayData)
    {
        $vnp_HashSecret = config('vnpay.vnp_HashSecret');
        $vnp_SecureHash = $vnpayData['vnp_SecureHash'];
        $donation_id = $vnpayData['vnp_TxnRef'];

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

        // Kiểm tra hash và mã phản hồi
        if ($secureHash == $vnp_SecureHash) {
            if ($vnpayData['vnp_ResponseCode'] == '00') {
                // Thanh toán thành công, cập nhật trạng thái đơn hàng
                $this->updateDonationStatus($donation_id, ActiveStatus::ACTIVE);
                return [
                    'success' => true,
                    'message' => 'Thanh toán thành công',
                    'donation_id' => $donation_id
                ];
            } else {
                // Thanh toán thất bại
                return [
                    'success' => false,
                    'message' => 'Thanh toán không thành công',
                    'donation_id' => $donation_id,
                    'response_code' => $vnpayData['vnp_ResponseCode']
                ];
            }
        } else {
            // Chữ ký không hợp lệ
            return [
                'success' => false,
                'message' => 'Chữ ký không hợp lệ',
                'donation_id' => $donation_id
            ];
        }
    }

    private function updateDonationStatus($donationId, $status)
    {
        try {
            $donation = Donation::findOrFail($donationId);
            $donation->update(['status' => $status]);

            // Ghi log thành công
            Log::info("Đã cập nhật trạng thái đơn hàng {$donationId} thành {$status->value}");
        } catch (\Exception $e) {
            // Ghi log lỗi
            Log::error("Lỗi cập nhật trạng thái đơn hàng {$donationId}: " . $e->getMessage());
        }
    }
}