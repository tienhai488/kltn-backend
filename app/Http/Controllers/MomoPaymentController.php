<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Services\MomoPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MomoPaymentController extends Controller
{
    protected $momoService;

    public function __construct(MomoPaymentService $momoService)
    {
        $this->momoService = $momoService;
    }

    public function createPayment(Request $request)
    {
        // $validated = $request->validate([
        //     'order_id' => 'required|string',
        //     'amount' => 'required|numeric|min:1000',
        //     'order_info' => 'required|string',
        // ]);

        $response = $this->momoService->createPayment(
            // $validated['order_id'],
            // $validated['amount'],
            // $validated['order_info']
            9976,
            10000,
            'Test payment',
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

    public function handleReturn(Request $request)
    {
        Log::info('MoMo Return Data', $request->all());

        $data = $request->all();

        return $this->momoService->processReturnUrl($data);
    }

    public function handleIpn(Request $request)
    {
        Log::info('MoMo IPN Data', $request->all());

        $ipnData = $request->all();
        $verificationResult = $this->momoService->verifyIpn($ipnData);

        if ($verificationResult['status'] === 'success') {
            // Update order status in database based on payment result

            return response()->json([
                'status' => 'success',
                'message' => 'Successfully received IPN',
                'data' => $verificationResult['data']
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => $verificationResult['message']
        ], 400);
    }
}
