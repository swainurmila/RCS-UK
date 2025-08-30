@extends('appeal.layouts.app')

<style>
    .card-summary {
        padding: 20px;
        text-align: center;
        font-weight: 600;
        border-radius: 10px;
    }

    .chart-container {
        height: 300px;
    }

    .card-summary {
        padding: 20px;
        border-radius: 6px;
        text-align: center;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        min-height: 110px;
    }

    .card-summary:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .card-summary div {
        font-size: 0.95rem;
        font-weight: 500;
    }

    .card-summary h4 {
        margin-top: 10px;
        font-weight: bold;
        font-size: 1.5rem;
    }

    .no_of_societies_p_chart {
        height: 383px;
    }

    .stat-card {
        color: white;
        padding: 20px 25px;
        border-radius: 20px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: transform 0.3s;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        position: absolute;
        content: "";
        background-image: url(./../assets/images/images.png);
        height: 100%;
        width: 100%;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        opacity: 0.2;
        left: 0;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-card.card1 {
        background: linear-gradient(90deg, #08054d 0%, #04738a 100%);

    }

    .stat-card.card2 {
        background: linear-gradient(135deg, #f1e154, #4CAF50);
    }

    .stat-card.card3 {

        background: linear-gradient(90deg, #123d8f 0%, #8525d4 100%);
    }

    .stat-card.card4 {
        background: linear-gradient(90deg, #833ab4 0%, #ca3051c4 84%);
    }

    .stat-card.card5 {

        background: linear-gradient(90deg, #ca3051c4 0%, #fcb045 89%);
    }

    .stat-text {
        font-size: 14px;
        opacity: 0.9;
    }

    .stat-number {
        font-size: 28px;
        font-weight: bold;
        margin-bottom: 4px;
    }

    .icon-box {
        position: absolute;
        height: 70px;
        width: 70px;
        border-radius: 50%;
        background: #ffffff82;
        display: flex;
        justify-content: center;
        align-items: center;
        top: -10px;
        right: -3px;
        font-size: 25px;
    }
</style>


@section('content')
    <!-- <div class="page-content mt-4">
        <div class="container-fluid">
            <div class="card">
                <div class="row g-3">
                    <div class="col-lg-3">
                        <div class="mb-3">
                            <label class="form-label">Start & End Date</label>
                            <div class="input-daterange input-group" id="datepicker6" data-date-format="dd M, yyyy"
                                data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                <input type="text" class="form-control" name="start" placeholder="Start Date" />
                                <input type="text" class="form-control" name="end" placeholder="End Date" />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="mb-3">
                            <label class="form-label">Month </label>
                            <div class="position-relative" id="datepicker4">
                                <input type="text" class="form-control" data-date-container='#datepicker4'
                                    data-provide="datepicker" data-date-format="MM yyyy" data-date-min-view-mode="1">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="mb-0">
                            <label class="form-label">Year</label>
                            <div class="position-relative" id="datepicker5">
                                <input type="text" class="form-control" data-provide="datepicker"
                                    data-date-container='#datepicker5' data-date-format="dd M, yyyy"
                                    data-date-min-view-mode="2">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <label>District</label>
                        <select class="form-select" id="districtSelect" onchange="updateBlocks()">
                            <option value="">Select</option>
                            <option>Balasore</option>
                            <option>Kendrapada</option>
                            <option>Dhenkanal</option>
                            <option>Sambalpur</option>
                            <option>Baripada</option>
                            <option>Anugul</option>
                            <option>Sundargard</option>

                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label>Block</label>
                        <select class="form-select" id="blockSelect">
                            <option value="">Select</option>
                            <option value="">Bhograi</option>
                            <option value="">Bigul</option>

                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label>Society Type</label>
                        <select class="form-select">
                            <option value="">Select</option>
                            <option>Primary</option>
                            <option>Central</option>
                            <option>Apex</option>
                        </select>
                    </div>



                    <div class="col-lg-3">
                        <label>Sector Type</label>
                        <input type="text" class="form-control" list="sectorList" placeholder="Search Sector...">
                        <datalist id="sectorList">
                            <option value="Agriculture"></option>
                            <option value="Fisheries"></option>
                            <option value="Housing"></option>
                            <option value="Labor"></option>
                            <option value="Credit"></option>
                            <option value="Industrial"></option>
                        </datalist>
                    </div>
                    <div class="col-lg-3 d-grid">
                        <label>&nbsp;</label>
                        <button class="btn bg-success text-white">Search</button>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-3 mt-4">
                    <div class="col">
                        <div class="stat-card card1">
                            <div>
                                <div class="stat-number">110</div>
                                <div class="stat-text"> Submitted</div>
                            </div>
                            <div class="icon-box"><i class="bi-check-circle-fill"></i></div>
                        </div>
                    </div>


                    <div class="col">
                        <div class="stat-card card2">
                            <div>
                                <div class="stat-number">209</div>
                                <div class="stat-text">Approved </div>
                            </div>
                            <div class="icon-box"><i class="bi-check-circle-fill"></i></div>
                        </div>
                    </div>


                    <div class="col">
                        <div class="stat-card card3">
                            <div>
                                <div class="stat-number">102</div>
                                <div class="stat-text">Reverted </div>
                            </div>
                            <div class="icon-box"><i class="bi-arrow-counterclockwise"></i></div>
                        </div>
                    </div>


                    <div class="col">
                        <div class="stat-card card4">
                            <div>
                                <div class="stat-number">32</div>
                                <div class="stat-text">Rejected </div>
                            </div>
                            <div class="icon-box"><i class="bi-x-circle-fill"></i></div>
                        </div>
                    </div>



                    <div class="col">
                        <div class="stat-card card5">
                            <div>
                                <div class="stat-number">10</div>
                                <div class="stat-text">Under Review</div>
                            </div>
                            <div class="icon-box"><i class="bi-hourglass-split"></i></div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row mt-5">
                <div class="col-xl-6">
                    <div class="card ">
                        <div class="card-body">

                            <h4 class="mb-4">Number Of Societies</h4>

                            <canvas id="bar" data-colors='["#04738a"]' height="300"></canvas>

                        </div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="card ">
                        <div class="card-body">
                            <h4 class="mb-4">Distribution of Societies</h4>

                            <div id="no_of_societies_p_chart"
                                data-colors='["--bs-success", "--bs-primary", "--bs-warning" ,"--bs-info", "--bs-danger"]'
                                class="apex-charts" dir="ltr"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
@endsection
@section('js')
    <script>

        function getChartColorsArray(e) {
            if (null !== document.getElementById(e)) {
                var t = document.getElementById(e).getAttribute("data-colors");
                if (t)
                    return (t = JSON.parse(t)).map(function (e) {
                        var t = e.replace(" ", "");
                        if (-1 === t.indexOf(",")) {
                            var r = getComputedStyle(document.documentElement).getPropertyValue(
                                t
                            );
                            return r || t;
                        }
                        var a = e.split(",");
                        return 2 != a.length
                            ? t
                            : "rgba(" +
                            getComputedStyle(document.documentElement).getPropertyValue(
                                a[0]
                            ) +
                            "," +
                            a[1] +
                            ")";
                    });
            }
        }

        var PiechartPieColors = getChartColorsArray("no_of_societies_p_chart");
        PiechartPieColors &&
            ((options = {
                chart: { height: 320, type: "pie" },
                series: [44, 55, 41, 17, 15],
                labels: ["Series 1", "Series 2", "Series 3", "Series 4", "Series 5"],
                colors: PiechartPieColors,
                legend: {
                    show: !0,
                    position: "bottom",
                    horizontalAlign: "center",
                    verticalAlign: "middle",
                    floating: !1,
                    fontSize: "14px",
                    offsetX: 0,
                },
                responsive: [
                    {
                        breakpoint: 600,
                        options: { chart: { height: 240 }, legend: { show: !1 } },
                    },
                ],
            }),
                (chart = new ApexCharts(
                    document.querySelector("#no_of_societies_p_chart"),
                    options
                )).render());



    </script>
    <script>


        function getChartColorsArray(r) {
            if (null !== document.getElementById(r)) {
                var o = document.getElementById(r).getAttribute("data-colors");
                if (o)
                    return (o = JSON.parse(o)).map(function (r) {
                        var o = r.replace(" ", "");
                        if (-1 === o.indexOf(",")) {
                            var e = getComputedStyle(document.documentElement).getPropertyValue(
                                o
                            );
                            return e || o;
                        }
                        var t = r.split(",");
                        return 2 != t.length
                            ? o
                            : "rgba(" +
                            getComputedStyle(document.documentElement).getPropertyValue(
                                t[0]
                            ) +
                            "," +
                            t[1] +
                            ")";
                    });
            }
        }

        !(function (p) {
            "use strict";
            function r() { }
            (r.prototype.respChart = function (r, o, e, t) {
                (Chart.defaults.global.defaultFontColor = "#9295a4"),
                    (Chart.defaults.scale.gridLines.color = "rgba(166, 176, 207, 0.1)");
                var a = r.get(0).getContext("2d"),
                    n = p(r).parent();
                function l() {
                    r.attr("width", p(n).width());
                    switch (o) {
                        case "Bar":
                            new Chart(a, { type: "bar", data: e, options: t });
                            break;
                    }
                }
                p(window).resize(l), l();
            }),
                (r.prototype.init = function () {
                    var l,
                        i = getChartColorsArray("bar");
                    i &&
                        ((l = {
                            labels: [
                                "Submitted",
                                "Approved",
                                "Reverted",
                                "Rejected",
                                "Under Review",
                            ],
                            datasets: [
                                {
                                    label: "No Of Societies",
                                    backgroundColor: i[0],
                                    borderColor: i[0],
                                    borderWidth: 1,
                                    hoverBackgroundColor: i[1],
                                    hoverBorderColor: i[1],
                                    data: [65, 59, 81, 65, 56],
                                },
                            ],
                        }),
                            this.respChart(p("#bar"), "Bar", l, {
                                scales: { xAxes: [{ barPercentage: 0.4 }] },
                            }));

                }),
                (p.ChartJs = new r()),
                (p.ChartJs.Constructor = r);
        })(window.jQuery),
            (function () {
                "use strict";
                window.jQuery.ChartJs.init();
            })();

    </script>


@endsection
<!-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                    
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


 -->