<div>
    @if (!empty($project))
    <div class="widget widget-card-four">
        <div class="widget-content">
            <div class="w-header">
                <div class="w-info placeholder-wave w-100" wire:loading>
                    <h6 class="value placeholder w-100" style="border-radius: 10px; height: 30px; background-color: #adadad;"></h6>
                </div>
                <div class="w-info" wire:loading.remove>
                    <h6 class="value">{{ __('Thời gian') }}</h6>
                </div>
            </div>
            <div class="w-content">
                <div class="placeholder-wave w-100" wire:loading>
                    <p class="w-100 placeholder" style="height: 60px; border-radius: 10px; background-color: #adadad;"></p>
                </div>
                <div class="w-info" wire:loading.remove>
                    <p class="value">
                        <h6>{{ customFormatDate($project->start_date) }} -> {{ customFormatDate($project->end_date) }}</h6>
                    </p>
                </div>
            </div>
            <div class="w-progress-stats">
                <div class="progress placeholder-wave w-100 m-0" style="background-color: #adadad !important;" wire:loading>
                    <div class="placeholder" style="height: 10px; border-radius: 10px; background-color: #adadad !important;"></div>
                </div>

                <div class="progress" wire:loading.remove>
                    <div class="progress-bar bg-gradient-secondary" role="progressbar" style="width: {{ $percent }}%" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div wire:loading.remove>
                    <div class="w-icon">
                        <p>{{ $percent }}%</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
</div>
