<?php

namespace App\View\Components\Member\Menu;

use App\Acl\Acl;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class VerticalMenu extends Component
{
    public $menuItems;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->generateMenu();
    }

    private function generateMenu(): void
    {
        $this->setProperties();
        $this->buildMenuDashboard();
        $this->buildMenuSettings();
    }

    private function buildMenuDashboard(): void
    {
        $this->menuItems = array_merge($this->menuItems, [
            [
                'title' => __('Dashboard'),
                'url' => route('member.dashboard.index'),
                'icon' => 'home',
                'active' => Route::is(['member.dashboard.*']),
                'show' => checkPermissions([Acl::PERMISSION_VIEW_MENU_DASHBOARD]),
                'child' => [],
            ],
        ]);
    }

    private function buildMenuSettings(): void
    {
        $this->menuItems = array_merge($this->menuItems, [
            [
                'title' => __('Hệ Thống'),
            ],
            // [
            //     'title' => __('Dự án'),
            //     'url' => route('admin.project.index'),
            //     'icon' => 'folder-plus',
            //     'active' => Route::is([
            //         'admin.project.*',
            //     ]),
            //     'show' => checkPermissions([Acl::PERMISSION_PROJECT_LIST]),
            //     'child' => [
            //         //
            //     ],
            // ],
            // [
            //     'title' => __('Quyên góp'),
            //     'url' => route('admin.donation.index'),
            //     'icon' => 'dollar-sign',
            //     'active' => Route::is([
            //         'admin.donation.*',
            //     ]),
            //     'show' => checkPermissions([Acl::PERMISSION_DONATION_LIST]),
            //     'child' => [
            //         //
            //     ],
            // ],
            // [
            //     'title' => __('Tình nguyện viên'),
            //     'url' => route('admin.volunteer.index'),
            //     'icon' => 'user-check',
            //     'active' => Route::is([
            //         'admin.volunteer.*',
            //     ]),
            //     'show' => checkPermissions([Acl::PERMISSION_VOLUNTEER_LIST]),
            //     'child' => [
            //         //
            //     ],
            // ],
        ]);
    }

    private function setProperties(): void
    {
        $this->menuItems = [];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.member.menu.vertical-menu');
    }
}