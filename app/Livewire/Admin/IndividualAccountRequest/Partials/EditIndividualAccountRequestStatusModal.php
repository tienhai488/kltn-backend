<?php

namespace App\Livewire\Admin\IndividualAccountRequest\Partials;

use App\Enum\AccountRequestStatus;
use App\Enum\NotificationType;
use App\Repositories\IndividualAccountRequest\IndividualAccountRequestRepositoryInterface;
use Illuminate\Validation\Rule;
use Livewire\Component;

class EditIndividualAccountRequestStatusModal extends Component
{
    protected $individualAccountRequestRepository;

    public $individualAccountRequest;

    public $accountRequestStatuses;

    public $status;

    public function boot(
        IndividualAccountRequestRepositoryInterface $individualAccountRequestRepository
    ) {
        $this->individualAccountRequestRepository = $individualAccountRequestRepository;
    }

    public function mount()
    {
        $this->status = $this->individualAccountRequest->status;
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
     * Update the individual account request status.
     */
    public function update()
    {
        $validated = $this->validate();

        $this->individualAccountRequestRepository->update($this->individualAccountRequest, $validated) ?
            session()->flash(NotificationType::NOTIFICATION_SUCCESS->value, __('Chỉnh sửa trạng thái yêu cầu tài khoản cá nhân thành công.'))
            : session()->flash(NotificationType::NOTIFICATION_ERROR->value, __('Chỉnh sửa trạng thái yêu cầu tài khoản cá nhân thất bại.'));

        return to_route('admin.individual_account_request.show', $this->individualAccountRequest);
    }

    public function render()
    {
        return view('livewire.admin.individual-account-request.partials.edit-individual-account-request-status-modal');
    }
}