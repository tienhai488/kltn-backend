<?php

namespace App\Livewire\Admin\Dashboard\Partials;

use App\Enum\VolunteerStatus;
use App\Repositories\Volunteer\VolunteerRepositoryInterface;
use Livewire\Component;

class WidgetVolunteersCount extends Component
{
    protected $volunteerRepository;
    public $volunteersCount;

    public function boot(
        VolunteerRepositoryInterface $volunteerRepository,
    ) {
        $this->volunteerRepository = $volunteerRepository;
    }

    public function mount()
    {
        $this->volunteersCount = $this->volunteerRepository->advancedGet([
            'conditions' => [
                'where' => [
                    [
                        'status',
                        '!=',
                        VolunteerStatus::CANCELED->value,
                    ],
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
        return view('livewire.admin.dashboard.partials.widget-volunteers-count');
    }
}
