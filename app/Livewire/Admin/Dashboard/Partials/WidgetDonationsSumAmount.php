<?php

namespace App\Livewire\Admin\Dashboard\Partials;

use App\Enum\PaymentStatus;
use App\Repositories\Donation\DonationRepositoryInterface;
use Livewire\Component;

class WidgetDonationsSumAmount extends Component
{
    protected $donationRepository;
    public $donationsSumAmount;

    public function boot(
        DonationRepositoryInterface $donationRepository,
    ) {
        $this->donationRepository = $donationRepository;
    }

    public function mount()
    {
        $this->donationsSumAmount = $this->donationRepository->sumAmount();
    }

    public function placeholder()
    {
        return view('skeletons.widget');
    }

    public function render()
    {
        return view('livewire.admin.dashboard.partials.widget-donations-sum-amount');
    }
}
