<div class="row">
    @if ($project)
    <div id="users-box" class="col-lg-12 layout-spacing">
        <div wire:loading.remove class="statbox widget box box-shadow">
            <div id="chart-volunteer-kpi"></div>
            <div id="revenue-info">
                <h6>{{ __('KPI') }}: {{ number_format($project->volunteer_quantity) }}</h6>
                <h6>{{ __('Thực tế') }}: {{ number_format($volunteersCount) }}</h6>
                <p>{{ __('Thời gian diễn ra') }}: {{ customFormatDate($project->start_date) }} - {{ customFormatDate($project->end_date) }}</p>
            </div>
        </div>
    </div>
    <div wire:loading>
        <div id="users-box" class="col-lg-12 layout-spacing">
            <div class="statbox widget box box-shadow placeholder-wave">
                <div class="col-12 placeholder mb-1 w-100" style="height: 50px;">
                    <div class="row mb-4">
                        <div class="col-md-4">
                        </div>
                    </div>
                </div>
                <br>
                <div class="col-12 placeholder mb-1 w-100" style="height: 50px;">
                    <div class="row mb-4">
                        <div class="col-md-4">
                        </div>
                    </div>
                </div>
                <div class="placeholder w-100" style="height: 400px;">
                </div>
            </div>
        </div>
    </div>

    @script
    <script>
        Livewire.on('dispatch-for-blade-chart-volunteer-kpi', () => {
            $(document).ready(function () {
                function formatCurrencyVND(number) {
                    if (isNaN(number)) {
                        return '0đ';
                    }

                    return new Intl.NumberFormat('vi-VN', {
                        style: 'currency',
                        currency: 'VND',
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    }).format(number);
                }

                let chartVolunteerKpi;
                let options = {
                    series: [
                        {
                            name: '{{ __('Đạt được') }}',
                            type: 'line',
                            data: []
                        },
                        {
                            name: '{{ __('KPI') }}',
                            type: 'line',
                            data: [],
                            color: '#FF0000',
                        }
                    ],
                    chart: {
                        height: 350,
                        type: 'line',
                        stacked: false,
                        toolbar: {
                            show: true,
                            offsetX: 0,
                            offsetY: 25,
                        },
                    },
                    stroke: {
                        width: [2],
                        curve: 'straight'
                    },
                    plotOptions: {
                        bar: {
                            columnWidth: '50%'
                        }
                    },
                    fill: {
                        opacity: [1],
                        gradient: {
                            inverseColors: false,
                            shade: 'light',
                            type: "vertical",
                            opacityFrom: 0.85,
                            opacityTo: 0.55,
                            stops: [0, 100, 100, 100]
                        }
                    },
                    labels: [],
                    markers: {
                        size: 5,
                        shape: 'circle',
                        colors: ['#FF0000'],
                        strokeColors: '#ffffff',
                        strokeWidth: 2,
                    },
                    title: {
                        text: '{{ __('Tổng tình nguyện viên của chiến dịch') }}',
                        align: 'center'
                    },
                    tooltip: {
                        shared: true,
                        intersect: false,
                        y: {
                            formatter: function (value) {
                                return value;
                            }
                        }
                    },
                    yaxis: {
                        min: 0,
                        max: 0,
                        labels: {
                            formatter: function (value) {
                                return Math.round(value);
                            }
                        },
                    },
                    annotations: {
                        yaxis: []
                    }
                };

                if (!chartVolunteerKpi) {
                    chartVolunteerKpi = new ApexCharts(document.querySelector("#chart-volunteer-kpi"), options);
                    chartVolunteerKpi.render();
                }

                let updateChartVolunteerKpi = () => {
                    $wire.getData().then(data => {
                        if (data) {
                            let range = data.data.map(item => item.date);
                            let chartData = data.data.map(item => item.count ?? 0);

                            chartVolunteerKpi.updateOptions({
                                series: [
                                    {
                                        data: chartData,
                                    }
                                ],
                                labels: range,
                                yaxis: {
                                    min: 0,
                                    max: Math.max(data.kpi, data.volunteersCount),
                                    labels: {
                                        formatter: function (value) {
                                            return Math.round(value);
                                        }
                                    },
                                },
                                annotations: {
                                    yaxis: [
                                        {
                                            y: data.kpi,
                                            borderColor: '#FF0000',
                                            borderWidth: 2,
                                            strokeDashArray: 0,
                                            label: {
                                                borderColor: '#FF0000',
                                                style: {
                                                    color: '#fff',
                                                    background: '#FF0000',
                                                },
                                                text: `KPI: ${(data.kpi)}`,
                                            }
                                        }
                                    ]
                                }
                            });
                        }
                    });
                };

                updateChartVolunteerKpi();
            });
        });
    </script>
    @endscript
    @endif
</div>
