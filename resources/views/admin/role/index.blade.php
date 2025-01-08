<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{ __('Quản lý vai trò') }}
    </x-slot:pageTitle>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->

        <!--  END CUSTOM STYLE FILE  -->
    </x-slot:headerFiles>
    <!-- END GLOBAL MANDATORY STYLES -->

    <x-custom.breadcrumb
        :breadcrumb-items="[
            __('Vai trò') => '',
            __('Quản lý vai trò') => ''
        ]"
    />

    <x-custom.stat-box
        :id="'general-settings-box'"
        :custom-col="'col-lg-12'"
        :box_of_datatable="true"
    >
        <x-slot:boxTitle>
            {{ __('Quản lý vai trò') }}
        </x-slot:boxTitle>
        <x-slot:action>
            @haspermission(Acl::PERMISSION_ROLE_ADD)
            <div class="layout-top-spacing mx-3 col-12">
                <x-buttons.button-link
                    :label="__('Thêm mới vai trò')"
                    :url="route('admin.role.create')"
                />
            </div>
            @endhaspermission
        </x-slot:action>

        <x-table.datatable
            :menu-length="[7, 10, 50, 100, 500]"
            :page-length="10"
            :show-menu-length="true"
        >
            <x-slot:tableHeader>
                <tr>
                    <th class="text-center" style="width: 10%">No.</th>
                    <th style="width: 20%">{{ __('Vai trò') }}</th>
                    <th style="width: 60%">{{ __('Quyền') }}</th>
                    <th class="text-center" style="width: 10%">{{ __('Hành động') }}</th>
                </tr>
            </x-slot:tableHeader>
            <x-slot:tableBody>
                @foreach ($roles as $role)
                    <tr>
                        <td class="checkbox-column text-center">
                            {{ $loop->index + 1 }}
                        </td>
                        <td>
                            {{ $role->name }}
                        </td>
                        <td>
                            <div class="row">
                                @foreach ($role->permissions->take(10) as $permission)
                                    <div class="col-lg-4 col-md-6 col-12 mb-2">
                                        <span class="badge badge-pills badge-info">{{ $permission->name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </td>
                        <td class="text-center action two-icons">
                            <ul class="table-controls d-flex">
                                <x-table.actions.edit-action
                                    :permission="Acl::PERMISSION_ROLE_EDIT"
                                    :url="route('admin.role.edit', $role)"/>
                                <x-table.actions.delete-action
                                    :permission="Acl::PERMISSION_ROLE_DELETE"
                                    :url="route('admin.role.destroy', $role)"/>
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </x-slot:tableBody>
            <x-slot:customScript>
                "ordering": false,
            </x-slot:customScript>
        </x-table.datatable>
    </x-custom.stat-box>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>

    </x-slot:footerFiles>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
