<?php

namespace App\View\Components\Member;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BaseLayout extends Component
{
    /**
     * The alert type.
     *
     * @var string
     */
    public $scrollspy;

    /**
     * @var bool
     */
    public $isBoxed;

    /**
     * @var bool
     */
    public $isAltMenu;

    /**
     * @var bool
     */
    public $disableHeader;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($scrollspy, $isBoxed = true, $isAltMenu = false, $disableHeader = false)
    {
        $this->scrollspy = $scrollspy;
        $this->isBoxed = $isBoxed;
        $this->isAltMenu = $isAltMenu;
        $this->disableHeader = $disableHeader;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.member.base-layout');
    }
}