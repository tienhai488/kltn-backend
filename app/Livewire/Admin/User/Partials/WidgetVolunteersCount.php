<?php

namespace App\Livewire\Admin\User\Partials;

use Livewire\Component;

class WidgetVolunteersCount extends Component
{
    public function placeholder()
    {
        return view('skeletons.widget');
    }

    public function render()
    {
        return view('livewire.admin.user.partials.widget-volunteers-count');
    }
}
