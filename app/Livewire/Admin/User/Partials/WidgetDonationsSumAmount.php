<?php

namespace App\Livewire\Admin\User\Partials;

use Livewire\Component;

class WidgetDonationsSumAmount extends Component
{
    public function placeholder()
    {
        return view('skeletons.widget');
    }

    public function render()
    {
        return view('livewire.admin.user.partials.widget-donations-sum-amount');
    }
}
