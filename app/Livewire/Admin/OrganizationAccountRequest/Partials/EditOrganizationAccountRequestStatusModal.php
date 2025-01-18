<?php

namespace App\Livewire\Admin\OrganizationAccountRequest\Partials;

use App\Enum\AccountRequestStatus;
use App\Enum\NotificationType;
use App\Repositories\OrganizationAccountRequest\OrganizationAccountRequestRepositoryInterface;
use Illuminate\Validation\Rule;
use Livewire\Component;

class EditOrganizationAccountRequestStatusModal extends Component
{
    protected $organizationAccountRequestRepository;

    public $organizationAccountRequest;

    public $accountRequestStatuses;

    public $status;

    public function boot(
        OrganizationAccountRequestRepositoryInterface $organizationAccountRequestRepository
    ) {
        $this->organizationAccountRequestRepository = $organizationAccountRequestRepository;
    }

    public function mount()
    {
        $this->status = $this->organizationAccountRequest->status;
        $this->accountRequestStatuses = AccountRequestStatus::options();
    }

    /**
     * Validate the request.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'status' => ['required', Rule::enum(AccountRequestStatus::class)],
        ];
    }

    /**
     * Update the organization account request status.
     */
    public function update()
    {
        $validated = $this->validate();

        $this->organizationAccountRequestRepository->update($this->organizationAccountRequest, $validated) ?
            session()->flash(NotificationType::NOTIFICATION_SUCCESS->value, __('Chỉnh sửa trạng thái yêu cầu tài khoản tổ chức thành công.'))
            : session()->flash(NotificationType::NOTIFICATION_ERROR->value, __('Chỉnh sửa trạng thái yêu cầu tài khoản tổ chức thất bại.'));

        return to_route('admin.organization_account_request.show', $this->organizationAccountRequest);
    }

    public function render()
    {
        return view('livewire.admin.organization-account-request.partials.edit-organization-account-request-status-modal');
    }
}