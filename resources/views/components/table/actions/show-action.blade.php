@can($permission)
<li>
    <a href="{{ $url }}" data-bs-toggle="tooltip" data-bs-placement="top"
       title="{{ __('Xem') }}" data-original-title="{{ __('Xem') }}"
        {{ $attributes->merge(['class' => 'bs-tooltip']) }}
    >
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye p-1 br-6 mb-1"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>
        </svg>
    </a>
</li>
@endcan
