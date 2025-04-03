<div class="widget widget-one_hybrid widget-referral {{ $loaded ?? 'd-none' }}">
    <div class="widget-heading mb-0">
        <div class="w-title">
            <div wire:loading>
                <div class="w-icon placeholder-wave">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users placeholder">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                </div>
            </div>
            <div wire:loading class="placeholder-wave w-100">
                <p class="w-value placeholder w-100 mb-1"></p>
                <h5 class="placeholder"></h5>
            </div>

            @if ($loaded)
                <div wire:loading.remove class="w-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                </div>
                <div wire:loading.remove>
                    <p class="w-value">{{ $volunteersCount }}</p>
                    <h5>{{ __('Số lượt tham gia tình nguyện viên') }}</h5>
                </div>
            @else
            <div>
                <div class="w-icon placeholder-wave">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users placeholder">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                </div>
            </div>
            <div class="placeholder-wave w-100">
                <p class="w-value placeholder w-100 mb-1"></p>
                <h5 class="placeholder"></h5>
            </div>
            @endif
        </div>
    </div>
</div>
