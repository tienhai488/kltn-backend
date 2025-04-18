<?php

namespace App\Livewire\Admin\Dashboard\Partials;

use App\Acl\Acl;
use App\Repositories\User\UserRepositoryInterface;
use Livewire\Component;

class WidgetOrganizationsCount extends Component
{
    protected $userRepository;
    public $organizationsCount;

    public function boot(
        UserRepositoryInterface $userRepository,
    ) {
        $this->userRepository = $userRepository;
    }

    public function mount()
    {
        $this->organizationsCount = $this->userRepository->count(Acl::ROLE_ORGANIZATION);
    }

    public function placeholder()
    {
        return view('skeletons.widget');
    }

    public function render()
    {
        return view('livewire.admin.dashboard.partials.widget-organizations-count');
    }
}
