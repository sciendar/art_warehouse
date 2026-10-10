@extends('admin._layouts._layout')

@section('content')
    <div class="row">
        <div class="col-12 col-xl-6 d-flex">
            <div class="card radius-10 w-100">
                <div class="card-header bg-transparent">
                    <div class="row g-3 align-items-center">
                        <div class="col">
                            <h5 class="mb-0">Посещений за сутки</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row row-cols-1 row-cols-lg-2 g-3 align-items-center">
                        <div class="col">
                            <div class="d-flex align-items-center justify-content-sm-end gap-3 cursor-pointer">
                                <div class="font-13"><i class="bi bi-circle-fill text-primary"></i><span class="ms-2">Всего</span></div>
                                <div class="font-13"><i class="bi bi-circle-fill text-pink"></i><span class="ms-2">Уникальные</span></div>
                            </div>
                        </div>
                    </div>
                    <div id="chart_visits"></div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-6 d-flex">
            <div class="card radius-10 w-100">
                <div class="card-header bg-transparent">
                    <div class="row g-3 align-items-center">
                        <div class="col">
                            <h5 class="mb-0">Популярные страницы за сутки</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-lg-flex gap-4 w-100"><!-- align-items-center justify-content-center -->
                        {{--                        <div id="best_pages"></div>--}}
                        <ul class="list-group list-group-flush w-100">
                            @foreach($best_pages as $best_page)
                                <li class="list-group-item text-truncate">
                                    <span class="me-1">{{ $best_page->sum_visits }}</span> – <a href="{{ config('app.url') . Str::chopStart($best_page->path, '/') }}" target="_blank">{{ $best_page->path }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-xl-6 d-flex">
            <div class="card radius-10 w-100">
                <div class="card-header bg-transparent">
                    <div class="row g-3 align-items-center">
                        <div class="col">
                            <h5 class="mb-0">Посещений за месяц</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row row-cols-1 row-cols-lg-2 g-3 align-items-center">
                        <div class="col">
                            <div class="d-flex align-items-center justify-content-sm-end gap-3 cursor-pointer">
                                <div class="font-13"><i class="bi bi-circle-fill text-primary"></i><span class="ms-2">Всего</span></div>
                                <div class="font-13"><i class="bi bi-circle-fill text-pink"></i><span class="ms-2">Уникальные</span></div>
                            </div>
                        </div>
                    </div>
                    <div id="chart_month_visits"></div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-6 d-flex">
            <div class="card radius-10 w-100">
                <div class="card-header bg-transparent">
                    <div class="row g-3 align-items-center">
                        <div class="col">
                            <h5 class="mb-0">Популярные страницы за месяц</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-lg-flex gap-4 w-100"><!-- align-items-center justify-content-center -->
                        {{--                        <div id="best_pages"></div>--}}
                        <ul class="list-group list-group-flush w-100">
                            @foreach($best_month_pages as $best_page)
                                <li class="list-group-item text-truncate">
                                    <span class="me-1">{{ $best_page->sum_visits }}</span> – <a href="{{ config('app.url') . Str::chopStart($best_page->path, '/') }}" target="_blank">{{ $best_page->path }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('admin/assets/plugins/apexcharts-bundle/js/apexcharts.min.js') }}"></script>

    <script>
        // chart 4
        var options = {
            series: [{
                name: "Всего",
                data: @json($visits_counts)
            },{
                name: "Уникальные",
                data: @json($unique_visitors)
            }],
            chart: {
                foreColor: '#9a9797',
                type: "bar",
                //width: 130,
                height: 280,
                toolbar: {
                    show: !1
                },
                zoom: {
                    enabled: !1
                },
                dropShadow: {
                    enabled: 0,
                    top: 3,
                    left: 14,
                    blur: 4,
                    opacity: .12,
                    color: "#3361ff"
                },
                sparkline: {
                    enabled: !1
                }
            },
            markers: {
                size: 0,
                colors: ["#3361ff"],
                strokeColors: "#fff",
                strokeWidth: 2,
                hover: {
                    size: 7
                }
            },
            grid: {
                show: true,
                borderColor: '#eee',
                strokeDashArray: 4,
            },
            plotOptions: {
                bar: {
                    horizontal: !1,
                    columnWidth: "50%",
                    endingShape: "rounded"
                }
            },
            legend: {
                show: false,
                position: 'top',
                horizontalAlign: 'left',
                offsetX: -20
            },
            dataLabels: {
                enabled: !1
            },
            stroke: {
                colors: ["transparent"],
                show: !0,
                width: 5,
                curve: "smooth"
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'light',
                    type: "vertical",
                    shadeIntensity: 0.5,
                    gradientToColors: ["#005bea", "#ff0080"],
                    inverseColors: true,
                    opacityFrom: 1,
                    opacityTo: 1,
                    //stops: [0, 50, 100],
                    //colorStops: []
                }
            },
            colors: ["#348bff", "#ff00ab"],
            xaxis: {
                categories: @json($labels)
            },
            tooltip: {
                theme: 'dark',
                y: {
                    formatter: function (val) {
                        return "" + val + ""
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart_visits"), options);
        chart.render();
    </script>

    <script>
        // chart 4
        var options = {
            series: [{
                name: "Всего",
                data: @json($visits_month_counts)
            },{
                name: "Уникальные",
                data: @json($unique_month_visitors)
            }],
            chart: {
                foreColor: '#9a9797',
                type: "bar",
                //width: 130,
                height: 280,
                toolbar: {
                    show: !1
                },
                zoom: {
                    enabled: !1
                },
                dropShadow: {
                    enabled: 0,
                    top: 3,
                    left: 14,
                    blur: 4,
                    opacity: .12,
                    color: "#3361ff"
                },
                sparkline: {
                    enabled: !1
                }
            },
            markers: {
                size: 0,
                colors: ["#3361ff"],
                strokeColors: "#fff",
                strokeWidth: 2,
                hover: {
                    size: 7
                }
            },
            grid: {
                show: true,
                borderColor: '#eee',
                strokeDashArray: 4,
            },
            plotOptions: {
                bar: {
                    horizontal: !1,
                    columnWidth: "50%",
                    endingShape: "rounded"
                }
            },
            legend: {
                show: false,
                position: 'top',
                horizontalAlign: 'left',
                offsetX: -20
            },
            dataLabels: {
                enabled: !1
            },
            stroke: {
                colors: ["transparent"],
                show: !0,
                width: 5,
                curve: "smooth"
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'light',
                    type: "vertical",
                    shadeIntensity: 0.5,
                    gradientToColors: ["#005bea", "#ff0080"],
                    inverseColors: true,
                    opacityFrom: 1,
                    opacityTo: 1,
                    //stops: [0, 50, 100],
                    //colorStops: []
                }
            },
            colors: ["#348bff", "#ff00ab"],
            xaxis: {
                categories: @json($month_labels)
            },
            tooltip: {
                theme: 'dark',
                y: {
                    formatter: function (val) {
                        return "" + val + ""
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart_month_visits"), options);
        chart.render();
    </script>
@endpush
