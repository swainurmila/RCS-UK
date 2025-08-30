@extends('layouts.app')


@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">{{ __('messages.dashboard') }}</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a
                                        href="javascript: void(0);">{{ __('messages.cooperatives_department') }}</a>
                                </li>
                                <li class="breadcrumb-item active">{{ __('messages.dashboard') }}</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- start page title -->

            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card ">
                        <div class="card-body p-0">

                            <div class="row dash-card-row">
                                <div class="dash-col">
                                    <div class="card dash-card card1">
                                        <div class="card-body dash-card-body">
                                            <div class="dash-img"> <img src="assets/images/society.png" class="img-fluid">
                                            </div>
                                            <p class="mb-0">{{ __('messages.TotalSociety') }}</p>
                                            <h4 class="mb-1 mt-1"><span
                                                    data-plugin="counterup">{{ $arr['total_society'] }}</span></h4>
                                            <button type="button">{{ __('messages.ViewDetails') }}</button>
                                        </div>
                                    </div>
                                </div> <!-- end col-->

                                <div class="dash-col">
                                    <div class="card dash-card card2">
                                        <div class="card-body dash-card-body">
                                            <div class="dash-img"> <img src="assets/images/approved.png" class="img-fluid">
                                            </div>
                                            <p class="mb-0">{{ __('messages.TotalApproved') }}</p>
                                            <h4 class="mb-1 mt-1"><span
                                                    data-plugin="counterup">{{ $arr['approved_society'] }}</span></h4>
                                            <button type="button">{{ __('messages.ViewDetails') }}</button>
                                        </div>
                                    </div>
                                </div> <!-- end col-->

                                <div class="dash-col">

                                    <div class="card dash-card card3">
                                        <div class="card-body dash-card-body">
                                            <div class="dash-img"><img src="assets/images/pending.png" class="img-fluid">
                                            </div>
                                            <p class="mb-0">{{ __('messages.TotalPending') }}</p>
                                            <h4 class="mb-1 mt-1"><span
                                                    data-plugin="counterup">{{ $arr['pending_society'] }}</span></h4>
                                            <button type="button">{{ __('messages.ViewDetails') }}</button>
                                        </div>
                                    </div>
                                </div> <!-- end col-->

                                <div class="dash-col">
                                    <div class="card dash-card card4">
                                        <div class="card-body dash-card-body">
                                            <div class="dash-img"><img src="assets/images/rejected.png" class="img-fluid">
                                            </div>
                                            <p class="mb-0">{{ __('messages.TotalRejected') }}</p>
                                            <h4 class="mb-1 mt-1"><span
                                                    data-plugin="counterup">{{ $arr['rejected_society'] }}</span></h4>
                                            <button type="button">{{ __('messages.ViewDetails') }}</button>
                                        </div>
                                    </div>
                                </div> <!-- end col-->

                                <div class="dash-col">
                                    <div class="card dash-card card5">
                                        <div class="card-body dash-card-body">
                                            <div class="dash-img"><img src="assets/images/members.png" class="img-fluid">
                                            </div>
                                            <p class="mb-0">{{ __('messages.TotalMembers') }}</p>
                                            <h4 class="mb-1 mt-1"><span
                                                    data-plugin="counterup">{{ $arr['total_member'] }}</span></h4>
                                            <button type="button">{{ __('messages.ViewDetails') }}</button>
                                        </div>
                                    </div>
                                </div> <!-- end col-->

                            </div>



                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="card dash-card">
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-lg-4">
                                    <h4 class="cstm-card-title m-0">{{ __('messages.ApprovedSocietyStatus') }}</h4>
                                </div>
                                <div class="col-lg-8 d-flex align-item filter-wrapper">
                                    <select id="monthSelect" class="form-control select2 form-select">
                                        <option value="">{{ __('messages.MonthWise') }}</option>
                                        <option value="1">{{ __('messages.january') }}</option>
                                        <option value="2">{{ __('messages.february') }}</option>
                                        <option value="3">{{ __('messages.march') }}</option>
                                        <option value="4">{{ __('messages.april') }}</option>
                                        <option value="5">{{ __('messages.may') }}</option>
                                        <option value="6">{{ __('messages.june') }}</option>
                                        <option value="7">{{ __('messages.july') }}</option>
                                        <option value="8">{{ __('messages.august') }}</option>
                                        <option value="9">{{ __('messages.septemeber') }}</option>
                                        <option value="10">{{ __('messages.october') }}</option>
                                        <option value="11">{{ __('messages.november') }}</option>
                                        <option value="12">{{ __('messages.december') }}</option>
                                    </select>
                                    <select id="yearSelect" class="form-control select2 form-select">
                                        <option value="">{{ __('messages.YearWise') }}</option>
                                        <option value="2023">{{ __('messages.2023') }}</option>
                                        <option value="2024">{{ __('messages.2024') }}</option>
                                        <option value="2025">{{ __('messages.2024') }}</option>
                                    </select>
                                    <button type="button" class="btn btn-sm btn-primary"
                                        onclick="filter()">{{ __('messages.filter') }}</button>
                                </div>
                            </div>

                            <div id="project_status" data-colors='["#22af13", "#f85908", "#E91E63"]' class="apex-charts"
                                dir="ltr"></div>
                        </div>

                    </div><!--end card-->
                </div>

                <div class="col-xl-3">
                    <div class="card dash-card">
                        <div class="card-body">
                            <h4 class="cstm-card-title mb-4">{{ __('messages.PendingSociety') }}</h4>

                            <div id="project_pending" data-colors='["--bs-success", "--bs-warning"]' class="apex-charts"
                                dir="ltr"></div>
                        </div>
                    </div><!--end card-->
                </div>

                <div class="col-lg-3">
                    <div class="card dash-card">
                        <div class="card-body">
                            <h4 class="cstm-card-title mb-4">{{ __('messages.RejectedSociety') }}</h4>

                            <div id="rejected_project" data-colors='["--bs-success", "--bs-danger"]' class="apex-charts"
                                dir="ltr"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
