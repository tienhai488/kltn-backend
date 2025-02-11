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
                'title' => __('Cài đặt'),
                'url' => '',
                'icon' => 'settings',
                'active' => Route::is([
                    'admin.setting.*',
                ]),
                'show' => checkPermissions([Acl::PERMISSION_SETTING_POLICY, Acl::PERMISSION_SETTING_TERMS]),
                'child' => [
                    [
                        'title' => __('Chính sách'),
                        'url' => route('admin.setting.policy'),
                        'active' => Route::is(['admin.setting.policy']),
                        'show' => checkPermissions([Acl::PERMISSION_SETTING_POLICY]),
                    ],
                    [
                        'title' => __('Điều khoản'),
                        'url' => route('admin.setting.terms'),
                        'active' => Route::is(['admin.setting.terms']),
                        'show' => checkPermissions([Acl::PERMISSION_SETTING_TERMS]),
                    ],
                ],
            ],
            [
                'title' => __('Tài liệu API'),
                'url' => 'docs',
                'icon' => 'grid',
                'active' => '',
                'show' => checkPermissions([Acl::PERMISSION_VIEW_DOC_API]),
                'child' => [],
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
            [
                'title' => __('Phòng ban'),
                'url' => route('admin.department.index'),
                'icon' => 'users',
                'active' => Route::is(['admin.department.*']),
                'show' => checkPermissions([Acl::PERMISSION_DEPARTMENT_LIST]),
                'child' => [
                    //
                ],
            ],
            [
                'title' => __('Danh mục'),
                'url' => route('admin.category.index'),
                'icon' => 'bookmark',
                'active' => Route::is(['admin.category.*']),
                'show' => checkPermissions([Acl::PERMISSION_CATEGORY_LIST]),
                'child' => [
                    //
                ],
            ],
            [
                'title' => __('Liên hệ'),
                'url' => route('admin.contact.index'),
                'icon' => 'mail',
                'active' => Route::is(['admin.contact.*']),
                'show' => checkPermissions([Acl::PERMISSION_CONTACT_LIST]),
                'child' => [
                    //
                ],
            ],
            [
                'title' => __('Yêu cầu tài khoản'),
                'url' => '',
                'icon' => 'user-plus',
                'active' => Route::is([
                    'admin.individual_account_request.*',
                    'admin.organization_account_request.*',
                ]),
                'show' => checkPermissions([Acl::PERMISSION_ACCOUNT_REQUEST_LIST]),
                'child' => [
                    [
                        'title' => __('Tổ chức'),
                        'url' => route('admin.organization_account_request.index'),
                        'active' => Route::is(['admin.organization_account_request.*']),
                        'show' => checkPermissions([Acl::PERMISSION_ACCOUNT_REQUEST_LIST]),
                    ],
                    [
                        'title' => __('Cá nhân'),
                        'url' => route('admin.individual_account_request.index'),
                        'active' => Route::is(['admin.individual_account_request.*']),
                        'show' => checkPermissions([Acl::PERMISSION_ACCOUNT_REQUEST_LIST]),
                    ],
                ],
            ],
            [
                'title' => __('Dự án'),
                'url' => route('admin.project.index'),
                'icon' => 'folder-plus',
                'active' => Route::is([
                    'admin.project.*',
                ]),
                'show' => checkPermissions([Acl::PERMISSION_PROJECT_LIST]),
                'child' => [
                    //
                ],
            ],
            [
                'title' => __('Quyên góp'),
                'url' => route('admin.donation.index'),
                'icon' => 'dollar-sign',
                'active' => Route::is([
                    'admin.donation.*',
                ]),
                'show' => checkPermissions([Acl::PERMISSION_DONATION_LIST]),
                'child' => [
                    //
                ],
            ],
            [
                'title' => __('Tình nguyện viên'),
                'url' => route('admin.volunteer.index'),
                'icon' => 'user-check',
                'active' => Route::is([
                    'admin.volunteer.*',
                ]),
                'show' => checkPermissions([Acl::PERMISSION_VOLUNTEER_LIST]),
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