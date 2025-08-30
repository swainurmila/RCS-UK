@extends('layouts.app')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Dashboard</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">EAudit</a></li>
                                <li class="breadcrumb-item active">Dashboard Society</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card ">
                        <div class="card-body p-0">
                            <div class="row dash-card-row">
                                <div class="dash-col">
                                    <div class="card dash-card card1">
                                        <div class="card-body dash-card-body">
                                            <div class="dash-img"> <img src="/EAudit/assets/images/flaticons/audit.png" class="img-fluid"></div>
                                            <p class="mb-0">Total No of Audit</p>
                                            <h4 class="mb-1 mt-1"><span data-plugin="counterup">2500</span></h4>
                                            <button class="text-muted text-value btn btn-outline-primary" onclick="openModal()" id="viewDetails">
                                                View Details
                                            </button>
                                        </div>
                                    </div>
                                </div> <!-- end col-->

                                <div class="dash-col">
                                    <div class="card dash-card card2">
                                        <div class="card-body dash-card-body">
                                            <div class="dash-img"> <img src="/EAudit/assets/images/flaticons/check-list.png" class="img-fluid"></div>
                                            <p class="mb-0">No. of Audit Approved</p>
                                            <h4 class="mb-1 mt-1"><span data-plugin="counterup">1500</span></h4>
                                            <button class="text-muted text-value btn btn-outline-primary" onclick="openApprovedModal()" id="appviewDetails">
                                                View Details
                                            </button>
                                        </div>
                                    </div>
                                </div> <!-- end col-->

                                <div class="dash-col">
                                    <div class="card dash-card card3">
                                        <div class="card-body dash-card-body">
                                            <div class="dash-img"><img src="/EAudit/assets/images/flaticons/search.png" class="img-fluid"></div>
                                            <p class="mb-0">No. of Audit Pending</p>
                                            <h4 class="mb-1 mt-1"><span data-plugin="counterup">1000</span></h4>
                                            <button class="text-muted text-value btn btn-outline-primary" onclick="pendingopenModal()" id="pendingviewDetails">
                                                View Details
                                            </button>
                                        </div>
                                    </div>
                                </div> <!-- end col-->

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Circlewise Audit</h4>

                            <div id="column_chart1" data-colors='["--bs-warning", "--bs-primary", "--bs-success"]' class="apex-charts" dir="ltr"></div>
                        </div>
                    </div><!--end card-->
                </div>

                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4" style="color: #fff!important">Radial Chart</h4>

                            <div id="radial_chart1" data-colors='["--bs-primary", "--bs-success", "--bs-info" ,"--bs-warning"]' class="apex-charts" dir="ltr"></div>
                        </div>
                    </div><!--end card-->
                </div>

            </div> <!-- end row -->

            <div class="row">
                <div class="cpl-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responssive w-100">
                                <table id="datatable" class="table table-stripped table-bordered w-100 dt-responsive nowrap">
                                    <thead>
                                        <tr>
                                            <th>Sl#</th>
                                            <th>Name</th>
                                            <th>Block Name</th>
                                            <th>Name of the Society</th>
                                            <th>Type</th>
                                            <th>Audit Start Date</th>
                                            <th>Audit End Date</th>
                                            <th>Entry Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="auditPlanningProgressDetails">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- View Modal -->
        </div> <!-- container-fluid -->
    </div>

@endsection


@section('js')



