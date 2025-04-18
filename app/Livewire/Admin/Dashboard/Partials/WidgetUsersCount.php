<?php

namespace App\Livewire\Admin\Dashboard\Partials;

use App\Repositories\User\UserRepositoryInterface;
use Livewire\Component;

class WidgetUsersCount extends Component
{
    protected $userRepository;
    public $usersCount;

    public function boot(
        UserRepositoryInterface $userRepository,
    ) {
        $this->userRepository = $userRepository;
    }

    public function mount()
    {
        $this->usersCount = $this->userRepository->count();
    }

    public function placeholder()
    {
        return view('skeletons.widget');
    }

    public function render()
    {
        return view('livewire.admin.dashboard.partials.widget-users-count');
    }
}
