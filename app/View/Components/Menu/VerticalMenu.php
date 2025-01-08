<?php

namespace App\View\Components\Menu;

use App\Acl\Acl;
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

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.menu.vertical-menu');
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
                'url' => route('admin.dashboard'),
                'icon' => 'home',
                'active' => Route::is(['admin.dashboard']),
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
            [
                'title' => __('Vai trò'),
                'url' => route('admin.role.index'),
                'icon' => 'shield',
                'active' => Route::is(['admin.role.*']),
                'show' => checkPermissions([Acl::PERMISSION_ROLE_LIST]),
                'child' => [],
            ],
            [
                'title' => __('Người dùng'),
                'url' => route('admin.user.index'),
                'icon' => 'users',
                'active' => Route::is(['admin.user.*']),
                'show' => checkPermissions([Acl::PERMISSION_USER_LIST]),
                'child' => [],
            ],
            [
                'title' => __('Cài đặt'),
                'url' => '',
                'icon' => 'settings',
                'active' => Route::is(['admin.setting.*']),
                'show' => checkPermissions([]),
                'child' => [
                    //
                ],
            ],
        ]);
    }

    private function setProperties(): void
    {
        $this->menuItems = [];
    }
}