@section('js')
    <!-- jquery step -->
    <script src="{{ asset('assets/libs/jquery-steps/build/jquery.steps.min.js') }}"></script>

    <!-- apexcharts -->
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/apexcharts.init.js') }}"></script>

    <!-- App js -->
    <!-- <script>
            var chart; // Global variable to store the chart instance

            // Function to create/update the chart dynamically
            function renderChart(beforeTotalPerDay, beforeApprovedPerDay) {
                var totalData = Object.values(beforeTotalPerDay);
                var approvedData = Object.values(beforeApprovedPerDay);
                var categories = Object.keys(beforeTotalPerDay); // X-axis labels
                console.log("categories", categories);
                console.log("totalData", totalData);
                console.log("approvedData", approvedData);
                var AreachartSplineColors = getChartColorsArray("project_status");

                var options = {
                    chart: {
                        height: 268,
                        type: "area"
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: "smooth",
                        width: 2
                    },
                    series: [{
                            name: "Total Society",
                            data: totalData
                        },
                        {
                            name: "Approved",
                            data: approvedData
                        }
                    ],
                    colors: AreachartSplineColors,
                    xaxis: {
                        type: "datetime",
                        categories: categories
                    },
                    grid: {
                        borderColor: "#f1f1f1"
                    },
                    tooltip: {
                        x: {
                            format: "dd/MM/yy HH:mm"
                        }
                    }
                };

                // If chart exists, update it; otherwise, create a new one
                if (chart) {
                    chart.updateOptions(options);
                } else {
                    chart = new ApexCharts(document.querySelector("#project_status"), options);
                    chart.render();
                }
            }

            // Initial chart rendering with Laravel-provided data
            var initialBeforeTotalPerDay = @json($currenttotalPerDay, JSON_NUMERIC_CHECK) || {};
            var initialBeforeApprovedPerDay = @json($currentapprovedPerDay, JSON_NUMERIC_CHECK) || {};
            // renderChart(initialBeforeTotalPerDay, initialBeforeApprovedPerDay);
            if (Object.keys(initialBeforeTotalPerDay).length > 0 || Object.keys(initialBeforeApprovedPerDay).length > 0) {
                renderChart(initialBeforeTotalPerDay, initialBeforeApprovedPerDay);
            } else {
                document.querySelector("#project_status").innerHTML = "<p>No data available</p>";
            }

            // Function to fetch and update chart data via AJAX
            function filter() {
                var month = document.getElementById("monthFilter").value;
                var year = document.getElementById("yearFilter").value;

                $.ajax({
                    url: "/get-chart-data",
                    type: "GET",
                    data: {
                        month: month,
                        year: year
                    },
                    success: function(response) {
                        renderChart(response.beforeTotalPerDay, response.beforeApprovedPerDay);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching data:", error);
                    }
                });
            }
        </script> -->
    <!-- <script>
            var chartproject; // Global variable to store the chart instance

            function renderChart(beforeTotalPerDay, beforeApprovedPerDay) {
                // Clear previous chart if it exists
                if (chartproject) {
                    // chart.destroy();
                    document.querySelector("#project_status").innerHTML = "";
                }

                // Convert date strings to timestamps
                const categories = Object.keys(beforeTotalPerDay).map(dateStr => {
                    return new Date(dateStr).getTime(); // Convert to timestamp
                });
                var totalData = Object.values(beforeTotalPerDay);
                var approvedData = Object.values(beforeApprovedPerDay);



                var AreachartSplineColors = getChartColorsArray("project_status");

                var options = {
                    chart: {
                        height: 268,
                        type: "area"
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: "smooth",
                        width: 2
                    },
                    series: [{
                        name: "Total Society",
                        data: categories.map((timestamp, index) => [timestamp, totalData[index]])
                    }, {
                        name: "Approved",
                        data: categories.map((timestamp, index) => [timestamp, approvedData[index] || 0])
                    }],
                    colors: AreachartSplineColors,
                    xaxis: {
                        type: "datetime",
                        categories: categories
                    },
                    grid: {
                        borderColor: "#f1f1f1"
                    },
                    tooltip: {
                        x: {
                            format: "dd/MM/yy HH:mm" // Better date format
                        }
                    }
                };

                chartproject = new ApexCharts(document.querySelector("#project_status"), options);
                chartproject.render();
            }

            // Initial data
            var initialBeforeTotalPerDay = @json($currenttotalPerDay, JSON_NUMERIC_CHECK) || {};
            var initialBeforeApprovedPerDay = @json($currentapprovedPerDay, JSON_NUMERIC_CHECK) || {};
            renderChart(initialBeforeTotalPerDay, initialBeforeApprovedPerDay);

            function filter() {
                var selectedMonth = document.getElementById("monthSelect").value;
                var selectedYear = document.getElementById("yearSelect").value;

                $.ajax({
                    url: "{{ route('getChartData') }}",
                    type: "GET",
                    data: {
                        month: selectedMonth,
                        year: selectedYear
                    },
                    success: function(response) {
                        console.log("response", response);
                        renderChart(response.total, response.approved);
                    }
                });
            }
        </script> -->
    <!-- <script>
            var chartproject; // Global variable for the chart instance

            function renderChart(beforeTotalPerDay, beforeApprovedPerDay) {
                // Get all unique dates from `total` and `approved`
                const allDates = new Set([
                    ...Object.keys(beforeTotalPerDay)
                ]);

                // Convert dates to sorted timestamps
                const categories = [...allDates].map(dateStr => new Date(dateStr)).sort((a, b) => a - b);

                // Prepare data for chart (ensure all dates are included, defaulting missing values to 0)
                var totalData = categories.map(date => [
                    date.getTime(), beforeTotalPerDay[date.toISOString().split("T")[0]] || 0
                ]);

                var approvedData = categories.map(date => [
                    date.getTime(), beforeApprovedPerDay[date.toISOString().split("T")[0]] || 0
                ]);



                var AreachartSplineColors = getChartColorsArray("project_status");

                var options = {
                    chart: {
                        height: 268,
                        type: "area"
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: "smooth",
                        width: 2
                    },
                    series: [{
                            name: "Total Society",
                            data: totalData
                        },
                        {
                            name: "Approved",
                            data: approvedData
                        }
                    ],
                    colors: AreachartSplineColors,
                    xaxis: {
                        type: "datetime",
                        labels: {
                            formatter: function(value) {
                                let date = new Date(value);
                                return date.toLocaleString("en-US", {
                                    day: "numeric",
                                    month: "short",
                                    year: "numeric"
                                });
                            }
                        }
                    },
                    grid: {
                        borderColor: "#f1f1f1"
                    },
                    tooltip: {
                        x: {
                            format: "dd MMM yyyy"
                        }
                    }
                };
                console.log("options", options);
                if (chartproject) {
                    chartproject.updateOptions(options);
                    // chartproject.updateOptions({
                    //     series: [{
                    //         data: totalData // Only update data for first series
                    //     }, {
                    //         data: approvedData // Only update data for second series
                    //     }],
                    //     xaxis: options.xaxis // Maintain x-axis configuration
                    // }, false, false);
                    // chartproject.render();
                    // chartproject = new ApexCharts(document.querySelector("#project_status"), options);
                    // chartproject.render();
                } else {
                    console.log("112");
                    chartproject = new ApexCharts(document.querySelector("#project_status"), options);
                    chartproject.render();
                }
            }

            // Initial Data
            var initialBeforeTotalPerDay = @json($currenttotalPerDay, JSON_NUMERIC_CHECK) || {};
            var initialBeforeApprovedPerDay = @json($currentapprovedPerDay, JSON_NUMERIC_CHECK) || {};
            renderChart(initialBeforeTotalPerDay, initialBeforeApprovedPerDay);

            function filter() {
                var selectedMonth = document.getElementById("monthSelect").value;
                var selectedYear = document.getElementById("yearSelect").value;

                $.ajax({
                    url: "{{ route('getChartData') }}",
                    type: "GET",
                    data: {
                        month: selectedMonth,
                        year: selectedYear
                    },
                    success: function(response) {
                        console.log("response", response);
                        chartproject.destroy();
                        renderChart(response.total, response.approved);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching chart data:", error);
                    }
                });
            }
        </script> -->

    <!-- <script>
            var chartproject; // Global variable for the chart instance

            function renderChart(beforeTotalPerDay, beforeApprovedPerDay) {
                // Get all unique dates from `total` and `approved`
                const allDates = new Set([
                    ...Object.keys(beforeTotalPerDay),
                    ...Object.keys(beforeApprovedPerDay) // Ensure both datasets contribute to x-axis
                ]);

                // Convert dates to sorted timestamps
                const categories = [...allDates]
                    .map(dateStr => new Date(dateStr))
                    .sort((a, b) => a - b);

                // Prepare data for chart (ensuring all dates are included, defaulting missing values to 0)
                var totalData = categories.map(date => [
                    date.getTime(), beforeTotalPerDay[date.toISOString().split("T")[0]] || 0
                ]);

                var approvedData = categories.map(date => [
                    date.getTime(), beforeApprovedPerDay[date.toISOString().split("T")[0]] || 0
                ]);

                var AreachartSplineColors = getChartColorsArray("project_status");

                var options = {
                    chart: {
                        height: 268,
                        type: "area"
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: "smooth",
                        width: 2
                    },
                    series: [{
                            name: "Total Society",
                            data: totalData
                        },
                        {
                            name: "Approved",
                            data: approvedData
                        }
                    ],
                    colors: AreachartSplineColors,
                    xaxis: {
                        type: "datetime",
                        categories: categories.map(date => date.getTime()), // Ensuring x-axis is consistent
                        labels: {
                            formatter: function(value) {
                                let date = new Date(value);
                                return date.toLocaleString("en-US", {
                                    day: "numeric",
                                    month: "short",
                                    year: "numeric"
                                });
                            }
                        }
                    },
                    grid: {
                        borderColor: "#f1f1f1"
                    },
                    tooltip: {
                        x: {
                            format: "dd MMM yyyy"
                        }
                    }
                };
                console.log(options)
                if (chartproject) {
                    // Fully update the chart for consistency
                    chartproject.updateOptions(options);
                } else {
                    console.log("Initializing new chart...");
                    chartproject = new ApexCharts(document.querySelector("#project_status"), options);
                    chartproject.render();
                }
            }

            // Initial Data
            var initialBeforeTotalPerDay = @json($currenttotalPerDay, JSON_NUMERIC_CHECK) || {};
            var initialBeforeApprovedPerDay = @json($currentapprovedPerDay, JSON_NUMERIC_CHECK) || {};
            renderChart(initialBeforeTotalPerDay, initialBeforeApprovedPerDay);

            function filter() {
                var selectedMonth = document.getElementById("monthSelect").value;
                var selectedYear = document.getElementById("yearSelect").value;

                $.ajax({
                    url: "{{ route('getChartData') }}",
                    type: "GET",
                    data: {
                        month: selectedMonth,
                        year: selectedYear
                    },
                    success: function(response) {
                        console.log("response", response);
                        // No need to destroy, just update the existing chart
                        renderChart(response.total, response.approved);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching chart data:", error);
                    }
                });
            }
        </script> -->
    <!-- <script>
            var chartproject; // Global variable for the chart instance

            function renderChart(beforeTotalPerDay, beforeApprovedPerDay) {
                // Get all unique dates from `total` and `approved`
                const allDates = new Set([
                    ...Object.keys(beforeTotalPerDay),
                    ...Object.keys(beforeApprovedPerDay) // Ensure both datasets contribute to x-axis
                ]);

                // Convert dates to sorted timestamps
                const sortedDates = [...allDates].map(dateStr => new Date(dateStr)).sort((a, b) => a - b);
                const categories = sortedDates.map(date => date.toISOString().split("T")[0]); // Format YYYY-MM-DD

                // Prepare data for chart (ensuring all dates are included, defaulting missing values to 0)
                var totalData = sortedDates.map(date => [
                    date.getTime(), beforeTotalPerDay[date.toISOString().split("T")[0]] || 0
                ]);

                var approvedData = sortedDates.map(date => [
                    date.getTime(), beforeApprovedPerDay[date.toISOString().split("T")[0]] || 0
                ]);

                var AreachartSplineColors = getChartColorsArray("project_status");

                var options = {
                    chart: {
                        height: 268,
                        type: "area"
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: "smooth",
                        width: 2
                    },
                    series: [{
                            name: "Total Society",
                            data: totalData
                        },
                        {
                            name: "Approved",
                            data: approvedData
                        }
                    ],
                    colors: AreachartSplineColors,
                    xaxis: {
                        type: "datetime",
                        categories: categories, // Use proper date format
                        convertedCatToNumeric: false, // Prevents ApexCharts from converting categories
                        labels: {
                            formatter: function(value) {
                                let date = new Date(value);
                                return date.toLocaleString("en-US", {
                                    day: "numeric",
                                    month: "short",
                                    year: "numeric"
                                });
                            }
                        }
                    },
                    grid: {
                        borderColor: "#f1f1f1"
                    },
                    tooltip: {
                        x: {
                            format: "dd MMM yyyy"
                        }
                    },
                    annotations: {
                        yaxis: [],
                        xaxis: [],
                        points: []
                    } // Ensure annotations exist
                };

                console.log("Updated Options:", options);

                if (chartproject) {
                    // Update series separately for better performance
                    chartproject.updateOptions({
                        xaxis: options.xaxis,
                        annotations: options.annotations
                    });
                    chartproject.updateSeries(options.series);
                } else {
                    console.log("Initializing new chart...");
                    chartproject = new ApexCharts(document.querySelector("#project_status"), options);
                    chartproject.render();
                }
            }

            // Initial Data
            var initialBeforeTotalPerDay = @json($currenttotalPerDay, JSON_NUMERIC_CHECK) || {};
            var initialBeforeApprovedPerDay = @json($currentapprovedPerDay, JSON_NUMERIC_CHECK) || {};
            renderChart(initialBeforeTotalPerDay, initialBeforeApprovedPerDay);

            function filter() {
                var selectedMonth = document.getElementById("monthSelect").value;
                var selectedYear = document.getElementById("yearSelect").value;

                $.ajax({
                    url: "{{ route('getChartData') }}",
                    type: "GET",
                    data: {
                        month: selectedMonth,
                        year: selectedYear
                    },
                    success: function(response) {
                        console.log("Filtered Data:", response);
                        renderChart(response.total, response.approved);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching chart data:", error);
                    }
                });
            }
        </script> -->
    <script>
        var chartproject; // Global variable for the chart instance

        function renderChart(beforeTotalPerDay, beforeApprovedPerDay) {
            console.log("beforeTotalPerDay", beforeTotalPerDay);
            console.log("beforeApprovedPerDay", beforeApprovedPerDay);
            // Ensure data exists
            beforeTotalPerDay = beforeTotalPerDay || {};
            beforeApprovedPerDay = beforeApprovedPerDay || {};

            // Get all unique dates from `total` and `approved`
            const allDates = new Set([
                ...Object.keys(beforeTotalPerDay),
                ...Object.keys(beforeApprovedPerDay) // Ensure both datasets contribute to x-axis
            ]);

            // Convert dates to sorted timestamps
            const sortedDates = [...allDates].map(dateStr => new Date(dateStr)).sort((a, b) => a - b);
            const categories = sortedDates.map(date => date.toISOString().split("T")[0]); // Format YYYY-MM-DD

            // Prepare data for chart (ensuring all dates are included, defaulting missing values to 0)
            var totalData = sortedDates.map(date => [
                date.getTime(), beforeTotalPerDay[date.toISOString().split("T")[0]] || 0
            ]);

            var approvedData = sortedDates.map(date => [
                date.getTime(), beforeApprovedPerDay[date.toISOString().split("T")[0]] || 0
            ]);

            var AreachartSplineColors = getChartColorsArray("project_status");

            var options = {
                chart: {
                    height: 268,
                    type: "area"
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: "smooth",
                    width: 2
                },
                series: [{
                    name: "Total Society",
                    data: totalData
                },
                {
                    name: "Approved",
                    data: approvedData
                }
                ],
                colors: AreachartSplineColors,
                xaxis: {
                    type: "datetime",
                    categories: categories, // Use proper date format
                    convertedCatToNumeric: false, // Prevents ApexCharts from converting categories
                    labels: {
                        formatter: function (value) {
                            let date = new Date(value);
                            return date.toLocaleString("en-US", {
                                day: "numeric",
                                month: "short",
                                year: "numeric"
                            });
                        }
                    }
                },
                grid: {
                    borderColor: "#f1f1f1"
                },
                tooltip: {
                    x: {
                        format: "dd MMM yyyy"
                    }
                },
                annotations: {
                    yaxis: [],
                    xaxis: [],
                    points: []
                } // Ensure annotations exist
            };

            console.log("Updated Options:", options);

            if (chartproject) {
                chartproject.destroy();
            }

            console.log("Initializing new chart...");
            chartproject = new ApexCharts(document.querySelector("#project_status"), options);
            chartproject.render();
        }

        // Initial Data
        var initialBeforeTotalPerDay = @json($currenttotalPerDay, JSON_NUMERIC_CHECK) || {};
        var initialBeforeApprovedPerDay = @json($currentapprovedPerDay, JSON_NUMERIC_CHECK) || {};
        renderChart(initialBeforeTotalPerDay, initialBeforeApprovedPerDay);

        function filter() {
            var selectedMonth = document.getElementById("monthSelect").value;
            var selectedYear = document.getElementById("yearSelect").value;

            $.ajax({
                url: "{{ route('getChartData') }}",
                type: "GET",
                data: {
                    month: selectedMonth,
                    year: selectedYear
                },
                success: function (response) {
                    console.log("Filtered Data:", response);
                    renderChart(response.total, response.approved);
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching chart data:", error);
                }
            });
        }
    </script>
    <script>
        var pendingSociety = @json($pendingData);
        var totalSociety = @json($totalData);
        var BarchartColumnColors = getChartColorsArray("project_pending");
        BarchartColumnColors && (options = {
            chart: {
                height: 290,
                type: "bar",
                toolbar: {
                    show: !1
                }
            },
            plotOptions: {
                bar: {
                    horizontal: !1,
                    columnWidth: "45%",
                    endingShape: "rounded"
                }
            },
            dataLabels: {
                enabled: !1
            },
            stroke: {
                show: !0,
                width: 2,
                colors: ["transparent"]
            },
            series: [{
                name: "Total Society",
                data: totalSociety
            }, {
                name: "Pending Society",
                data: pendingSociety
            }],
            colors: BarchartColumnColors,
            xaxis: {
                categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
            },

            grid: {
                borderColor: "#f1f1f1"
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    // formatter: function(e) {
                    //     return "$ " + e + " thousands"
                    // }
                }
            }
        }, (chart = new ApexCharts(document.querySelector("#project_pending"), options)).render());
    </script>



    <script>
        var totalSociety = @json($arr['total_society']);
        var rejectSociety = @json($arr['rejected_society']);
        var options, chart, DonutchartDonutColors = getChartColorsArray("rejected_project");
        DonutchartDonutColors && (options = {
            chart: {
                height: 395,
                type: "donut"
            },
            series: [totalSociety, rejectSociety],
            labels: ["Total Society", "Rejected Society"],
            colors: DonutchartDonutColors,
            legend: {
                show: !0,
                position: "bottom",
                horizontalAlign: "center",
                verticalAlign: "middle",
                floating: !1,
                fontSize: "14px",
                offsetX: 0
            },
            responsive: [{
                breakpoint: 600,
                options: {
                    chart: {
                        height: 240
                    },
                    legend: {
                        show: !1
                    }
                }
            }]
        }, (chart = new ApexCharts(document.querySelector("#rejected_project"), options)).render());
    </script>
@endsection