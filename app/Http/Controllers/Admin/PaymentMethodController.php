<?php

namespace App\Http\Controllers\Admin;

use App\Acl\Acl;
use App\Enum\NotificationType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PaymentMethod\UpdatePaymentMethodRequest;
use App\Http\Requests\Admin\PaymentMethod\UpdateSettingPaymentMethodRequest;
use App\Http\Resources\Admin\PaymentMethodResource;
use App\Models\PaymentMethod;
use App\Repositories\PaymentMethod\PaymentMethodRepositoryInterface;
use App\Services\BankTransferPaymentService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PaymentMethodController extends Controller
{
    public function __construct(
        protected PaymentMethodRepositoryInterface $paymentMethodRepository,
        protected BankTransferPaymentService $BankTransferPaymentService,
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
     * Display the settings for a specific payment method.
     */
    public function setting(PaymentMethod $paymentMethod)
    {
        $apiConfig = $paymentMethod->code->getDTO()::fromArray($paymentMethod->api_config ?? []);
        $banks = $this->BankTransferPaymentService->getBanks();

        return view($paymentMethod->code->getView(), compact('paymentMethod', 'apiConfig', 'banks'));
    }

    /**
     * Update the payment method settings.
     */
    public function updateSetting(UpdateSettingPaymentMethodRequest $request, PaymentMethod $paymentMethod)
    {
        $this->paymentMethodRepository->update(
            $paymentMethod,
            ['api_config' => $paymentMethod->code->getDTO()::fromArray($request->validated())->toArray()]
        ) ?
            session()->flash(NotificationType::SUCCESS->value, __('Cài đặt phương thức thanh toán thành công.'))
            : session()->flash(NotificationType::ERROR->value, __('Cài đặt phương thức thanh toán thất bại.'));

        return back();
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

        session()->flash(NotificationType::SUCCESS->value, __('Chỉnh sửa phương thức thanh toán thành công.'));
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
