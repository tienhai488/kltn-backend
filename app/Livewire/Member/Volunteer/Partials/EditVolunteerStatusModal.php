<?php

namespace App\Livewire\Member\Volunteer\Partials;

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
            session()->flash(NotificationType::SUCCESS->value, __('Chỉnh sửa tình nguyện viên thành công.'))
            : session()->flash(NotificationType::ERROR->value, __('Chỉnh sửa tình nguyện viên thất bại.'));

        return to_route('member.volunteer.show', $this->volunteer);
    }

    public function render()
    {
        return view('livewire.member.volunteer.partials.edit-volunteer-status-modal');
    }
}