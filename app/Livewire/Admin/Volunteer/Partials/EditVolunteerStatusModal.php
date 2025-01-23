<?php

namespace App\Livewire\Admin\Volunteer\Partials;

use App\Enum\NotificationType;
use App\Enum\VolunteerStatus;
use App\Repositories\Volunteer\VolunteerRepositoryInterface;
use Illuminate\Validation\Rule;
use Livewire\Component;

class EditVolunteerStatusModal extends Component
{
    protected $volunteerRepository;

    public $volunteer;

    public $status;

    public $note;

    public $volunteerStatuses;

    public function boot(
        VolunteerRepositoryInterface $volunteerRepository
    ) {
        $this->volunteerRepository = $volunteerRepository;
    }

    public function mount()
    {
        $this->volunteerStatuses = VolunteerStatus::options();
        $this->status = $this->volunteer->status;
        $this->note = $this->volunteer->note;
    }

    /**
     * Validate the request.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'status' => ['required', Rule::enum(VolunteerStatus::class)],
            'note' => 'required',
        ];
    }

    /**
     * Update the volunteer status.
     */
    public function update()
    {
        $validated = $this->validate();

        $this->volunteerRepository->update($this->volunteer, $validated) ?
            session()->flash(NotificationType::NOTIFICATION_SUCCESS->value, __('Chỉnh sửa tình nguyện viên thành công.'))
            : session()->flash(NotificationType::NOTIFICATION_ERROR->value, __('Chỉnh sửa tình nguyện viên thất bại.'));

        return to_route('admin.volunteer.show', $this->volunteer);
    }

    public function render()
    {
        return view('livewire.admin.volunteer.partials.edit-volunteer-status-modal');
    }
}