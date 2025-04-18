<?php

namespace App\Livewire\Admin\Project\Partials;

use App\Repositories\Project\ProjectRepositoryInterface;
use Livewire\Attributes\On;
use Livewire\Component;

class WidgetProjectTimePercent extends Component
{
    protected $projectRepository;
    public $projectId;
    public $project;
    public $percent;
    public $filtersApplied = false;

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

        $this->percent = $this->project->time_percent;
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
        return view('livewire.admin.project.partials.widget-project-time-percent');
    }
}