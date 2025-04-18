<?php

namespace App\Livewire\Admin\Dashboard\Partials;

use App\Repositories\Project\ProjectRepositoryInterface;
use App\Repositories\Volunteer\VolunteerRepositoryInterface;
use Livewire\Attributes\On;
use Livewire\Component;

class ChartVolunteerKpi extends Component
{
    protected $volunteerRepository;
    protected $projectRepository;
    public $project;
    public $volunteersCount;

    #[On('initFilter')]
    public function boot(
        ProjectRepositoryInterface $projectRepository,
        VolunteerRepositoryInterface $volunteerRepository,
    ) {
        $this->projectRepository = $projectRepository;
        $this->volunteerRepository = $volunteerRepository;
    }

    public function getData()
    {
        if (empty($this->project)) {
            return [
                'data' => [],
                'kpi' => 0,
                'volunteersCount' => 0,
            ];
        }
        return [
            'data' => $this->volunteerRepository->getChartVolunteerKpiData($this->project),
            'kpi' => $this->project->volunteer_quantity ?? 0,
            'volunteersCount' => $this->volunteersCount,
        ];
    }

    #[On('filterDataForStatistic')]
    public function filterData(
        $projectId,
    ) {
        $this->project = $this->projectRepository->find($projectId);
        $this->volunteersCount = $this->project ? $this->volunteerRepository->getCountByProject($this->project) : 0;
        $this->dispatch('dispatch-for-blade-chart-volunteer-kpi');
    }

    public function placeholder()
    {
        return view('skeletons.chart');
    }

    public function render()
    {
        return view('livewire.admin.dashboard.partials.chart-volunteer-kpi');
    }
}
