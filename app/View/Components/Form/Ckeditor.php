<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Ckeditor extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $name,
        public $id = '',
        public $label = '',
        public $placeholder = '',
        public $value = '',
        public $oldName = '',
        public $isRequired = false,
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.ckeditor');
    }
}

