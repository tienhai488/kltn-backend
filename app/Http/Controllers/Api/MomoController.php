<?php

namespace App\Http\Controllers\Api;

use App\Enum\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Momo\CreatePaymentRequest;
use App\Repositories\Donation\DonationRepositoryInterface;
use App\Services\MomoPaymentService;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;

/**
 * @tags Thanh toán MoMo
 */
class MomoController extends Controller
{
    use ApiResponses;

    public function __construct(
        protected MomoPaymentService $momoPaymentService,
        protected DonationRepositoryInterface $donationRepository,
    ) {
        //
    }

    /**
     * Tạo URL thanh toán MoMo.
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
        $response = $this->momoPaymentService->createPayment(
            $donation->id,
            round($donation->amount),
        );

        if (isset($response['status']) && $response['status'] === 'error') {
            return response()->json([
                'success' => false,
                'message' => $response['message']
            ], 400);
        }

        return response()->json([
            'success' => true,
            'payment_url' => $response['payUrl'] ?? null,
            'data' => $response
        ]);
    }

    /**
     * Xử lý IPN trả về từ MoMo (Xử lý cho Backend).
     *
     * URL này được MoMo gọi đến sau khi người dùng thanh toán thành công.
     * Xử lý IPN trả về, cập nhật trạng thái đơn hàng
     * và trả về kết quả cho MoMo.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleIpn(Request $request)
    {
        return $this->momoPaymentService->processIpn($request->all());
    }
}
