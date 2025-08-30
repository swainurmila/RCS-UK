@extends('layouts.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- Header -->
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Audit Plan Approved By Society</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="#">Audit Plan</a></li>
                            <li class="breadcrumb-item active">Audit Plan Approved By Society</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Card -->
        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-lg-12">
                        <div class="p-4 rounded-4 shadow border position-relative overflow-hidden"
                            style="background: linear-gradient(135deg, #f8f9fa, #e9f5ff); border-left: 6px solid #0d6efd;">
                            <div class="position-absolute top-0 end-0 p-3">
                                <i class="bi bi-calendar-check-fill text-primary fs-2 opacity-25"></i>
                            </div>
                            <p class="mb-0 text-dark fs-8 lh-base">
                                <span class="me-1">📌</span>
                                To facilitate the timely audit of your committee, the Cooperative Department has appointed departmental auditor
                                <span id="name" class="fw-bold text-dark"></span>,
                                for the audit and a date can be fixed for it. The date of proposed audit is from
                                <span id="auditStartDate" class="fw-bold text-success"></span>
                                to
                                <span id="auditEndDate" class="fw-bold text-danger"></span>.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Consent Options -->
                <div class="row consentRow">
                    <div class="col-lg-3">
                        <label class="form-label">Would you like to give your consent?</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="Yes">
                            <label class="form-check-label" for="flexRadioDefault1">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" value="No">
                            <label class="form-check-label" for="flexRadioDefault2">No</label>
                        </div>
                    </div>

                    <div class="col-lg-3 d-none" id="reasondiv">
                        <label class="form-label">Reason</label>
                        <select class="form-select" id="reasondetails">
                            <option value="">Select</option>
                            <option value="Update Audit Date">Update Audit Date</option>
                            <option value="Audit By CA">Audit By CA</option>
                        </select>
                    </div>

                    <div class="col-lg-3 d-none" id="auditstartdatediv">
                        <label class="form-label">Audit Start Date (Society)</label>
                        <input type="date" class="form-control" id="auditstartdate" />
                    </div>

                    <div class="col-lg-3 d-none" id="auditenddatediv">
                        <label class="form-label">Audit End Date (Society)</label>
                        <input type="date" class="form-control" id="auditenddate" />
                    </div>

                    <div class="col-lg-3 d-none" id="cadiv">
                        <label class="form-label">CA Name</label>
                        <select class="form-select" id="ddlCA">
                            <option value="">Select</option>
                            <option value="9198">democa1</option>
                            <option value="9199">democa2</option>
                            <option value="9200">democa3</option>
                            <option value="9201">democa5</option>
                            <option value="9202">democa4</option>
                            <option value="9234">CAdemo</option>
                        </select>
                    </div>
                </div>

                <!-- Audit Details Table -->
                <div class="row mt-4 d-none" id="auditdetails">
                    <div class="col-lg-12">
                        <table class="rwd-table table table-bordered">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Name of the Society</th>
                                    <th>Society Type</th>
                                    <th>Audit Start Date</th>
                                    <th>Audit End Date</th>
                                    <th>Audit Start Date (Society)</th>
                                    <th>Audit End Date (Society)</th>
                                    <th>Entry Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="auditdtlstbody"></tbody>
                        </table>
                    </div>
                </div>

                <!-- Submit Button -->
                <div id="saveBtn" class="d-flex justify-content-end mt-3 d-none">
                    <input type="button" class="btn btn-primary" value="Submit" onclick="approvalSubmit()">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('input[name="flexRadioDefault"]').on('change', handleConsentChange);
        $('#reasondetails').on('change', reason);
    });

    function handleConsentChange() {
        const consentValue = $('input[name="flexRadioDefault"]:checked').val();
        if (consentValue === "Yes" || consentValue === "No") {
            GetAuditPlanningBySociety();
            $("#auditdetails, #saveBtn").removeClass("d-none");
        }

        if (consentValue === "Yes") {
            $("#reasondiv, #cadiv, #auditstartdatediv, #auditenddatediv").addClass("d-none");
        } else {
            $("#reasondiv").removeClass("d-none");
        }
    }

    function reason() {
        const val = $("#reasondetails").val();
        if (val === "Update Audit Date") {
            $("#auditstartdatediv, #auditenddatediv").removeClass("d-none");
            $("#cadiv").addClass("d-none");
        } else if (val === "Audit By CA") {
            $("#cadiv").removeClass("d-none");
            $("#auditstartdatediv, #auditenddatediv").addClass("d-none");
        } else {
            $("#auditstartdatediv, #auditenddatediv, #cadiv").addClass("d-none");
        }
    }

    function getStatusLabel(status) {
        switch (status) {
            case 1:
                return 'Pending';
            case 2:
                return 'Approved';
            case 3:
                return 'Rejected';
            default:
                return 'Unknown';
        }
    }

    function getBadgeClass(status) {
        switch (status) {
            case 1:
                return 'bg-warning'; 
            case 2:
                return 'bg-success';
            case 3:
                return 'bg-danger'; 
            default:
                return 'bg-secondary'; 
        }
    }


    function GetAuditPlanningBySociety() {
        $.ajax({
            url: "{{ route('auditor-planning') }}",
            type: 'GET',
            dataType: 'json',
            beforeSend: function() {
                $('#loader-wrapper').fadeIn(200);
            },
            complete: function() {
                $('#loader-wrapper').fadeOut(200);
            },
            success: function(response) {
                const body = $("#auditdtlstbody");
                body.empty();

                if (Array.isArray(response.data) && response.data.length > 0) {
                    response.data.forEach(data => {
                        const checkboxHtml = `<input type="checkbox" class="logic-checkbox" style="transform: scale(1.3); margin-top: 4px;"
                            data-name="${data.auditor.name || ''}"
                            data-start="${data.audit_start_date || ''}"
                            data-end="${data.audit_end_date || ''}" />`;

                        body.append(`
                            <tr>
                                <td>${checkboxHtml}</td>
                                <td><input type="hidden" class="auditorPlanningId" value="${data.id}">${data.dept_auditor_id || ""}</td>
                                <td>${data.society_name || ""}</td>
                                <td>${data.society_type || ""}</td>
                                <td>${data.audit_start_date || ""}</td>
                                <td>${data.audit_end_date || ""}</td>
                                <td>${data.audit_start_date_society || ""}</td>
                                <td>${data.audit_end_date_society || ""}</td>
                                <td>${data.created_at?.split('T')[0] || ""}</td>
                               <td><span class="badge rounded-pill ${getBadgeClass(data.status)}">${getStatusLabel(data.status)}</span></td>
                            </tr>
                        `);
                    });

                    $(".logic-checkbox").on("change", function() {
                        $(".logic-checkbox").not(this).prop("checked", false);
                        if ($(this).is(":checked")) {
                            $("#name").text($(this).data("name"));
                            $("#auditStartDate").text($(this).data("start"));
                            $("#auditEndDate").text($(this).data("end"));
                        } else {
                            $("#name, #auditStartDate, #auditEndDate").text("");
                        }
                    });

                    $("#auditdetails, #saveBtn").removeClass("d-none");
                } else {
                    $("#auditdetails, #saveBtn").addClass("d-none");

                }
            },
            error: function(err) {
                console.error("Error fetching audit planning data:", err);
            }
        });
    }

    function approvalSubmit() {
        const consent = $('input[name="flexRadioDefault"]:checked').val();
        const selectedReason = $("#reasondetails").val();
        const startDate = $("#auditstartdate").val();
        const endDate = $("#auditenddate").val();
        const caId = $("#ddlCA").val();
        const checkedBox = $(".logic-checkbox:checked");

        if (!consent) {
            alert("Please select Yes or No for consent.");
            return;
        }

        if (checkedBox.length === 0) {
            alert("Please select one audit entry.");
            return;
        }

        const auditorPlanningId = checkedBox.closest("tr").find(".auditorPlanningId").val();

        let payload = {
            audit_alotment_id: auditorPlanningId,
            consent: consent,
            current_role: 'arcs', // fixed for both cases
        };

        if (consent === "No") {
            if (!selectedReason) {
                alert("Please select a reason.");
                return;
            }

            payload.reason = selectedReason;

            if (selectedReason === "Update Audit Date") {
                if (!startDate || !endDate) {
                    alert("Please provide both start and end dates.");
                    return;
                }
                payload.audit_start_date_society = startDate;
                payload.audit_end_date_society = endDate;

            } else if (selectedReason === "Audit By CA") {
                if (!caId) {
                    alert("Please select a CA.");
                    return;
                }
                payload.ca_id = caId;
            }
        }

        $.ajax({
            url: "{{ route('audit.society-approval.store') }}",
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            data: payload,
            beforeSend: function() {
                $('#loader-wrapper').fadeIn(200);
            },
            complete: function() {
                $('#loader-wrapper').fadeOut(200);
            },
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    location.reload();
                } else {
                    alert(response.message || "Something went wrong.");
                }
            },
            error: function(xhr) {
                console.error(xhr);
                alert("An error occurred while submitting.");
            }
        });
    }
</script>
@endsection