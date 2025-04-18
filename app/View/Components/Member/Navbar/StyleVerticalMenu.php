<?php

namespace App\View\Components\Member\Navbar;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StyleVerticalMenu extends Component
{
    /**
     * The title.
     *
     * @var string
     */
    public $classes;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($classes)
    {
        $this->classes = $classes;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.member.navbar.style-vertical-menu');
    }
}