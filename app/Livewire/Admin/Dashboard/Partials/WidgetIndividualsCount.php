<?php

namespace App\Livewire\Admin\Dashboard\Partials;

use App\Acl\Acl;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Volunteer\VolunteerRepositoryInterface;
use Livewire\Component;

class WidgetIndividualsCount extends Component
{
    protected $userRepository;
    public $individualsCount;

    public function boot(
        UserRepositoryInterface $userRepository,
    ) {
        $this->userRepository = $userRepository;
    }

    public function mount()
    {
        $this->individualsCount = $this->userRepository->count(Acl::ROLE_INDIVIDUAL);
    }

    public function placeholder()
    {
        return view('skeletons.widget');
    }

    public function render()
    {
        return view('livewire.admin.dashboard.partials.widget-individuals-count');
    }
}
