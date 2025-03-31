<?php

namespace App\Http\Controllers\Admin;

use App\Acl\Acl;
use App\Enum\NotificationType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PaymentMethod\UpdatePaymentMethodRequest;
use App\Http\Resources\Admin\PaymentMethodResource;
use App\Models\PaymentMethod;
use App\Repositories\PaymentMethod\PaymentMethodRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PaymentMethodController extends Controller
{
    public function __construct(
        protected PaymentMethodRepositoryInterface $paymentMethodRepository,
    ) {
        $this->middleware('permission:' . Acl::PERMISSION_PAYMENT_METHOD_LIST)->only('index');
        $this->middleware('permission:' . Acl::PERMISSION_PAYMENT_METHOD_EDIT)->only(['edit', 'update', 'toggleStatus']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $paymentMethods = $this->paymentMethodRepository->serverPaginationFilteringForAdmin($request->all());
            return PaymentMethodResource::collection($paymentMethods);
        }

        return view('admin.payment_method.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentMethod $paymentMethod)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentMethod $paymentMethod)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentMethodRequest $request, PaymentMethod $paymentMethod)
    {
        if (! $this->paymentMethodRepository->update($paymentMethod, $request->validated())) {
            return response()->json([
                'message' => __('Chỉnh sửa phương thức thanh toán thất bại.'),
            ], Response::HTTP_BAD_REQUEST);
        }

        session()->flash(NotificationType::NOTIFICATION_SUCCESS->value, __('Chỉnh sửa phương thức thanh toán thành công.'));
        return response()->json([
            'message' => __('Chỉnh sửa phương thức thanh toán thành công.'),
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        //
    }

    /**
     * Toggle the status of the specified resource in storage.
     */
    public function toggleStatus(PaymentMethod $paymentMethod)
    {
        return $this->paymentMethodRepository->toggleStatus($paymentMethod) ?
            response()->json([
                'message' => __('success.update'),
            ], Response::HTTP_OK)
            : response()->json([
                'message' => __('error.update'),
            ], Response::HTTP_BAD_REQUEST);
    }
}