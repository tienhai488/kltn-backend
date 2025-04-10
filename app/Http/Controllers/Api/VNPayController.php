<?php

namespace App\Http\Controllers\Api;

use App\Enum\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\VNPay\CreatePaymentRequest;
use App\Repositories\Donation\DonationRepositoryInterface;
use App\Services\VNPayService;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;

/**
 * @tags Thanh toán VNPay
 */
class VNPayController extends Controller
{
    use ApiResponses;

    public function __construct(
        protected VNPayService $vnpayService,
        protected DonationRepositoryInterface $donationRepository,
    ) {
        //
    }

    /**
     * Tạo URL thanh toán VNPay
     *
     * @response array{
     *   success: boolean,
     *   payment_url: string,
     * }
     *
     * @param CreatePaymentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createPayment(CreatePaymentRequest $request)
    {
        $donation = $this->donationRepository->find($request->donation_id);

        if ($donation->status == PaymentStatus::PAID) {
            return $this->errorResponse([
                'success' => false,
                'message' => 'Đơn hàng đã được thanh toán trước đó.',
            ], 400);
        }

        // Chuẩn bị dữ liệu cho VNPay
        $paymentData = [
            'donation_id' => $donation->id,
            'donation' => $donation->loadMissing('project'),
            'amount' => round($donation->amount),
            'ip_addr' => $request->ip()
        ];

        try {
            $paymentUrl = $this->vnpayService->createPaymentUrl($paymentData);

            return $this->okResponse([
                'success' => true,
                'payment_url' => $paymentUrl,
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage(),
            ], 500);
        }
    }
}