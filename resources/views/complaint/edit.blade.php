@extends('layouts.app')

@section('content')
    <!-- start page title -->
    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">{{ __('messages.Complaint-Submit') }}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a
                                    href="javascript: void(0);">{{ __('messages.cooperatives_department') }}</a>
                            </li>
                            <li class="breadcrumb-item active">{{ __('messages.Complaint-Submit') }}</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="container-fluid">
            <div class="row ">

                <div class="col-lg-12">
                    <div class="card">

                        <div class="card-body p-3 reg-card-body">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="row w-100 m-0 registrationForm">
                                        <form id="fileUploadForm"
                                            action="{{ route('update-complaint', ['id' => Crypt::encryptString($complaint_data->id)]) }}"
                                            method="post" enctype="multipart/form-data">

                                            @csrf

                                            <div class="row">
                                                <div class="col-sm-6" hidden>
                                                    <div class="form-group">
                                                        <label hidden>Complaints ID</label>
                                                        <input type="text" class="form-control" id="txtComplaintsID"
                                                            placeholder="Enter Complaints ID" hidden>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label for=""
                                                            class="form-label">{{ __('messages.Complaint-by') }}</label><span
                                                            class="text-danger">*</span>
                                                        <select name="complaint_by_society" id=""
                                                            class="form-select form-control @error('complaint_by_society') is-invalid @enderror">
                                                            <option value="">
                                                                {{ __('messages.Select-Society') }}
                                                            </option>
                                                            @foreach ($society_by as $societyname)
                                                                <option value="{{ $societyname->id }}"
                                                                    {{ $complaint_data->complaint_by_society_id == $societyname->id ? 'selected' : '' }}>
                                                                    {{ $societyname->society_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                        @error('complaint_by_society')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label for=""
                                                            class="form-label">{{ __('messages.Complaint-Name') }}</label><span
                                                            class="text-danger">*</span>
                                                        <input type="text"
                                                            class="form-control @error('complaint_name') is-invalid @enderror"
                                                            id="txtComplaintName" oninput="removeError('#txtComplaintName')"
                                                            placeholder="{{ __('messages.Complaint-Name') }}"
                                                            maxlength="35"
                                                            onkeypress="return (event.charCode>=65 && event.charCode<=90) || (event.charCode >=97 && event.charCode<=122) || (event.charCode==32) || (event.charCode==46) || (event.charCode>=48 && event.charCode<=57) || (event.charCode==45)"
                                                            autocomplete="off" name="complaint_name"
                                                            value="{{ old('complaint_name', $complaint_data->complaint_name ?? '') }}" />

                                                        @error('complaint_name')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label for=""
                                                            class="form-label">{{ __('messages.Complaint-Title') }}</label><span
                                                            class="text-danger">*</span>
                                                        <input type="text"
                                                            class="form-control @error('complaint_title') is-invalid @enderror"
                                                            id="txtComplaintTitle"
                                                            oninput="removeError('#txtComplaintTitle')"
                                                            placeholder="{{ __('messages.Complaint-Title') }}"
                                                            maxlength="35"
                                                            onkeypress="return (event.charCode>=65 && event.charCode<=90) || (event.charCode >=97 && event.charCode<=122) || (event.charCode==32) || (event.charCode==46) || (event.charCode>=48 && event.charCode<=57) || (event.charCode==45)"
                                                            autocomplete="off" name="complaint_title"
                                                            value="{{ old('complaint_title', $complaint_data->complaint_title ?? '') }}" />

                                                        @error('complaint_title')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror

                                                    </div>
                                                </div>

                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label for=""
                                                            class="form-label">{{ __('messages.contact_number_title') }}</label><span
                                                            class="text-danger">*</span>
                                                        <input type="text"
                                                            class="form-control @error('contact_number') is-invalid @enderror"
                                                            id="MobileNo" inputmode="numeric" maxlength="10"
                                                            oninput="removeError('#MobileNo')"
                                                            placeholder="{{ __('messages.contact_number_title') }}"
                                                            onkeypress="return event.charCode >=48 && event.charCode <=57"
                                                            autocomplete="off" name="contact_number"
                                                            value="{{ old('contact_number', $complaint_data->contact_number ?? '') }}" />

                                                        @error('contact_number')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror

                                                    </div>
                                                </div>

                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label for=""
                                                            class="form-label">{{ __('messages.email_title') }}</label><span
                                                            class="text-danger">*</span>
                                                        <input type="text"
                                                            class="form-control @error('email') is-invalid @enderror"
                                                            id="txtEmailId" placeholder="{{ __('messages.email_title') }}"
                                                            maxlength="50" oninput="removeError('#txtEmailId')"
                                                            autocomplete="off" name="email"
                                                            value="{{ old('email', $complaint_data->email ?? '') }}" />

                                                        @error('email')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label for=""
                                                            class="form-label">{{ __('messages.Complaint-Type') }}</label><span
                                                            class="text-danger">*</span>
                                                        <select name="complaint_type" id="ddlComplaintType"
                                                            class="form-select form-control @error('complaint_type') is-invalid @enderror"
                                                            oninput="removeError('#ddlComplaintType')">
                                                            <option value="">
                                                                {{ __('messages.Select-Complaint-Type') }}
                                                            </option>
                                                            @foreach ($complaint_type as $type)
                                                                <option value="{{ $type->id }}"
                                                                    {{ old('complaint_type', $complaint_data->complaint_type ?? '') == $type->id ? 'selected' : '' }}>
                                                                    {{ $type->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                        @error('complaint_type')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label for=""
                                                            class="form-label">{{ __('messages.Priority') }}</label><span
                                                            class="text-danger">*</span>
                                                        <select name="priority" id="ddlPriority"
                                                            class="form-select form-control @error('priority') is-invalid @enderror"
                                                            oninput="removeError('#ddlPriority')">
                                                            <option value="">{{ __('messages.Select-Priority') }}
                                                            </option>
                                                            <option value="1"
                                                                {{ old('priority', $complaint_data->priority ?? '') == '1' ? 'selected' : '' }}>
                                                                High</option>
                                                            <option value="2"
                                                                {{ old('priority', $complaint_data->priority ?? '') == '2' ? 'selected' : '' }}>
                                                                Medium</option>
                                                            <option value="3"
                                                                {{ old('priority', $complaint_data->priority ?? '') == '3' ? 'selected' : '' }}>
                                                                Low</option>

                                                        </select>

                                                        @error('priority')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror

                                                    </div>
                                                </div>
                                                {{-- {{ dd($complaint_data->attachment) }} --}}
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label for="fileUpload"
                                                            class="form-label">{{ __('messages.Upload-File-Attachment') }}</label><span
                                                            class="text-danger">*</span>
                                                        <input type="file" name="attachment" id="fileUpload"
                                                            class="form-control @error('attachment') is-invalid @enderror"
                                                            onchange="profilepictype(event)"
                                                            oninput="removeError('#fileUpload')">
                                                        @if (!empty($complaint_data->attachment))
                                                            <div class="mb-2">
                                                                <a href="{{ asset('storage/complaints/attachment/' . $complaint_data->attachment) }}"
                                                                    target="_blank">
                                                                    <i class="fa fa-eye"></i> View
                                                                </a>
                                                            </div>
                                                        @endif

                                                        @error('attachment')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label class="form-label">{{ __('messages.Division') }} <span
                                                                class="text-danger">*</span></label>
                                                        <select name="division" id="ddlDivision"
                                                            class="form-select form-control @error('division') @enderror">
                                                            <option value="">{{ __('messages.Select-Division') }}
                                                            </option>
                                                            @foreach ($divisions as $div)
                                                                <option value="{{ $div->id }}"
                                                                    {{ old('division', $complaint_data->division) == $div->id ? 'selected' : '' }}>
                                                                    {{ $div->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('division')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label class="form-label">{{ __('messages.district') }} <span
                                                                class="text-danger">*</span></label>
                                                        <select name="district" id="ddlDistrict"
                                                            class="form-select form-control @error('district') @enderror">
                                                            <option value="">{{ __('messages.Select-District') }}
                                                            </option>
                                                        </select>

                                                        @error('district')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror

                                                    </div>
                                                </div>

                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label class="form-label">{{ __('messages.Sub-Division') }} <span
                                                                class="text-danger">*</span></label>
                                                        <select name="sub_division" id="ddlSubDivision"
                                                            class="form-select form-control @error('sub_division') @enderror">
                                                            <option value="">
                                                                {{ __('messages.Select-Sub-Division') }}
                                                            </option>
                                                        </select>

                                                        @error('sub_division')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label class="form-label">{{ __('messages.Block') }} <span
                                                                class="text-danger">*</span></label>
                                                        <select name="block" id="ddlBlock"
                                                            class="form-select form-control @error('block') @enderror">
                                                            <option value="">{{ __('messages.Select-Block') }}
                                                            </option>
                                                        </select>

                                                        @error('block')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label for=""
                                                            class="form-label">{{ __('messages.Complaint-for') }}</label><span
                                                            class="text-danger">*</span>
                                                        <select name="society" id="ddlSociety"
                                                            class="form-select form-control @error('society') is-invalid @enderror"
                                                            oninput="removeError('#ddlSociety')">
                                                            <option value=""> {{ __('messages.Select-Society') }}
                                                            </option>
                                                        </select>
                                                        @error('society')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>


                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="txtDescription"
                                                            class="form-label">{{ __('messages.Description') }}</label><span
                                                            class="text-danger">*</span>
                                                        <textarea class="form-control @error('description') is-invalid @enderror" id="txtDescription" maxlength="200"
                                                            placeholder="{{ __('messages.Description') }}" oninput="removeError('#txtDescription')"
                                                            onkeypress="return (event.charCode>=65 && event.charCode<=90) || (event.charCode >=97 && event.charCode<=122) || (event.charCode==32) || (event.charCode==46) || (event.charCode>=48 && event.charCode<=57) || (event.charCode==45)"
                                                            autocomplete="off" name="description">{{ old('description', $complaint_data->description ?? '') }}</textarea>

                                                        @error('description')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-lg-12 d-flex justify-content-end pt-3">
                                                    <button class="btn btn-primary" id="registrationSumbit"
                                                        type="submit">{{ __('messages.submit') }}</button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <!-- end row -->
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            loadSocieties();
            // Initialize dependent dropdowns if returning with errors
            @if (old('division'))
                loadDistricts("{{ old('division') }}", "{{ old('district') }}", "{{ old('sub_division') }}",
                    "{{ old('block') }}", "{{ old('society') }}");
            @elseif (isset($complaint_data->division))
                loadDistricts("{{ $complaint_data->division }}", "{{ $complaint_data->district ?? '' }}",
                    "{{ $complaint_data->sub_division ?? '' }}", "{{ $complaint_data->block ?? '' }}",
                    "{{ $complaint_data->society ?? '' }}");
            @elseif (isset($complaint_data->society))
                loadSocieties(null, "{{ $complaint_data->society }}");
            @endif

            // Division change event
            $('#ddlDivision').on('change', function() {
                const divId = $(this).val();
                resetDependentDropdowns(['ddlDistrict', 'ddlSubDivision', 'ddlBlock', 'ddlSociety']);
                if (divId) {
                    loadDistricts(divId);
                }
            });

            // District change event
            $('#ddlDistrict').on('change', function() {
                const distId = $(this).val();
                resetDependentDropdowns(['ddlSubDivision', 'ddlBlock', 'ddlSociety']);
                if (distId) {
                    loadSubDivisions(distId);
                    loadBlocks(distId);
                }
            });

            // Block change event
            $('#ddlBlock').on('change', function() {
                const blockId = $(this).val();
                resetDependentDropdowns(['ddlSociety']);
                if (blockId) {
                    loadSocieties(blockId);
                }
            });

            // Function to load districts and all dependent dropdowns
            function loadDistricts(divisionId, selectedDistrict = null, selectedSubDivision = null, selectedBlock =
                null, selectedSociety = null) {
                $.post("{{ route('get-districts-by-division') }}", {
                    _token: "{{ csrf_token() }}",
                    division: divisionId
                }, function(resp) {
                    $('#ddlDistrict').html(resp.options);
                    if (selectedDistrict) {
                        $('#ddlDistrict').val(selectedDistrict).trigger('change');

                        // Load sub-divisions after a slight delay
                        setTimeout(function() {
                            loadSubDivisions(selectedDistrict, selectedSubDivision);
                        }, 100);

                        // Load blocks after a slight delay
                        setTimeout(function() {
                            loadBlocks(selectedDistrict, selectedBlock);
                            if (selectedBlock) {
                                setTimeout(function() {
                                    $('#ddlBlock').val(selectedBlock).trigger('change');
                                    setTimeout(function() {
                                        loadSocieties(selectedBlock,
                                            selectedSociety);
                                    }, 100);
                                }, 100);
                            }
                        }, 100);
                    }
                }).fail(function(xhr) {
                    console.error('Error loading districts:', xhr.responseText);
                });
            }

            // Function to load sub-divisions
            function loadSubDivisions(districtId, selectedSubDivision = null) {
                $.post("{{ route('get-subdivisions-by-district') }}", {
                    _token: "{{ csrf_token() }}",
                    district: districtId
                }, function(resp) {
                    $('#ddlSubDivision').html(resp.options);
                    if (selectedSubDivision) {
                        $('#ddlSubDivision').val(selectedSubDivision);
                    }
                }).fail(function(xhr) {
                    console.error('Error loading sub-divisions:', xhr.responseText);
                });
            }

            // Function to load blocks
            function loadBlocks(districtId, selectedBlock = null) {
                $.post("{{ route('get-blocks-by-district') }}", {
                    _token: "{{ csrf_token() }}",
                    district: districtId
                }, function(resp) {
                    $('#ddlBlock').html(resp.options);
                    if (selectedBlock) {
                        $('#ddlBlock').val(selectedBlock);
                    }
                }).fail(function(xhr) {
                    console.error('Error loading blocks:', xhr.responseText);
                });
            }

            // Function to load societies
            function loadSocieties(blockId = null, selectedSociety = null) {
                $.post("{{ route('get-societies-by-block') }}", {
                    _token: "{{ csrf_token() }}",
                    block: blockId
                }, function(resp) {
                    $('#ddlSociety').html(resp.options);
                    if (selectedSociety) {
                        $('#ddlSociety').val(selectedSociety);
                    }
                }).fail(function(xhr) {
                    console.error('Error loading societies:', xhr.responseText);
                });
            }

            // Function to reset dependent dropdowns
            function resetDependentDropdowns(selectIds) {
                selectIds.forEach(id => {
                    $('#' + id).html('<option value="">{{ __('messages.Select') }}</option>');
                });
            }
        });
    </script>

    {{-- <script>
        $(document).ready(function() {
            loadSocieties();

            // Initialize dependent dropdowns if returning with errors
            @if (old('division'))
                loadDistricts("{{ old('division') }}", "{{ old('district') }}", "{{ old('sub_division') }}",
                    "{{ old('block') }}", "{{ old('society') }}");
            @endif

            // Division change event
            $('#ddlDivision').on('change', function() {
                const divId = $(this).val();
                resetDependentDropdowns(['ddlDistrict', 'ddlSubDivision', 'ddlBlock', 'ddlSociety']);
                if (divId) {
                    loadDistricts(divId);
                }
            });

            // District change event
            $('#ddlDistrict').on('change', function() {
                const distId = $(this).val();
                resetDependentDropdowns(['ddlSubDivision', 'ddlBlock', 'ddlSociety']);
                if (distId) {
                    loadSubDivisions(distId);
                    loadBlocks(distId);
                }
            });

            // Block change event
            $('#ddlBlock').on('change', function() {
                const blockId = $(this).val();
                // const selectedSociety = $('#ddlSociety').val();
                $('#ddlSociety').html('<option value="">Select Society</option>');
                if (blockId) {
                    loadSocieties(blockId); // Load societies based on block selection
                } else {
                    loadSocieties(); // Load all societies when no block is selected
                }
            });


            $('#ddlSociety').on('change', function() {
                const selectedSociety = $(this).val();
                // alert('Selected Society: ' + selectedSociety);
                loadSocieties(null, selectedSociety);
            });

            // Function to load districts and all dependent dropdowns
            function loadDistricts(divisionId, selectedDistrict = null, selectedSubDivision = null, selectedBlock =
                null, selectedSociety = null) {
                $.post("{{ route('get-districts-by-division') }}", {
                    _token: "{{ csrf_token() }}",
                    division: divisionId
                }, function(resp) {
                    $('#ddlDistrict').html(resp.options);
                    if (selectedDistrict) {
                        $('#ddlDistrict').val(selectedDistrict).trigger('change');
                        setTimeout(function() {
                            loadSubDivisions(selectedDistrict, selectedSubDivision);
                        }, 100);

                        setTimeout(function() {
                            loadBlocks(selectedDistrict, selectedBlock);
                            if (selectedBlock) {
                                setTimeout(function() {
                                    $('#ddlBlock').val(selectedBlock).trigger('change');
                                    setTimeout(function() {
                                        loadSocieties(selectedBlock,
                                            selectedSociety);
                                    }, 100);
                                }, 100);
                            }
                        }, 100);
                    }
                });
            }

            // Function to load sub-divisions
            function loadSubDivisions(districtId, selectedSubDivision = null) {
                $.post("{{ route('get-subdivisions-by-district') }}", {
                    _token: "{{ csrf_token() }}",
                    district: districtId
                }, function(resp) {
                    $('#ddlSubDivision').html(resp.options);
                    if (selectedSubDivision) {
                        $('#ddlSubDivision').val(selectedSubDivision);
                    }
                });
            }

            // Function to load blocks
            function loadBlocks(districtId, selectedBlock = null) {
                $.post("{{ route('get-blocks-by-district') }}", {
                    _token: "{{ csrf_token() }}",
                    district: districtId
                }, function(resp) {
                    $('#ddlBlock').html(resp.options);
                    if (selectedBlock) {
                        $('#ddlBlock').val(selectedBlock);
                    }
                });
            }

            // Function to load societies
            function loadSocieties(blockId = null, selectedSociety = null) {
                $.post("{{ route('get-societies-by-block') }}", {
                    _token: "{{ csrf_token() }}",
                    block: blockId
                }, function(resp) {
                    $('#ddlSociety').html(resp.options);
                    if (selectedSociety) {
                        $('#ddlSociety').val(selectedSociety);
                    }
                    // console.log("Selected Society:", selectedSociety);
                });
            }

            // Function to reset dependent dropdowns
            function resetDependentDropdowns(selectIds) {
                selectIds.forEach(id => {
                    $('#' + id).html('<option value="">Select</option>');
                });
            }
        });
    </script> --}}
@endsection
