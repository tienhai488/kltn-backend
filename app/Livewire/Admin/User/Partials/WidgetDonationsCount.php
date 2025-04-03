<?php

namespace App\Livewire\Admin\User\Partials;

use App\Enum\PaymentStatus;
use App\Repositories\Donation\DonationRepositoryInterface;
use Livewire\Attributes\On;
use Livewire\Component;

class WidgetDonationsCount extends Component
{
    protected $donationRepository;
    public $search;
    public $belongToUserId;
    public $projectCategoryId;
    public $projectId;
    public $projectType;
    public $projectStatus;
    public $donationVolunteerUserId;
    public $donationStatus;
    public $volunteerStatus;
    public $fromDate;
    public $toDate;
    public $donationPriceRange;
    public $donationsCount;
    public $loaded = false;

    #[On('initFilter')]
    public function boot(
        DonationRepositoryInterface $donationRepository,
    ) {
        $this->donationRepository = $donationRepository;
    }

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        if (!$this->loaded) {
            return;
        }
        $conditions = [
            'search' => $this->search,
            'belong_to_user_id' => $this->belongToUserId,
            'project_category_id' => $this->projectCategoryId,
            'project_id' => $this->projectId,
            'project_type' => $this->projectType,
            'project_status' => $this->projectStatus,
            'donation_volunteer_user_id' => $this->donationVolunteerUserId,
            'donation_status' => PaymentStatus::PAID->value,
            'volunteer_status' => $this->volunteerStatus,
            'from_date' => $this->fromDate,
            'to_date' => $this->toDate,
            'donation_price_range' => $this->donationPriceRange,
        ];

        $this->donationsCount = $this->donationRepository->getDonationData($conditions)->count();
    }

    #[On('filterDataForStatistic')]
    public function filterData(
        $search,
        $belongToUserId,
        $projectCategoryId,
        $projectId,
        $projectType,
        $projectStatus,
        $donationVolunteerUserId,
        $donationStatus,
        $volunteerStatus,
        $fromDate,
        $toDate,
        $donationPriceRange,
    ) {
        $this->loaded = true;
        $this->search = $search == '' ? null : $search;
        $this->belongToUserId = $belongToUserId == '' ? null : $belongToUserId;
        $this->projectCategoryId = $projectCategoryId == '' ? null :   $projectCategoryId;
        $this->projectId = $projectId == '' ? null :   $projectId;
        $this->projectType = $projectType == '' ? null :   $projectType;
        $this->projectStatus = $projectStatus == '' ? null :   $projectStatus;
        $this->donationVolunteerUserId = $donationVolunteerUserId == '' ? null :   $donationVolunteerUserId;
        $this->donationStatus = $donationStatus == '' ? null : $donationStatus;
        $this->volunteerStatus = $volunteerStatus == '' ? null :   $volunteerStatus;
        $this->fromDate = $fromDate == '' ? null : $fromDate;
        $this->toDate = $toDate == '' ? null : $toDate;
        $this->donationPriceRange = $donationPriceRange == '' ? null : $donationPriceRange;
        $this->loadData();
    }

    public function placeholder()
    {
        return view('skeletons.widget');
    }

    public function render()
    {
        return view('livewire.admin.user.partials.widget-donations-count');
    }
}