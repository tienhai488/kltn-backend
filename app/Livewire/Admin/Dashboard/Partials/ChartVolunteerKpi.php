<?php

namespace App\Livewire\Admin\Dashboard\Partials;

use Livewire\Component;

class ChartVolunteerKpi extends Component
{
    public function placeholder()
    {
        return view('skeletons.chart');
    }

    public function render()
    {
        return view('livewire.admin.dashboard.partials.chart-volunteer-kpi');
    }
}