<script>
    $(document).ready(function() {
        GetAuditorPlanningForHistory();
    });

    //This function for add badge design using specific status
    function getBadgeClass(status) {
        if (status === "Pending") {
            return "bg-primary";
        } else if (status === "Pending At BCEO") {
            return "bg-info";
        } else if (status === "Rejected") {
            return "bg-danger";
        } else {
            return "bg-success";
        }
    }

    function GetAuditorPlanningForHistory() {
        var auditPlanningProgressDetails = $("#auditPlanningProgressDetails");
        $.ajax({
            url: baseurl + '/DAO/GetAuditorPlanningForHistory',
            type: 'POST',
            dataType: "json",
            success: function(response) {
                auditPlanningProgressDetails.empty();
                if (response && Array.isArray(response) && response.length > 0) {
                    response.forEach((data, index) => {
                        auditPlanningProgressDetails.append(`
                                                             <tr>
                                                                <td>${index + 1}</td>
                                                                <td>${data.departmentAuditorName}</td>
                                                                <td>${data.blockName}</td>
                                                                <td>${data.societyName}</td>
                                                                <td>${data.type == 1 ? "PACS" : "Vyapar Mandal"}</td>
                                                                <td>${data.startAuditDate.split('T')[0]}</td>
                                                                <td>${data.endAuditDate.split('T')[0]}</td>
                                                                <td>${data.entryDate.split('T')[0]}</td>
                                                                <td><span class="badge rounded-pill ${getBadgeClass(data.societyStatus)}">${data.societyStatus}</span></td>
                                                            </tr>
                
                                                        `);
                    });
                } else {
                    auditPlanningProgressDetails.append(`
                                        <tr>
                                            <td colspan="9" class="text-center">
                                                <div class="alert alert-info m-3" role="alert">
                                                    No data present in auditor planning.
                                                </div>
                                            </td>
                                        </tr>
                                    `);
                }
            },
            error: function(error) {
                console.error('Error loading data: ' + error);
            }
        });
    }

    function getChartColorsArray(e) {
        if (null !== document.getElementById(e)) {
            var t = document.getElementById(e).getAttribute("data-colors");
            if (t)
                return (t = JSON.parse(t)).map(function(e) {
                    var t = e.replace(" ", "");
                    if (-1 === t.indexOf(",")) {
                        var r = getComputedStyle(document.documentElement).getPropertyValue(
                            t
                        );
                        return r || t;
                    }
                    var a = e.split(",");
                    return 2 != a.length ?
                        t :
                        "rgba(" +
                        getComputedStyle(document.documentElement).getPropertyValue(
                            a[0]
                        ) +
                        "," +
                        a[1] +
                        ")";
                });
        }
    }


    var BarchartColumnColors = getChartColorsArray("column_chart1");
    BarchartColumnColors &&
        ((options = {
                chart: {
                    height: 350,
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
                    },
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
                        name: "Net Profit",
                        data: [46, 57, 59, 54, 62, 58, 64, 60, 66]
                    },
                    {
                        name: "Revenue",
                        data: [74, 83, 102, 97, 86, 106, 93, 114, 94]
                    },
                    {
                        name: "Free Cash Flow",
                        data: [37, 42, 38, 26, 47, 50, 54, 55, 43]
                    },
                ],
                colors: BarchartColumnColors,
                xaxis: {
                    categories: [
                        "Feb",
                        "Mar",
                        "Apr",
                        "May",
                        "Jun",
                        "Jul",
                        "Aug",
                        "Sep",
                        "Oct",
                    ],
                },
                yaxis: {
                    title: {
                        text: "$ (thousands)"
                    }
                },
                grid: {
                    borderColor: "#f1f1f1"
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function(e) {
                            return "$ " + e + " thousands";
                        },
                    },
                },
            }),
            (chart = new ApexCharts(
                document.querySelector("#column_chart1"),
                options
            )).render());




    var RadiachartRadialColors = getChartColorsArray("radial_chart1");
    RadiachartRadialColors &&
        ((options = {
                chart: {
                    height: 370,
                    type: "radialBar"
                },
                plotOptions: {
                    radialBar: {
                        dataLabels: {
                            name: {
                                fontSize: "22px"
                            },
                            value: {
                                fontSize: "16px"
                            },
                            total: {
                                show: !0,
                                label: "Total",
                                formatter: function(e) {
                                    return 249;
                                },
                            },
                        },
                    },
                },
                series: [44, 55, 67, 83],
                labels: ["Computer", "Tablet", "Laptop", "Mobile"],
                colors: RadiachartRadialColors,
            }),
            (chart = new ApexCharts(
                document.querySelector("#radial_chart1"),
                options
            )).render());
</script>
@endsection