<?php

namespace App\Http\Controllers\Admin;

use App\Acl\Acl;
use App\Enum\NotificationType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setting\UpdatePolicyRequest;
use App\Http\Requests\Admin\Setting\UpdateTermsRequest;
use App\Repositories\Setting\SettingRepositoryInterface;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct(
        protected SettingRepositoryInterface $settingRepository,
    ) {
        $this->middleware('permission:' . Acl::PERMISSION_SETTING_POLICY)->only(['policy', 'updatePolicy']);
        $this->middleware('permission:' . Acl::PERMISSION_SETTING_TERMS)->only(['terms', 'updateTerms']);
    }

    /**
     * Display the policy settings view.
     *
     * @return \Illuminate\View\View
     */

    public function policy()
    {
        $policy = $this->settingRepository->findByKey('policy');

        return view('admin.setting.policy', compact('policy'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\Setting\UpdatePolicyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePolicy(UpdatePolicyRequest $request)
    {
        $this->settingRepository->updateByKeys($request->validated()) ?
            session()->flash(NotificationType::NOTIFICATION_SUCCESS->value, __('Cài đặt chính sách thành công.'))
            : session()->flash(NotificationType::NOTIFICATION_ERROR->value, __('Cài đặt chính sách thất bại.'));

        return redirect()->back();
    }


    /**
     * Display the terms settings view.
     *
     * @return \Illuminate\View\View
     */

    public function terms()
    {
        $terms = $this->settingRepository->findByKey('terms');

        return view('admin.setting.terms', compact('terms'));
    }

    /**
     * Update the terms settings.
     *
     * @param  \App\Http\Requests\Admin\Setting\UpdateTermsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function updateTerms(UpdateTermsRequest $request)
    {
        $this->settingRepository->updateByKeys($request->validated()) ?
            session()->flash(NotificationType::NOTIFICATION_SUCCESS->value, __('Cài đặt điều khoản thành công.'))
            : session()->flash(NotificationType::NOTIFICATION_ERROR->value, __('Cài đặt điều khoản thất bại.'));

        return redirect()->back();
    }
}