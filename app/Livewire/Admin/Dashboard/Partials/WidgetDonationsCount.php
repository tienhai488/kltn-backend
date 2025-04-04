<?php

namespace App\Livewire\Admin\Dashboard\Partials;

use App\Enum\PaymentStatus;
use App\Repositories\Donation\DonationRepositoryInterface;
use Livewire\Component;

class WidgetDonationsCount extends Component
{
    protected $donationRepository;
    public $donationsCount;

    public function boot(
        DonationRepositoryInterface $donationRepository,
    ) {
        $this->donationRepository = $donationRepository;
    }

    public function mount()
    {
        $this->donationsCount = $this->donationRepository->advancedGet([
            'conditions' => [
                'where' => [
                    'status' => PaymentStatus::PAID->value,
                ],
            ],
        ])->count();
    }

    public function placeholder()
    {
        return view('skeletons.widget');
    }

    public function render()
    {
        return view('livewire.admin.dashboard.partials.widget-donations-count');
    }
}
