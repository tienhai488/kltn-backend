<?php

namespace App\Livewire\Admin\Project\Partials;

use App\Repositories\Project\ProjectRepositoryInterface;
use Livewire\Attributes\On;
use Livewire\Component;

class WidgetProjectVolunteerPercent extends Component
{
    protected $projectRepository;
    public $projectId;
    public $project;
    public $percent;
    public $filtersApplied = false; // Track if this is the first event call

    #[On('initFilter')]
    public function boot(
        ProjectRepositoryInterface $projectRepository,
    ) {
        $this->projectRepository = $projectRepository;
    }

    public function loadData()
    {
        if (!$this->filtersApplied) {
            return;
        }

        if (!$this->projectId) {
            return;
        }

        $this->project = $this->projectRepository->find($this->projectId);

        if (empty($this->project)) {
            return;
        }

        if (empty($this->project->volunteer_quantity)) {
            $this->percent = 0;
            return;
        }

        $this->percent = round($this->project->volunteers_count / $this->project->volunteer_quantity * 100);
    }

    #[On('filterDataForStatistic')]
    public function filterData(
        $projectId,
    ) {
        $this->filtersApplied = true;
        $this->project = null;
        $this->projectId = $projectId == '' ? null :   $projectId;
        $this->loadData();
    }

    public function placeholder()
    {
        return view('skeletons.widget_card');
    }

    public function render()
    {
        return view('livewire.admin.project.partials.widget-project-volunteer-percent');
    }
}