<div>
    <div class="input-group">
        <input type="number" wire:model.debounce.500ms="days" class="form-control">
        <span class="input-group-text">Days</span>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-4">
            <div class="card small-widget">
                <div class="card-body primary"> <span class="f-light">Avg Time Spend</span>
                    <div class="d-flex align-items-end gap-1">
                        <h4>{{ isset($avg_time[0]['averageSessionDuration']) ? $avg_time[0]['averageSessionDuration'] : 0 }}
                            sec</h4>
                    </div>
                    <div class="bg-gradient">
                        <svg class="stroke-icon svg-fill">
                            <use href="{{ asset('adminetic/assets/svg/icon-sprite.svg#24-hour') }}"></use>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card small-widget">
                <div class="card-body primary"> <span class="f-light">Active Users</span>
                    <div class="d-flex align-items-end gap-1">
                        <h4>{{ isset($active_users[0]['activeUsers']) ? $active_users[0]['activeUsers'] : 0 }}</h4>
                    </div>
                    <div class="bg-gradient">
                        <svg class="stroke-icon svg-fill">
                            <use href="{{ asset('adminetic/assets/svg/icon-sprite.svg#user-visitor') }}"></use>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card small-widget">
                <div class="card-body primary"> <span class="f-light">Views</span>
                    <div class="d-flex align-items-end gap-1">
                        <h4>{{ isset($page_views[0]['screenPageViews']) ? $page_views[0]['screenPageViews'] : 0 }}</h4>
                    </div>
                    <div class="bg-gradient">
                        <svg class="stroke-icon svg-fill">
                            <use href="{{ asset('adminetic/assets/svg/icon-sprite.svg#course-1') }}"></use>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">Browser</div>
                <div class="card-body shadow-lg">
                    <div id="browserCountBarChart"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">Mobile</div>
                <div class="card-body shadow-lg">
                    <div id="mobileCountBarChart"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">OS</div>
                <div class="card-body shadow-lg">
                    <div id="osCountBarChart"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body shadow-lg" style="height:40vh;overflow-y:auto">
                    <div id="newVsReturningPieChart"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body shadow-lg" style="height:40vh;overflow-y:auto">
                    <div class="jvector-map-height" id="world_map"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body shadow-lg">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <th>Page Title</th>
                            <th>Views</th>
                            <th>Duration</th>
                            <th>Mobile</th>
                            <th>Browser</th>
                            <th>OS</th>
                        </thead>
                        <tbody>
                            @foreach ($page_count as $pg_title => $pg_data)
                                <tr>
                                    <td>{{ $pg_title ?? 'n/a' }}</td>
                                    <td>{{ $pg_data['views'] ?? 0 }}</td>
                                    <td>{{ $pg_data['duration'] ?? 0 }} sec</td>
                                    <td>{{ $pg_data['mobileDeviceBranding'] ?? '-' }}</td>
                                    <td>{{ $pg_data['browser'] ?? '-' }}</td>
                                    <td>{{ $pg_data['operatingSystem'] ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @push('livewire_third_party')
        <script>
            $(function() {
                Livewire.emit('initialize_google_analytics');


                // Device Chart
                window.addEventListener('initializeDeviceCount', event => {
                    var data = event.detail;

                    // Browser
                    $('#browserCountBarChart').empty();
                    var browser_data = data.browser_count;
                    var browsers = [];
                    var browser_count = [];
                    Object.keys(browser_data).forEach(function(browser) {
                        browsers.push(browser);
                        browser_count.push(browser_data[browser]);
                    });
                    var browserCountOptions = {
                        series: [{
                            name: 'Browser Visitors',
                            data: browser_count
                        }],
                        chart: {
                            type: 'bar',
                            height: 270,
                            toolbar: {
                                show: false
                            },
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '50%',
                            },
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            show: true,
                            width: 6,
                            colors: ['transparent']
                        },
                        grid: {
                            show: true,
                            borderColor: 'var(--chart-border)',
                            xaxis: {
                                lines: {
                                    show: true
                                }
                            },
                        },
                        colors: ["#ff0000"],
                        xaxis: {
                            categories: browsers,
                            tickAmount: 4,
                            tickPlacement: 'between',
                            labels: {
                                style: {
                                    fontFamily: 'Rubik, sans-serif',
                                },
                            },
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: false
                            }
                        },
                        yaxis: {
                            min: 0,
                            tickAmount: 5,
                            tickPlacement: 'between',
                            labels: {
                                style: {
                                    fontFamily: 'Rubik, sans-serif',
                                }
                            }
                        },
                        fill: {
                            opacity: 1
                        },
                        legend: {
                            position: 'top',
                            horizontalAlign: 'left',
                            fontFamily: "Rubik, sans-serif",
                            fontSize: '14px',
                            fontWeight: 500,
                            labels: {
                                colors: "var(--chart-text-color)",
                            },
                            markers: {
                                width: 6,
                                height: 6,
                                radius: 12,
                            },
                            itemMargin: {
                                horizontal: 10,
                            }
                        },
                        responsive: [{
                                breakpoint: 1366,
                                options: {
                                    plotOptions: {
                                        bar: {
                                            columnWidth: '80%',
                                        },
                                    },
                                    grid: {
                                        padding: {
                                            right: 0,
                                        }
                                    }
                                },
                            },
                            {
                                breakpoint: 1200,
                                options: {
                                    plotOptions: {
                                        bar: {
                                            columnWidth: '50%',
                                        },
                                    },
                                    grid: {
                                        padding: {
                                            right: 0,
                                        }
                                    }
                                },
                            },
                            {
                                breakpoint: 576,
                                options: {
                                    plotOptions: {
                                        bar: {
                                            columnWidth: '60%',
                                        },
                                    },
                                    grid: {
                                        padding: {
                                            right: 5,
                                        }
                                    }
                                },
                            }
                        ]
                    };

                    var browserCountBarChart = new ApexCharts(document.querySelector("#browserCountBarChart"),
                        browserCountOptions);
                    browserCountBarChart.render();
                    // Mobile
                    $('#mobileCountBarChart').empty();
                    var mobile_data = data.mobile_count;
                    var mobiles = [];
                    var mobile_count = [];
                    Object.keys(mobile_data).forEach(function(mobile) {
                        mobiles.push(mobile);
                        mobile_count.push(mobile_data[mobile]);
                    });
                    var mobileCountOptions = {
                        series: [{
                            name: 'mobile Visitors',
                            data: mobile_count
                        }],
                        chart: {
                            type: 'bar',
                            height: 270,
                            toolbar: {
                                show: false
                            },
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '50%',
                            },
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            show: true,
                            width: 6,
                            colors: ['transparent']
                        },
                        grid: {
                            show: true,
                            borderColor: 'var(--chart-border)',
                            xaxis: {
                                lines: {
                                    show: true
                                }
                            },
                        },
                        colors: ["#ff0000"],
                        xaxis: {
                            categories: mobiles,
                            tickAmount: 4,
                            tickPlacement: 'between',
                            labels: {
                                style: {
                                    fontFamily: 'Rubik, sans-serif',
                                },
                            },
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: false
                            }
                        },
                        yaxis: {
                            min: 0,
                            tickAmount: 5,
                            tickPlacement: 'between',
                            labels: {
                                style: {
                                    fontFamily: 'Rubik, sans-serif',
                                }
                            }
                        },
                        fill: {
                            opacity: 1
                        },
                        legend: {
                            position: 'top',
                            horizontalAlign: 'left',
                            fontFamily: "Rubik, sans-serif",
                            fontSize: '14px',
                            fontWeight: 500,
                            labels: {
                                colors: "var(--chart-text-color)",
                            },
                            markers: {
                                width: 6,
                                height: 6,
                                radius: 12,
                            },
                            itemMargin: {
                                horizontal: 10,
                            }
                        },
                        responsive: [{
                                breakpoint: 1366,
                                options: {
                                    plotOptions: {
                                        bar: {
                                            columnWidth: '80%',
                                        },
                                    },
                                    grid: {
                                        padding: {
                                            right: 0,
                                        }
                                    }
                                },
                            },
                            {
                                breakpoint: 1200,
                                options: {
                                    plotOptions: {
                                        bar: {
                                            columnWidth: '50%',
                                        },
                                    },
                                    grid: {
                                        padding: {
                                            right: 0,
                                        }
                                    }
                                },
                            },
                            {
                                breakpoint: 576,
                                options: {
                                    plotOptions: {
                                        bar: {
                                            columnWidth: '60%',
                                        },
                                    },
                                    grid: {
                                        padding: {
                                            right: 5,
                                        }
                                    }
                                },
                            }
                        ]
                    };

                    var mobileCountBarChart = new ApexCharts(document.querySelector("#mobileCountBarChart"),
                        mobileCountOptions);
                    mobileCountBarChart.render();

                    // OS Count
                    $('#osCountBarChart').empty();
                    var os_data = data.os_count;
                    var operating_system = [];
                    var os_count = [];
                    Object.keys(os_data).forEach(function(os) {
                        operating_system.push(os);
                        os_count.push(os_data[os]);
                    });
                    var osCountOptions = {
                        series: [{
                            name: 'Operating System Visitors',
                            data: os_count
                        }],
                        chart: {
                            type: 'bar',
                            height: 270,
                            toolbar: {
                                show: false
                            },
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '50%',
                            },
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            show: true,
                            width: 6,
                            colors: ['transparent']
                        },
                        grid: {
                            show: true,
                            borderColor: 'var(--chart-border)',
                            xaxis: {
                                lines: {
                                    show: true
                                }
                            },
                        },
                        colors: ["#ff0000"],
                        xaxis: {
                            categories: operating_system,
                            tickAmount: 4,
                            tickPlacement: 'between',
                            labels: {
                                style: {
                                    fontFamily: 'Rubik, sans-serif',
                                },
                            },
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: false
                            }
                        },
                        yaxis: {
                            min: 0,
                            tickAmount: 5,
                            tickPlacement: 'between',
                            labels: {
                                style: {
                                    fontFamily: 'Rubik, sans-serif',
                                }
                            }
                        },
                        fill: {
                            opacity: 1
                        },
                        legend: {
                            position: 'top',
                            horizontalAlign: 'left',
                            fontFamily: "Rubik, sans-serif",
                            fontSize: '14px',
                            fontWeight: 500,
                            labels: {
                                colors: "var(--chart-text-color)",
                            },
                            markers: {
                                width: 6,
                                height: 6,
                                radius: 12,
                            },
                            itemMargin: {
                                horizontal: 10,
                            }
                        },
                        responsive: [{
                                breakpoint: 1366,
                                options: {
                                    plotOptions: {
                                        bar: {
                                            columnWidth: '80%',
                                        },
                                    },
                                    grid: {
                                        padding: {
                                            right: 0,
                                        }
                                    }
                                },
                            },
                            {
                                breakpoint: 1200,
                                options: {
                                    plotOptions: {
                                        bar: {
                                            columnWidth: '50%',
                                        },
                                    },
                                    grid: {
                                        padding: {
                                            right: 0,
                                        }
                                    }
                                },
                            },
                            {
                                breakpoint: 576,
                                options: {
                                    plotOptions: {
                                        bar: {
                                            columnWidth: '60%',
                                        },
                                    },
                                    grid: {
                                        padding: {
                                            right: 5,
                                        }
                                    }
                                },
                            }
                        ]
                    };

                    var osCountBarChart = new ApexCharts(document.querySelector("#osCountBarChart"),
                        osCountOptions);
                    osCountBarChart.render();
                });

                // World Map
                window.addEventListener('initializeWorldMap', event => {
                    $('#world_map').empty();
                    var data = event.detail;
                    var country_color = [];
                    var baseColor = '#b30000';
                    Object.keys(data).forEach(function(countryCode) {
                        country_color[countryCode] = baseColor;
                    });
                    $('#world_map').vectorMap({
                        map: "world_mill_en",
                        scaleColors: ["#2196F3", "#1B8BF9"],
                        normalizeFunction: "polynomial",
                        hoverOpacity: .7,
                        hoverColor: !1,
                        series: {
                            regions: [{
                                values: country_color
                            }]
                        },
                        regionStyle: {
                            initial: {
                                fill: "#7366ff"
                            }
                        },
                        onRegionTipShow: function(e, el, code) {
                            el.html(el.html() + ' (Views - ' + (data[code] ? data[code] : 0) + ')');
                        },
                        backgroundColor: "transparent",
                    });
                });

                // New vs Returning Chart
                window.addEventListener('initializeNewVsReturningVisitor', event => {
                    $('#newVsReturningPieChart').empty();
                    data = event.detail;
                    var newVsReturningPieChartOption = {
                        chart: {
                            type: 'pie',
                        },
                        labels: ['New', 'Returning'],
                        series: [data['new'], data['returning']],
                        responsive: [{
                            breakpoint: 480,
                            options: {
                                chart: {
                                    width: 200
                                },
                                legend: {
                                    show: false
                                }
                            }
                        }],
                        colors: [CubaAdminConfig.primary, CubaAdminConfig.secondary, '#51bb25', '#a927f9',
                            '#f8d62b'
                        ]
                    }

                    var newVsReturningPieChart = new ApexCharts(
                        document.querySelector("#newVsReturningPieChart"),
                        newVsReturningPieChartOption
                    );

                    newVsReturningPieChart.render();
                });
            });
        </script>
    @endpush
</div>
