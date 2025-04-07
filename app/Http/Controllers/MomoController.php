<?php

namespace App\Http\Controllers;

use App\Services\MomoPaymentService;
use Illuminate\Http\Request;

class MomoController extends Controller
{
    public function __construct(
        protected MomoPaymentService $momoPaymentService,
    ) {
        //
    }

    /**
     * URL trả về sau khi thanh toán.
     *
     * Xử lý URL trả về từ MoMo sau khi người dùng thanh toán.
     *
     * @response \Illuminate\Http\JsonResponse
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function return(Request $request)
    {
        return $this->momoPaymentService->processReturnUrl($request->all());
    }
}
