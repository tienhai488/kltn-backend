<div class="row">
    <div id="users-box" class="col-lg-12 layout-spacing">
        <div wire:loading.remove class="statbox widget box box-shadow">
            <div id="chart-volunteer"></div>
            <div id="chart-volunteer-count"></div>
        </div>
    </div>
    <div wire:loading>
        <div id="users-box" class="col-lg-12 layout-spacing">
            <div class="statbox widget box box-shadow placeholder-wave">
                <div class="col-12 placeholder mb-4 w-100" style="height: 50px;">
                    <div class="row mb-4">
                        <div class="col-md-4">
                        </div>
                    </div>
                </div>
                <br>
                <div class="col-12 placeholder mb-4 w-100" style="height: 50px;">
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
        Livewire.on('dispatch-for-chart-volunteer', () => {
            $(document).ready(function () {
                let filterStartDateInput = document.querySelector('#from_date');
                let filterEndDateInput = document.querySelector('#to_date');

                let filterStartDate = flatpickr(filterStartDateInput, {
                    dateFormat: 'd/m/Y',
                    locale: 'vn',
                    onChange: function(selectedDates, dateStr, instance) {
                        let startDate = selectedDates[0];

                        filterEndDate.set('minDate', startDate);

                        let endDate = filterEndDate.selectedDates[0];
                        if (endDate && endDate < startDate) {
                            filterEndDate.clear();
                        }
                    }
                });

                let filterEndDate = flatpickr(filterEndDateInput, {
                    dateFormat: 'd/m/Y',
                    locale: 'vn',
                    onChange: function(selectedDates, dateStr, instance) {
                        let endDate = selectedDates[0];

                        filterStartDate.set('maxDate', endDate);

                        let startDate = filterStartDate.selectedDates[0];
                        if (startDate && startDate > endDate) {
                            filterStartDate.clear();
                        }
                    }
                });

                $('#filter-btn').on('click', function () {
                    processChange();
                });

                let getFilteredDateRange = (filterStartDate, filterEndDate) => {
                    let pad = (number) => number.toString().padStart(2, '0');

                    if(!filterStartDate && !filterEndDate) {
                        let count = 7;
                        let filterDate = new Date();
                        filterDate.setDate(filterDate.getDate() - count);

                        let range = [];
                        range.push(`${pad(filterDate.getDate())}/${pad(filterDate.getMonth() + 1)}/${filterDate.getFullYear()}`);

                        let i = 1;
                        while (i <= count) {
                            filterDate.setDate(filterDate.getDate() + i);
                            range.push(`${pad(filterDate.getDate())}/${pad(filterDate.getMonth() + 1)}/${filterDate.getFullYear()}`);

                            filterDate.setDate(filterDate.getDate() - i * 2);
                            range.unshift(`${pad(filterDate.getDate())}/${pad(filterDate.getMonth() + 1)}/${filterDate.getFullYear()}`);

                            filterDate.setDate(filterDate.getDate() + i);
                            i += 1;
                        }

                        return range;
                    }

                    if (filterStartDate) {
                        const [day, month, year] = filterStartDate.split('/').map(Number);
                        filterStartDate = new Date(year, month - 1, day);
                    }

                    if (filterEndDate) {
                        const [day, month, year] = filterEndDate.split('/').map(Number);
                        filterEndDate = new Date(year, month - 1, day);
                    }

                    let range = [];

                    let currentDate = filterStartDate;
                    while (currentDate <= filterEndDate) {
                        range.push(`${pad(currentDate.getDate())}/${pad(currentDate.getMonth() + 1)}/${currentDate.getFullYear()}`);
                        currentDate.setDate(currentDate.getDate() + 1);
                    }

                    return range;
                }

                let options = {
                    series: [{
                        name: '{{ __('Số lượt') }}',
                        type: 'line',
                        data: []
                    }],
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
                        size: 0
                    },
                    title: {
                        text: '{{ __('Số lượt tham gia TNV') }}',
                        align: 'center'
                    },
                    markers: {
                        size: 5,
                        shape: 'circle',
                        colors: ['#FF0000'],
                        strokeColors: '#ffffff',
                        strokeWidth: 2,
                    },
                    tooltip: {
                        shared: true,
                        intersect: false,
                        y: {
                            formatter: function (y) {
                                if (typeof y !== "undefined") {
                                    return y.toFixed(0);
                                }
                                return y;
                            }
                        }
                    }
                };

                let chartVolunteer = new ApexCharts(document.querySelector("#chart-volunteer"), options);
                chartVolunteer.render();

                function debounce(func, timeout = 500) {
                    let timer;
                    return (...args) => {
                        clearTimeout(timer);
                        timer = setTimeout(() => {
                            func.apply(this, args);
                        }, timeout);
                    };
                }

                const processChange = debounce(() => updateChartVolunteer());

                let updateChartVolunteer = () => {
                    let range = getFilteredDateRange(filterStartDateInput.value, filterEndDateInput.value);

                    if(!range.length){
                        chartVolunteer.updateOptions({
                            series: [{
                                data: range,
                            }],
                            labels: range,
                        });
                        return;
                    }

                    const formatCurrency = (value) => {
                        value = value.replace(/,/g, '');
                        return !isNaN(value) && value.length > 0 ? Number(value).toLocaleString('en') : '';
                    };

                    let projectId = $('#project_id').val();

                    $wire.getData(range, projectId).then(data => {
                        if (data) {
                            let chartData = range.map(date => data[date] ? Math.round(data[date].count) : 0);
                            chartVolunteer.updateOptions({
                                series: [{
                                    data: [...chartData],
                                }],
                                labels: range,
                                yaxis: {
                                    labels: {
                                        formatter: function (val) {
                                            if (typeof val != "undefined") {
                                                return val.toLocaleString('en');
                                            }
                                            return val;
                                        }
                                    }
                                },
                                tooltip: {
                                    shared: true,
                                    intersect: false,
                                    y: {
                                        formatter: function (val) {
                                            return val.toLocaleString('en');
                                        }
                                    }
                                }
                            });

                            const count = chartData.reduce((sum, item) => sum + item, 0);
                            const dateRange = `${range[0]} - ${range[range.length - 1]}`;
                            document.querySelector('#chart-volunteer-count').innerHTML = `
                                <h6>{{ __('Tổng số lượt tham gia TNV') }}: ${count.toLocaleString('en')}</h6>
                                <p>{{ __('Khoảng thời gian') }}: ${dateRange}</p>
                            `;
                        }
                    });
                }

                updateChartVolunteer();
            });
        });
    </script>
    @endscript
</div>
