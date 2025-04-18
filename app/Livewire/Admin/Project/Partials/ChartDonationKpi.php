<?php

namespace App\Livewire\Admin\Project\Partials;

use App\Repositories\Donation\DonationRepositoryInterface;
use App\Repositories\Project\ProjectRepositoryInterface;
use Livewire\Attributes\On;
use Livewire\Component;

class ChartDonationKpi extends Component
{
    protected $donationRepository;
    protected $projectRepository;
    public $project;
    public $totalAmount;

    #[On('initFilter')]
    public function boot(
        ProjectRepositoryInterface $projectRepository,
        DonationRepositoryInterface $donationRepository,
    ) {
        $this->projectRepository = $projectRepository;
        $this->donationRepository = $donationRepository;
    }

    public function getData()
    {
        if (empty($this->project)) {
            return [
                'data' => [],
                'kpi' => 0,
                'totalAmount' => 0,
            ];
        }
        return [
            'data' => $this->donationRepository->getChartDonationKpiData($this->project),
            'kpi' => $this->project->donation_target ?? 0,
            'totalAmount' => $this->totalAmount,
        ];
    }

    #[On('filterDataForStatistic')]
    public function filterData(
        $projectId,
    ) {
        $this->project = $this->projectRepository->find($projectId);
        $this->totalAmount = $this->project ? $this->donationRepository->getTotalAmountByProject($this->project) : 0;
        $this->dispatch('dispatch-for-blade-chart-donation-kpi');
    }

    public function placeholder()
    {
        return view('skeletons.chart');
    }

    public function render()
    {
        return view('livewire.admin.project.partials.chart-donation-kpi');
    }
}