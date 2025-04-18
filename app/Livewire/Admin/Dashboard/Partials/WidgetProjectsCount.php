<?php

namespace App\Livewire\Admin\Dashboard\Partials;

use App\Repositories\Project\ProjectRepositoryInterface;
use Livewire\Component;

class WidgetProjectsCount extends Component
{
    protected $projectRepository;
    public $projectsCount;

    public function boot(
        ProjectRepositoryInterface $projectRepository,
    ) {
        $this->projectRepository = $projectRepository;
    }

    public function mount()
    {
        $this->projectsCount = $this->projectRepository->count();
    }

    public function placeholder()
    {
        return view('skeletons.widget');
    }

    public function render()
    {
        return view('livewire.admin.dashboard.partials.widget-projects-count');
    }
}
