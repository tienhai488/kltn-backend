<?php

namespace App\Livewire\Admin\Dashboard\Partials;

use App\Repositories\Project\ProjectRepositoryInterface;
use Livewire\Attributes\On;
use Livewire\Component;

class WidgetProjectAmountPercent extends Component
{
    protected $projectRepository;

    public $projectId;
    public $project;
    public $percent;
    public $filtersApplied = false;

    #[On('initFilter')]
    public function boot(ProjectRepositoryInterface $projectRepository)
    {
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

        if (!$this->project) {
            return;
        }

        $this->percent = round(($this->project->total_amount / $this->project->donation_target) * 100);
    }

    #[On('filterDataForStatistic')]
    public function filterData($projectId)
    {
        $this->filtersApplied = true;
        $this->projectId = $projectId ?: null;
        $this->project = null;
        $this->loadData();
    }

    public function placeholder()
    {
        return view('skeletons.widget_card');
    }

    public function render()
    {
        return view('livewire.admin.dashboard.partials.widget-project-amount-percent');
    }
}