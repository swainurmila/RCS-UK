@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">{{ __('messages.Inspection-Records-List') }}</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">
                                        {{ __('messages.cooperatives_department') }}
                                    </a>
                                </li>
                                <li class="breadcrumb-item active">{{ __('messages.Inspection-Records-List') }}</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body p-0 dash-body">

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body p-0">
                                            @if (Auth::user()->role_id == 6)
                                                <div>
                                                    <!-- Target Assign Button -->
                                                    <button class="btn btn-primary float-start" type="button"
                                                        id="submit_btn1" data-bs-toggle="modal"
                                                        data-bs-target="#targetAssignModal">
                                                        <i class="bi bi-clipboard-check"></i>
                                                        {{ __('messages.Target-Assign') }}
                                                    </button>
                                                </div>
                                            @endif

                                            <table id="datatable-buttons"
                                                class="table table-striped table-hover display nowrap" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>{{ __('messages.SINo') }}</th>
                                                        <th>{{ __('messages.district') }}</th>
                                                        <th>{{ __('messages.designation') }}</th>
                                                        <th>{{ __('messages.Assign-Officer') }}</th>
                                                        <th>{{ __('messages.No-of-assigned-society') }}</th>
                                                        <th>{{ __('messages.created-by') }}</th>
                                                        <th>{{ __('messages.Inspection-status') }}</th>
                                                        <th>{{ __('messages.Action') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($target_details as $key => $item)
                                                        <tr>
                                                            <td>{{ ++$key }}</td>
                                                            <td>{{ $item->districtName->name }}</td>
                                                            <td class="wrap-text">
                                                                {{ $item->designation->display_name }}</td>
                                                            <td>{{ $item->AssignedOfficer->name }}</td>
                                                            <td>{{ $item->society_count }}</td>
                                                            <td class="text-capitalize">{{ $item->CreatedBy->name }}
                                                            </td>
                                                            <td>
                                                                <span class="badge {{ $item->status_label['class'] }}">
                                                                    {{ $item->status_label['text'] }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                @if (($roleId == 5 && $item->status == 1) || ($roleId == 3 && $item->status == 2))
                                                                    <button class="btn btn-sm btn-success open-assign-modal"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#assignTargetModal"
                                                                        data-id="{{ $item->id }}"
                                                                        data-district="{{ $item->districtName->id }}"
                                                                        data-district-name="{{ $item->districtName->name }}">
                                                                        <i class="bi bi-plus-circle"></i> Target Assign
                                                                    </button>
                                                                @endif
                                                                <button
                                                                    class="btn btn-outline-info btn-sm view-inspection-history-btn"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#inspectionHistoryModal"
                                                                    data-id="{{ $item->id }}">
                                                                    <i class="fas fa-history"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>


                                        </div>
                                    </div>
                                    <!-- end card -->
                                </div>
                                <!-- end col -->
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->
            </div>
        </div>
    </div>

    <div class="modal fade" id="inspectionHistoryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="inspectionHistoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Inspection Target Flow History') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="inspectionHistoryModalBody">
                    <div class="text-center py-4">Loading...</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Target Assign Modal -->
    <div class="modal fade" id="targetAssignModal" tabindex="-1" aria-labelledby="targetAssignModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('inspection-target.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="targetAssignModalLabel">Assign Target</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <!-- District Dropdown -->
                        <div class="mb-3">
                            <label for="district" class="form-label">District</label>
                            <select class="form-select" id="district" name="dist_id" required>
                                <option value="">-- Select District --</option>
                                @foreach ($district as $district)
                                    <option value="{{ $district->id }}">{{ $district->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Designation Dropdown -->
                        <div class="mb-3">
                            <label for="designation" class="form-label">Designation</label>
                            <select class="form-select" id="designation" name="designation_id" required>
                                <option value="">-- Select Designation --</option>
                                <option value="drcs">DRCS</option>
                                <option value="arcs">ARCS</option>
                            </select>
                        </div>

                        <!-- Assigned Officer Name -->
                        <div class="mb-3">
                            <label for="officer_name" class="form-label">Assigned Officer</label>
                            <input type="text" class="form-control" id="officer_name"
                                placeholder="Auto-filled officer name" readonly required>
                            <input type="hidden" name="assigned_officer_id" id="assigned_officer_id">
                        </div>



                        <!-- Society Count -->
                        <div class="mb-3">
                            <label for="society_count" class="form-label">Society Count</label>
                            <input type="number" class="form-control" id="society_count" name="society_count"
                                min="1" required>
                            <small id="society_count_error" class="text-danger d-none">Society count cannot exceed the
                                maximum available.</small>
                        </div>
                        <!-- Optional max count message -->
                        <div id="max_count_display" class="text-muted mb-2"></div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Submit</button>

                    </div>
                </div>
            </form>
        </div>
    </div>

    @include('inspection.modals.assign_target_modal')
@endsection
@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.view-inspection-history-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-id');
                    const modalBody = document.getElementById('inspectionHistoryModalBody');
                    modalBody.innerHTML = '<div class="text-center py-4">Loading...</div>';

                    const historyBaseUrl = @json(route('inspection-targets.history', ['target' => 'TARGET_ID']));
                    const url = historyBaseUrl.replace('TARGET_ID', targetId);

                    fetch(url)
                        .then(response => response.text())
                        .then(html => {
                            modalBody.innerHTML = html;
                        })
                        .catch(() => {
                            modalBody.innerHTML =
                                '<div class="text-danger text-center">Failed to load history.</div>';
                        });
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#district').on('change', function() {
                let districtId = $(this).val();

                if (districtId) {
                    $.ajax({
                        url: "{{ route('get.society.count') }}",
                        type: 'GET',
                        data: {
                            district_id: districtId
                        },
                        success: function(response) {
                            let count = response.count;

                            // Set max value on input
                            $('#society_count').attr('max', count);

                            // Display the count to user
                            $('#max_count_display').text(`Available Society: ${count}`);
                        },
                        error: function() {
                            Swal.fire("Error", "Failed to fetch society count.", "error");
                        }
                    });
                }
            });

            // Prevent user from entering value more than max
            $('#society_count').on('input', function() {
                let max = parseInt($(this).attr('max'));
                let val = parseInt($(this).val());

                if (val > max) {
                    $(this).val(max);
                    $('#society_count_error').removeClass('d-none');
                } else {
                    $('#society_count_error').addClass('d-none');
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            function fetchOfficers() {
                let distId = $('#district').val();
                let designation = $('#designation').val();

                if (distId && designation) {
                    $.ajax({
                        url: "{{ route('get-designation-wise-officers') }}",
                        type: 'GET',
                        data: {
                            district_id: distId,
                            designation: designation
                        },
                        success: function(data) {
                            if (data.length > 0) {
                                const officer = data[0];
                                $('#officer_name').val(officer.name);
                                $('#assigned_officer_id').val(officer.id);
                            } else {
                                $('#officer_name').val('');
                                $('#assigned_officer_id').val('');
                                Swal.fire("No Officer Found",
                                    "No officers found for the selected district and designation.",
                                    "info");
                            }
                        },
                        error: function() {
                            $('#officer_name').val('');
                            $('#assigned_officer_id').val('');
                            Swal.fire("Error", "Error fetching officer.", "error");
                        }
                    });
                } else {
                    $('#officer_name').val('');
                    $('#assigned_officer_id').val('');
                }
            }

            $('#district, #designation').on('change', fetchOfficers);
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.body.addEventListener('click', function(e) {
                if (e.target.closest('.view-history-btn')) {
                    const button = e.target.closest('.view-history-btn');
                    const appId = button.getAttribute('data-id');
                    const modalBody = document.getElementById('inspectionModalBody');

                    modalBody.innerHTML = '<div class="text-center py-4">Loading...</div>';

                    const baseUrl =
                        "{{ route('inspection-applications.history', ['inspection' => 'APP_ID']) }}";
                    const finalUrl = baseUrl.replace('APP_ID', appId);

                    fetch(finalUrl)
                        .then(response => response.text())
                        .then(html => {
                            modalBody.innerHTML = html;
                        })
                        .catch(() => {
                            modalBody.innerHTML =
                                '<div class="text-danger text-center">Failed to load history.</div>';
                        });
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            const getBlocksUrlTemplate = @json(route('get-blocks_by_district', ['district_id' => '__DISTRICT__']));
            const getOfficerUrl = @json(route('get.assigned.officer'));
            const getSocietiesUrlTemplate = @json(route('get-societies', ['district_id' => '__DIST__', 'block_id' => '__BLOCK__']));
            const getSocietiesCheckboxUrl = @json(route('get.societies.checkbox'));
            const roleId = @json($roleId);

            function fetchOfficerAndSocieties() {
                const districtId = $('#modal_district_id').val();
                const blockId = $('#block_id').val();
                const designation = $('#designation_id').val();

                if (districtId && blockId && designation) {
                    // Fetch officer
                    $.ajax({
                        url: getOfficerUrl,
                        type: 'GET',
                        data: {
                            district_id: districtId,
                            block_id: blockId,
                            designation: designation
                        },
                        success: function(data) {
                            $('#assigned_officer_name').val(data.name);
                            $('#assigned_id').val(data.id);
                        },
                        error: function() {
                            $('#assigned_officer_name').val('');
                            $('#assigned_id').val('');
                            alert('Failed to load assigned officer.');
                        }
                    });

                    // Fetch societies
                    if (roleId == 5) {
                        const url = getSocietiesUrlTemplate
                            .replace('__DIST__', districtId)
                            .replace('__BLOCK__', blockId);

                        $.ajax({
                            url: url,
                            type: 'GET',
                            success: function(societies) {
                                let societyOptions = '';
                                $.each(societies, function(index, society) {
                                    societyOptions +=
                                        `<option value="${society.id}">${society.society_name}</option>`;
                                });

                                $('#society_ids').html(societyOptions).val(null).trigger('change');

                                $('#society_ids').select2({
                                    placeholder: "Select Societies",
                                    allowClear: true,
                                    closeOnSelect: false,
                                    width: '100%',
                                    dropdownParent: $('#assignTargetModal')
                                });
                            },
                            error: function() {
                                $('#society_ids').html('');
                                alert('Failed to load societies.');
                            }
                        });
                    } else {
                        loadSocietyCheckboxes(districtId, blockId);
                    }
                }
            }

            function loadSocietyCheckboxes(districtId, blockId) {
                $.ajax({
                    url: getSocietiesCheckboxUrl,
                    type: 'GET',
                    data: {
                        district_id: districtId,
                        block_id: blockId
                    },
                    success: function(societies) {
                        console.log(societies);
                        let checkboxHTML = '';

                        $.each(societies, function(index, society) {
                            const isChecked = society.status == 1;

                            checkboxHTML += `
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="society_ids[]" 
                                        value="${society.id}" id="society_${society.id}"
                                        ${isChecked ? 'checked' : ''}>
                                    <label class="form-check-label" for="society_${society.id}">
                                        <span style="margin-left: 8px; ${isChecked ? 'color:#0d6efd; font-weight:bold;' : ''}">
                                            ${society.society_name} ${isChecked ? '(Inspected)' : ''}
                                        </span>
                                    </label>
                                </div>
                            `;

                        });

                        $('#society_checkboxes').html(checkboxHTML);
                    },
                    error: function() {
                        $('#society_checkboxes').html(
                            '<p class="text-danger">Failed to load societies.</p>');
                    }
                });
            }

            $('.open-assign-modal').on('click', function() {
                const targetId = $(this).data('id');
                const districtId = $(this).data('district');
                const districtName = $(this).data('district-name');

                $('#parent_target_id').val(targetId);
                $('#modal_district_id').val(districtId);
                $('#modal_district_name').val(districtName);

                // Fetch blocks
                $.ajax({
                    url: getBlocksUrlTemplate.replace('__DISTRICT__', districtId),
                    type: 'GET',
                    success: function(blocks) {
                        let blockOptions = `<option value="">-- Select Block --</option>`;
                        $.each(blocks, function(index, block) {
                            blockOptions +=
                                `<option value="${block.id}">${block.name}</option>`;
                        });
                        $('#block_id').html(blockOptions);
                    },
                    error: function() {
                        $('#block_id').html('<option value="">Failed to load blocks</option>');
                    }
                });

                // Reset fields
                $('#assigned_officer_name').val('');
                $('#assigned_id').val('');
                $('#society_ids').html('');
                $('#society_checkboxes').html('');
            });

            $('#block_id').on('change', function() {
                if (roleId == '5') {
                    fetchOfficerAndSocieties();
                }
            });

            $('#block_id, #designation_id').on('change', function() {
                if (roleId != '5') {
                    const blockId = $('#block_id').val();
                    const designation = $('#designation_id').val();
                    if (blockId && designation) {
                        fetchOfficerAndSocieties();
                    }
                }
            });
        });
    </script>
@endsection
