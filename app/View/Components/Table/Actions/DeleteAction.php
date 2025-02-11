<?php

namespace App\View\Components\Table\Actions;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DeleteAction extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $url = 'javascript:void(0)',
        public $permission = null,
        public $dataTableId = null
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table.actions.delete-action');
    }
}