<?php

namespace App\Livewire\Admin\Contact\Partials;

use App\Enum\ContactStatus;
use App\Enum\NotificationType;
use App\Repositories\Contact\ContactRepositoryInterface;
use Illuminate\Validation\Rule;
use Livewire\Component;

class EditContactStatusModal extends Component
{
    protected $contactRepository;

    public $contact;

    public $contactStatuses;

    public $status;

    public function boot(
        ContactRepositoryInterface $contactRepository
    ) {
        $this->contactRepository = $contactRepository;
    }

    public function mount()
    {
        $this->status = $this->contact->status;
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
        ];
    }

    /**
     * Update the contact status.
     */
    public function update()
    {
        $validated = $this->validate();

        $this->contactRepository->update($this->contact, $validated) ?
            session()->flash(NotificationType::NOTIFICATION_SUCCESS->value, __('Chỉnh sửa trạng thái liên hệ thành công.'))
            : session()->flash(NotificationType::NOTIFICATION_ERROR->value, __('Chỉnh sửa trạng thái liên hệ thất bại.'));

        return to_route('admin.contact.show', $this->contact);
    }

    public function render()
    {
        return view('livewire.admin.contact.partials.edit-contact-status-modal');
    }
}