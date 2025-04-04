<?php

namespace App\Http\Controllers;

use App\Enum\ActiveStatus;
use App\Models\Donation;
use Illuminate\Http\Request;
use App\Services\VNPayService;
use App\Models\Order;

class PaymentController extends Controller
{
    public function __construct(
        protected VNPayService $vnpayService
    ) {
        //
    }

    /**
     * Tạo URL thanh toán VNPay
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createPayment(Request $request)
    {
        // $request->validate([
        //     'donation_id' => 'required|string',
        //     'amount' => 'required|numeric|min:1000',
        //     'order_desc' => 'nullable|string',
        //     'order_type' => 'nullable|string',
        //     // 'bank_code' => 'nullable|string',
        //     'language' => 'nullable|string|in:vn,en',
        // ]);

        // Lấy địa chỉ IP của người dùng
        $clientIp = $request->ip();

        // Chuẩn bị dữ liệu cho VNPay
        $paymentData = [
            'donation_id' => '9982',
            'amount' => 2000,
            'order_desc' => $request->order_desc ?? 'Thanh toán đơn hàng',
            'order_type' => $request->order_type ?? 'other',
            'bank_code' => $request->bank_code, // Chọn phương thức thanh toán
            'language' => $request->language ?? 'vn',
            'ip_addr' => $clientIp
        ];



        try {
            $donation = Donation::findOrFail($paymentData['donation_id']);

            if ($donation->status == ActiveStatus::ACTIVE) {
                return response()->json([
                    'success' => false,
                    'message' => 'Đơn hàng đã được thanh toán trước đó'
                ], 400);
            }

            // Tạo URL thanh toán
            $paymentUrl = $this->vnpayService->createPaymentUrl($paymentData);

            return response()->json([
                'success' => true,
                'payment_url' => $paymentUrl
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Xử lý callback từ VNPay
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function vnpayReturn(Request $request)
    {
        try {
            $result = $this->vnpayService->processReturnUrl($request->all());

            if ($result['success']) {
                return to_route('payment.success', ['donation_id' => $result['donation_id']]);
            } else {
                return to_route('payment.failed', [
                    'donation_id' => $result['donation_id'],
                    'message' => $result['message']
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('VNPay return error: ' . $e->getMessage());
            return to_route('payment.failed', [
                'message' => 'Có lỗi xảy ra trong quá trình thanh toán'
            ]);
        }
    }

    /**
     * Hiển thị trang thanh toán thành công
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function paymentSuccess(Request $request)
    {
        $donationId = $request->donation_id;
        $donation = Donation::findOrFail($donationId);

        return view('payment.success', compact('donation'));
    }

    /**
     * Hiển thị trang thanh toán thất bại
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function paymentFailed(Request $request)
    {
        $donationId = $request->donation_id;
        $message = $request->message;
        $donation = null;

        if ($donationId) {
            $donation = Donation::find($donationId);
        }

        return view('payment.failed', compact('donation', 'message'));
    }

    /**
     * Lấy trạng thái thanh toán của đơn hàng
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPaymentStatus(Request $request)
    {
        // $request->validate([
        //     'donation_id' => 'required|string'
        // ]);

        try {
            $donation = Donation::findOrFail(9982);

            return response()->json([
                'success' => true,
                'donation_id' => $donation->id,
                'paid' => $donation->status == ActiveStatus::ACTIVE,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy đơn hàng'
            ], 404);
        }
    }
}
