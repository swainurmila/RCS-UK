@extends('layouts.app')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">{{ __('messages.Audit Allotment') }}</h4>
                    <input type="hidden" id="hdnDistrict" />
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item">
                                <a href="javascript: void(0);">
                                    {{ __('messages.Audit Allotment') }}
                                </a>
                            </li>
                            <li class="breadcrumb-item active">{{ __('messages.Allotment Of Society For Audit') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body cstm-cd-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">{{ __('messages.Financial Year') }}<span class="text-danger">*</span></label>
                            <select class="form-select form-control financialYear" id="finYear">
                                <option value="">Select</option>
                                @foreach($financialYear as $data)
                                <option value="{{$data->id}}">
                                    {{$data->financial_year}}
                                </option>
                                @endforeach
                            </select>
                            <span id="finYear_error" class="text-danger1"></span>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="proposed" class="form-label">{{ __('messages.Department Auditor') }}<span class="text-danger">*</span></label>
                            <select class="form-select form-control" id="departmentid">
                                <option value=""> Select</option>
                                @foreach($dept_auditor as $data)
                                <option value="{{$data->id}}">
                                    {{$data->name}}
                                </option>
                                @endforeach
                            </select>
                            <span id="departmentid_error" class="text-danger1"></span>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">{{ __('messages.Society Type') }}<span class="text-danger">*</span></label><br>
                            <select class="form-select form-control" id="type">
                                <option value="">Select</option>
                                @foreach($society_type as $society)
                                <option value="{{$society->id}}">{{$society->type}}</option>
                                @endforeach
                            </select>
                            <span id="type_error" class="text-danger1"></span>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label>District <span class="text-danger">*</span></label>
                            <select class="form-select form-control" id="ddlDistrict">
                                <option value="">{{ __('messages.Select-District') }}</option>
                                @foreach($district as $dist)
                                <option value="{{ $dist->id }}">{{ $dist->name }}</option>
                                @endforeach
                            </select>
                            <span id="ddlDistrict_error" class="text-danger1"></span>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label>Block <span class="text-danger">*</span></label>
                            <select class="form-select form-control" id="block">
                                <option value="">{{ __('messages.Select Block') }}</option>
                            </select>
                            <span id="block_error" class="text-danger1"></span>
                        </div>
                    </div>
                    <div class="col-lg-2" style="margin-top: 30px;">
                        <div class="mb-3">
                            <button class="btn btn-primary" onclick="societyOn()">Search</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body cstm-cd-body">
                <form method="post" action="/DAO/AuditAllotmentToSociety" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <label class="form-label">Select Society<span class="text-danger">*</span></label>
                        <div class="dropdown position-relative">
                            <button class="btn btn-outline-primary dropdown-toggle w-100 text-start" type="button" id="dropdownSocietyButton" data-bs-toggle="dropdown" aria-expanded="false">
                                Select Societies
                            </button>
                            <div class="dropdown-menu w-100 p-2 shadow" style="max-height: 300px; overflow-y: auto;" aria-labelledby="dropdownSocietyButton">
                                <input type="text" class="form-control mb-2" id="societySearchInput" placeholder="🔍 Search societies...">
                                <div id="societyCheckboxList">
                                    <!-- Societies will be injected here -->
                                </div>
                            </div>
                        </div>
                        <span id="societySelectionDiv_error" class="text-danger1"></span>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Selected Societies</label>
                        <textarea id="selectedSocietiesTextArea" class="form-control tarea" rows="2" readonly placeholder="Selected societies will appear here"></textarea>
                    </div>

                    <div class="text-end mt-3">
                        <button type="button" class="btn btn-success" id="submitBtn">Save</button>
                    </div>
                </form>
                <div b-i35rxr3lw3 id="loader-wrapper">
                    <div b-i35rxr3lw3 class="loader"></div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="row mt-3">
                <div class="container scroll-lg">
                    <table id="auditAllotmentTable" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Sl#</th>
                                <th>Society</th>
                                <th>District</th>
                                <th>Type</th>
                                <th>Block</th>
                                <th>Financial Year</th>
                                <th>Department Auditor Name</th>
                            </tr>
                        </thead>
                        <tbody id="auditAllotmentDetails">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    window.addEventListener('load', function() {
        const loader = document.getElementById('loader-wrapper');
        if (loader) {
            loader.style.display = 'none';
        }
    });
</script>
<script>
    $(document).ready(function() {
        $('#ddlDistrict').on('change', function() {
            const distId = $(this).val();
            resetDependentDropdowns(['block']);
            if (distId) {
                loadBlocks(distId);
            }
        });

        function loadBlocks(districtId, selectedBlock = null) {
            $.post("{{ route('get-blocks-by-district') }}", {
                _token: "{{ csrf_token() }}",
                district: districtId
            }, function(resp) {
                $('#block').html(resp.options);
                if (selectedBlock) {
                    $('#block').val(selectedBlock);
                }
            });
        }

        function resetDependentDropdowns(selectIds) {
            selectIds.forEach(id => {
                $('#' + id).html('<option value="">Select</option>');
            });
        }
    });

    function attachSocietyDropdownListeners() {

        $('.dropdown-menu').on('click', function(e) {
            e.stopPropagation();
        });
        $('#societySearchInput').on('input', function() {
            $('#status, #preloader').show();

            const query = $(this).val().toLowerCase();

            setTimeout(() => {
                $('#societyCheckboxList .form-check').each(function() {
                    const text = $(this).text().toLowerCase();
                    $(this).toggle(text.includes(query));
                });
                $('#status, #preloader').fadeOut();
            }, 300);
        });

        $(document).on('change', '.society-checkbox', function() {
            const selected = $('.society-checkbox:checked').map(function() {
                return $(this).data('name');
            }).get().join(', ');
            $('#selectedSocietiesTextArea').val(selected);
        });
    }

    function societyOn() {
        const districtCode = $("#ddlDistrict").val();
        const societyType = $('#type').val();
        const block = $('#block').val();

        if (!societyType) {
            $('#type_error').text("Society type is required.");
            return;
        }
        if (!districtCode) {
            $('#ddlDistrict_error').text("District is required.");
            return;
        }
        if (!block) {
            $('#block_error').text("block is required.");
            return;
        }

        let data = {
            _token: "{{ csrf_token() }}",
            district: districtCode,
            block: block,
            type: societyType
        };

        $.ajax({
            url: "{{ route('fetch-societies-for-audit') }}",
            method: "POST",
            data: data,
            beforeSend: function() {
                $('#loader-wrapper').show();
            },
            success: function(res) {
                let html = '';
                if (res.length > 0) {
                    res.forEach(item => {
                        html += `
                    <div class="form-check">
                        <input class="form-check-input society-checkbox" type="checkbox" value="${item.id}" data-name="${item.society_details.society_name}" id="society_${item.id}">
                        <label class="form-check-label" for="society_${item.id}">${item.society_details.society_name}</label>
                    </div>`;
                    });
                } else {
                    html = '<p class="text-muted text-center">No societies found.</p>';
                }
                $('#societyCheckboxList').html(html);
                attachSocietyDropdownListeners();
            },
            error: function(err) {
                console.error("Error loading societies:", err);
            },
            complete: function() {
                $('#loader-wrapper').hide();
            }
        });
    }

    $('#submitBtn').on('click', function() {
        let selectedSocieties = [];
        $('.society-checkbox:checked').each(function() {
            selectedSocieties.push($(this).val());
        });

        let finYear = $('#finYear').val();
        let departmentId = $('#departmentid').val();
        let type = $('#type').val();
        let district = $('#ddlDistrict').val();
        let block = $('#block').val();

        let hasError = false;

        $('#finYear_error').text('');
        $('#departmentid_error').text('');
        $('#type_error').text('');
        $('#ddlDistrict_error').text('');
        $('#block_error').text('');
        $('#societySelectionDiv_error').text('');

        if (!finYear) {
            $('#finYear_error').text("Financial Year is required.");
            hasError = true;
        }

        if (!departmentId) {
            $('#departmentid_error').text("Department Auditor is required.");
            hasError = true;
        }

        if (!type) {
            $('#type_error').text("Society Type is required.");
            hasError = true;
        }

        if (!district) {
            $('#ddlDistrict_error').text("District is required.");
            hasError = true;
        }

        if (!block) {
            $('#block_error').text("Block is required.");
            hasError = true;
        }

        if (selectedSocieties.length === 0) {
            $('#societySelectionDiv_error').text("Please select at least one society.");
            hasError = true;
        }

        if (hasError) return;

        $.ajax({
            url: "{{ route('save-audit-allotment') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                fy_id: finYear,
                dept_auditor_id: departmentId,
                society_type_id: type,
                district_id: district,
                block_id: block,
                societies: selectedSocieties
            },
            // beforeSend: function() {
            //     $('#loader-wrapper').fadeIn(200);
            // },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                        customClass: {
                            popup: 'swal2-medium-text'
                        }
                    });

                    $('#auditAllotmentTable').DataTable().ajax.reload(null, false);
                    $('.society-checkbox').prop('checked', false);
                    $('#societySelectionDiv').hide();
                    $('#selectedSocietiesTextArea').val('');
                } else {
                    alert(response.message || "Error saving data.");
                }
            },
            error: function(xhr) {
                alert("An error occurred while saving data.");
                console.error(xhr.responseText);
            },
            // complete: function() {
            //     $('#loader-wrapper').fadeOut(200);
            // }
        });
    });

    $(function() {
        $('#auditAllotmentTable').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            scrollX: true,
            responsive: false,
            ajax: {
                url: "{{ route('get-allotted-societies') }}",
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'society_name',
                    name: 'society_name'
                },
                {
                    data: 'district_name',
                    name: 'district_name'
                },
                {
                    data: 'society_type',
                    name: 'society_type'
                },
                {
                    data: 'block_name',
                    name: 'block_name'
                },
                {
                    data: 'financial_year',
                    name: 'financial_year'
                },
                {
                    data: 'auditor_name',
                    name: 'auditor_name'
                },
                // { data: 'action', name: 'action' }, 
            ]
        });
    });
</script>
@endsection