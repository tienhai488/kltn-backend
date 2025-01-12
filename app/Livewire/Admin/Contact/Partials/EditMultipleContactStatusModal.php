<?php

namespace App\Livewire\Admin\Contact\Partials;

use App\Enum\ContactStatus;
use App\Enum\NotificationType;
use App\Repositories\Contact\ContactRepositoryInterface;
use Illuminate\Validation\Rule;
use Livewire\Component;

class EditMultipleContactStatusModal extends Component
{
    protected $contactRepository;

    public $contactStatuses;

    public $status;

    public $contactIds;

    public function boot(
        ContactRepositoryInterface $contactRepository
    ) {
        $this->contactRepository = $contactRepository;
    }

    public function mount()
    {
        $this->dispatch('dispatch-for-blade');

        $this->contactStatuses = ContactStatus::options();
    }

    /**
     * Validate the request.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'status' => ['required', Rule::enum(ContactStatus::class)],
            'contactIds' => 'required|array',
            'contactIds.*' => 'required|exists:contacts,id',
        ];
    }

    /**
     * Update the contact status.
     */
    public function update()
    {
        $validated = $this->validate();

        $this->contactRepository->updateMultiple($validated) ?
            session()->flash(NotificationType::NOTIFICATION_SUCCESS->value, __('Chỉnh sửa trạng thái liên hệ thành công.')) :
            session()->flash(NotificationType::NOTIFICATION_ERROR->value, __('Chỉnh sửa trạng thái liên hệ thất bại.'));

        return to_route('admin.contact.index');
    }

    public function render()
    {
        return view('livewire.admin.contact.partials.edit-multiple-contact-status-modal');
    }
}