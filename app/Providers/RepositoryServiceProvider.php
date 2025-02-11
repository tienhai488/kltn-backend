<?php

namespace App\Providers;

use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Contact\ContactRepository;
use App\Repositories\Contact\ContactRepositoryInterface;
use App\Repositories\Department\DepartmentRepository;
use App\Repositories\Department\DepartmentRepositoryInterface;
use App\Repositories\Donation\DonationRepository;
use App\Repositories\Donation\DonationRepositoryInterface;
use App\Repositories\IndividualAccountRequest\IndividualAccountRequestRepository;
use App\Repositories\IndividualAccountRequest\IndividualAccountRequestRepositoryInterface;
use App\Repositories\OrganizationAccountRequest\OrganizationAccountRequestRepository;
use App\Repositories\OrganizationAccountRequest\OrganizationAccountRequestRepositoryInterface;
use App\Repositories\Permission\PermissionRepository;
use App\Repositories\Permission\PermissionRepositoryInterface;
use App\Repositories\Project\ProjectRepository;
use App\Repositories\Project\ProjectRepositoryInterface;
use App\Repositories\Role\RoleRepository;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Repositories\Setting\SettingRepository;
use App\Repositories\Setting\SettingRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Volunteer\VolunteerRepository;
use App\Repositories\Volunteer\VolunteerRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);
        $this->app->singleton(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->singleton(PermissionRepositoryInterface::class, PermissionRepository::class);
        $this->app->singleton(DepartmentRepositoryInterface::class, DepartmentRepository::class);
        $this->app->singleton(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->singleton(ContactRepositoryInterface::class, ContactRepository::class);
        $this->app->singleton(IndividualAccountRequestRepositoryInterface::class, IndividualAccountRequestRepository::class);
        $this->app->singleton(OrganizationAccountRequestRepositoryInterface::class, OrganizationAccountRequestRepository::class);
        $this->app->singleton(ProjectRepositoryInterface::class, ProjectRepository::class);
        $this->app->singleton(DonationRepositoryInterface::class, DonationRepository::class);
        $this->app->singleton(VolunteerRepositoryInterface::class, VolunteerRepository::class);
        $this->app->singleton(SettingRepositoryInterface::class, SettingRepository::class);
    }
}