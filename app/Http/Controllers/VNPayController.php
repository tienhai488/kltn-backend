<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\VNPayService;
use Illuminate\Http\Request;

class VNPayController extends Controller
{
    public function __construct(
        protected VNPayService $vnpayService,
    ) {
        //
    }

    /**
     * Handle the return URL from VNPay to process the payment result.
     *
     * @param Request $request
     * @return mixed
     */
    public function return(Request $request)
    {
        return $this->vnpayService->processReturnUrl($request->all());
    }
}
