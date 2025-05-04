<?php

namespace App\Livewire\Admin\Dashboard\Partials;

use App\Repositories\Volunteer\VolunteerRepositoryInterface;
use Livewire\Component;

class ChartVolunteer extends Component
{
    protected $volunteerRepository;
    public $projectId;

    public function boot(
        VolunteerRepositoryInterface $volunteerRepository,
    ) {
        $this->volunteerRepository = $volunteerRepository;
    }

    public function mount()
    {
        $this->dispatch('dispatch-for-chart-volunteer');
    }

    public function getData($range, $projectId)
    {
        return $this->volunteerRepository->getChartVolunteerData(
            $range,
            $projectId,
        );
    }

    public function placeholder()
    {
        return view('skeletons.chart');
    }

    public function render()
    {
        return view('livewire.admin.dashboard.partials.chart-volunteer');
    }
}
