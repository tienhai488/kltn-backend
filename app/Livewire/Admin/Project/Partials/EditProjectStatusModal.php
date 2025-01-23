<?php

namespace App\Livewire\Admin\Project\Partials;

use App\Enum\NotificationType;
use App\Enum\ProjectStatus;
use App\Repositories\Project\ProjectRepositoryInterface;
use Illuminate\Validation\Rule;
use Livewire\Component;

class EditProjectStatusModal extends Component
{
    protected $projectRepository;

    public $project;

    public $projectStatuses;

    public $status;

    public function boot(
        ProjectRepositoryInterface $projectRepository
    ) {
        $this->projectRepository = $projectRepository;
    }

    public function mount()
    {
        $this->status = $this->project->status;
        $this->projectStatuses = ProjectStatus::options();
    }

    /**
     * Validate the request.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'status' => ['required', Rule::enum(ProjectStatus::class)],
        ];
    }

    /**
     * Update the project status.
     */
    public function update()
    {
        $validated = $this->validate();

        $this->projectRepository->updateStatus($this->project, $validated['status']) ?
            session()->flash(NotificationType::NOTIFICATION_SUCCESS->value, __('Chỉnh sửa dự án thành công.'))
            : session()->flash(NotificationType::NOTIFICATION_ERROR->value, __('Chỉnh sửa dự án thất bại.'));

        return to_route('admin.project.show', $this->project);
    }

    public function render()
    {
        return view('livewire.admin.project.partials.edit-project-status-modal');
    }
}