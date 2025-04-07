<?php

namespace App\Livewire\Admin\Dashboard\Partials;

use App\Repositories\Donation\DonationRepositoryInterface;
use Livewire\Attributes\On;
use Livewire\Component;

class ChartDonation extends Component
{
    protected $donationRepository;
    public $projectId;

    #[On('initFilter')]
    public function boot(
        DonationRepositoryInterface $donationRepository,
    ) {
        $this->donationRepository = $donationRepository;
    }

    public function mount()
    {
        $this->dispatch('dispatch-for-chart-donation');
    }

    public function getData($range, $projectId)
    {
        return $this->donationRepository->getChartDonationData(
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
        return view('livewire.admin.dashboard.partials.chart-donation');
    }
}
