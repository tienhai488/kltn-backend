<?php

namespace App\Livewire\Admin\Dashboard\Partials;

use App\Repositories\Project\ProjectRepositoryInterface;
use Livewire\Attributes\On;
use Livewire\Component;

class WidgetCommonProjectsDonationsSumAmount extends Component
{
    protected $projectRepository;
    public $search;
    public $userId;
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
    public $projectsDonationsSumAmount;
    public $loaded = false;

    #[On('initFilter')]
    public function boot(
        ProjectRepositoryInterface $projectRepository,
    ) {
        $this->projectRepository = $projectRepository;
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
            'user_id' => $this->userId,
            'project_category_id' => $this->projectCategoryId,
            'project_id' => $this->projectId,
            'project_type' => $this->projectType,
            'project_status' => $this->projectStatus,
            'donation_volunteer_user_id' => $this->donationVolunteerUserId,
            'donation_status' => $this->donationStatus,
            'volunteer_status' => $this->volunteerStatus,
            'from_date' => $this->fromDate,
            'to_date' => $this->toDate,
            'donation_price_range' => $this->donationPriceRange,
        ];

        $this->projectsDonationsSumAmount = customFormatPrice($this->projectRepository->getProjectData($conditions)->sum('projects_donations_with_paid_sum_amount'), ' VNĐ');
    }

    #[On('filterDataForStatistic')]
    public function filterData(
        $search,
        $userId,
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
        $this->userId = $userId == '' ? null : $userId;
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
        return view('livewire.admin.dashboard.partials.widget-common-projects-donations-sum-amount');
    }
}
