<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{ __('Chỉnh sửa') }}
    </x-slot:pageTitle>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        @vite([
            'resources/scss/light/assets/components/accordions.scss',
            'resources/scss/dark/assets/components/accordions.scss',
       ])
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot:headerFiles>
    <!-- END GLOBAL MANDATORY STYLES -->

    <x-custom.breadcrumb
        :breadcrumb-items="[
            __('Vai trò') => '',
            __('Quản lý vai trò') => route('admin.role.index'),
            __('Chỉnh sửa vai trò') => ''
        ]"
    />

    <x-custom.stat-box
        :id="'role-management'"
        :custom-col="'col-lg-12'"
    >
        <x-slot:boxTitle>
            {{ __('Chỉnh sửa vai trò') }}
        </x-slot:boxTitle>

        <x-form.form-layout
            :form-id="'general-settings'"
            :form-url="route('admin.role.update', $role)"
            :form-method="'PUT'"
        >
            <input type="hidden" name="id" value="{{$role->id}}">

            <x-form.form-input
                :id="'sRoleName'"
                :label="__('Vai trò')"
                :name="'name'"
                :placeholder="__('Vai trò')"
                :isRequired="true"
                :value="$role->name"
            />

            <div class="form-check form-check-primary d-block new-control mb-3">
                <input class="form-check-input chk-parent"
                    type="checkbox"
                    id="form-check-default"
                    onclick="toggleAllCheckboxes(this)"
                    >
                <label class="form-check-label" for="form-check-default">{{ __('Chọn tất cả') }}</label>
            </div>

            @foreach ($groupedPermissions as $group => $permissions)
                <div class="no-outer-spacing accordion mb-2">
                    <div class="card no-outer-spacing">
                        <div class="card-header" id="heading-{{ Str::slug($group) }}">
                            <section class="mb-0 mt-0">
                                <div role="menu" class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapse-{{ Str::slug($group) }}" aria-expanded="false" aria-controls="collapse-{{ Str::slug($group) }}">
                                    {{ $group }}
                                    <div class="icons">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                                            <polyline points="6 9 12 15 18 9"></polyline>
                                        </svg>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <div id="collapse-{{ Str::slug($group) }}" class="collapse" aria-labelledby="heading-{{ Str::slug($group) }}" data-bs-parent="#accordionExample">
                            <div class="card-body">
                                @foreach ($permissions as $permission)
                                    <div class="form-check">
                                        <input
                                            type="checkbox"
                                            class="form-check-input"
                                            id="{{ Str::slug($group . '-' . $permission->name) }}"
                                            name="permissions[]"
                                            value="{{ $permission->name }}"
                                            @if(in_array($permission->name, $rolePermissions)) checked @endif>
                                        <label class="form-check-label" for="{{ Str::slug($group . '-' . $permission->name) }}">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @error('permissions')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>
            @endforeach
            <hr>
            <x-buttons.submit :label="__('Hoàn tất')"/>
        </x-form.form-layout>
    </x-custom.stat-box>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script>
            function toggleAllCheckboxes(source) {
               $('input[name="permissions[]"]').prop('checked', $(source).is(':checked'));
           }
       </script>
    </x-slot:footerFiles>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
