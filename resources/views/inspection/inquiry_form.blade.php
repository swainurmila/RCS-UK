@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Section35 Inquiry</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item">
                                <a href="javascript: void(0);">
                                    Co-operatives&#xD;&#xA;Department
                                </a>
                            </li>
                            <li class="breadcrumb-item active">Society Details</li>
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
                        <form method="POST" id="section35Form" action="{{ route('section35.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <fieldset>
                                <legend>Section35 Inquiry</legend>

                                <div class="row">

                                    <div class="col-md-3 form-group">
                                        <label><span class="step-label"></span> District</label>
                                        <select id="district_id" name="district_id" class="form-select form-control">
                                            <option value="0">Select</option>
                                            @foreach($districts as $district)
                                            <option value="{{ $district->id }}">{{ $district->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback" id="district_id_error"></div>
                                    </div>

                                    <div class="col-md-3 form-group">
                                        <label><span class="step-label"></span> Block</label>
                                        <select id="block_id" name="block_id" class="form-select form-control">
                                            <option value="0">Select</option>
                                            <!-- Blocks will be loaded dynamically -->
                                        </select>
                                        <div class="invalid-feedback" id="block_id_error"></div>
                                    </div>

                                    <!-- Rest of your form fields -->
                                    <div class="col-md-3 form-group">
                                        <label><span class="step-label"></span> Type of Society</label>
                                        <select id="society_type" name="society_type" class="form-select form-control">
                                            <option value="0">Select</option>
                                            @foreach($society_types as $type)
                                            <option value="{{ $type }}">{{ $type }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback" id="society_type_error"></div>
                                    </div>

                                    <div class="col-md-3 form-group">
                                        <label><span class="step-label"></span>Select Society</label>
                                        <select id="society_id" name="society_id" class="form-select form-control">
                                            <option value="0">Select</option>
                                        </select>
                                        <div class="invalid-feedback" id="society_id_error"></div>
                                    </div>

                                    <div class="col-md-3 form-group">
                                        <label><span class="step-label"></span> Assign Inspector</label>
                                        <select id="inspector_id" name="inspector_id" class="form-select form-control">
                                            <optgroup label="Choose Authority">
                                                <option value="0">Select</option>
                                                <option value="2">JRCS</option>
                                                <option value="3">DCO</option>
                                                <option value="4">ARCS</option>
                                                <option value="5">BCO</option>
                                            </optgroup>
                                            <optgroup label="Available Inspectors">
                                                @foreach($inspectors as $inspector)
                                                <option value="{{ $inspector->id }}">{{ $inspector->name }}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                        <div class="invalid-feedback" id="inspector_id_error"></div>
                                    </div>

                                    <div class="col-md-3 form-group">
                                        <label>Upload Inquiry Order</label>
                                        <input type="file" class="form-control" id="File1" name="inquiry_file" />
                                        <div class="invalid-feedback" id="File1_error"></div>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="txtRemarks">Remarks</label>
                                        <textarea id="txtRemarks" name="remarks" class="form-control"
                                            rows="10"></textarea>
                                        <div class="invalid-feedback" id="txtRemarks_error"></div>
                                    </div>

                                </div><!-- end row -->

                            </fieldset>

                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <button type="button" class="btn btn-md btn-success px-3"
                                        onclick="SaveSection35Inquiry()">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
$(document).ready(function() {
    // District change event handler
    $('#district_id').change(function() {
        const districtId = $(this).val();
        $('#block_id').html('<option value="0">Select</option>');
        $('#society_id').html('<option value="0">Select</option>');

        if (districtId > 0) {
            $.ajax({
                url: '/get_blocks_by_district/' + districtId,
                type: 'GET',
                success: function(response) {
                    if (response.length > 0) {
                        $.each(response, function(key, block) {
                            $('#block_id').append(
                                `<option value="${block.id}">${block.name}</option>`
                            );
                        });
                    }
                },
                error: function(xhr) {
                    console.error('Error fetching blocks:', xhr.responseText);
                }
            });
        }
    });

    const societyTypes = ['Primary', 'Central', 'Apex'];
    const $societyTypeDropdown = $('#society_type');
    $societyTypeDropdown.html('<option value="0">Select</option>');
    societyTypes.forEach(type => {
        $societyTypeDropdown.append(`<option value="${type}">${type}</option>`);
    });

    // When any of the filters change (district, block, or society type)
    $('#district_id, #block_id, #society_type').change(function() {
        const districtId = $('#district_id').val();
        const blockId = $('#block_id').val();
        const societyType = $('#society_type').val();

        $('#society_id').html('<option value="0">Select</option>');

        if (districtId > 0 && blockId > 0 && societyType !== "0") {
            // Map society type to category ID (adjust these numbers based on your actual categories)
            const categoryMap = {
                'Primary': 1,
                'Central': 2,
                'Apex': 3
            };

            const categoryId = categoryMap[societyType];

            if (!categoryId) return;

            $.ajax({
                url: "{{ route('societies.by_criteria') }}",
                type: 'GET',
                data: {
                    district_id: districtId,
                    block_id: blockId,
                    society_category: categoryId
                },
                success: function(response) {
                    if (response.length > 0) {
                        $.each(response, function(index, society) {
                            $('#society_id').append(
                                `<option value="${society.id}">${society.society_name}</option>`
                            );
                        });
                    } else {
                        $('#society_id').append(
                            `<option value="0">No societies found</option>`
                        );
                    }
                },
                error: function(xhr) {
                    console.error('Error fetching societies:', xhr.responseText);
                    $('#society_id').append(
                        `<option value="0">Error loading societies</option>`
                    );
                }
            });
        }
    });

});

function SaveSection35Inquiry() {
    // Reset all error states
    $('.form-control').removeClass('is-invalid');
    $('.invalid-feedback').text('');
    $('#error-message').addClass('d-none');

    // Client-side validation
    let isValid = true;
    let firstErrorField = null;

    // Check required fields
    const requiredFields = [{
            id: 'district_id',
            name: 'District'
        },
        {
            id: 'block_id',
            name: 'Block'
        },
        {
            id: 'society_type',
            name: 'Society Type'
        },
        {
            id: 'society_id',
            name: 'Society'
        },
        {
            id: 'inspector_id',
            name: 'Inspector'
        },
        {
            id: 'txtRemarks',
            name: 'Remarks'
        },
        {
            id: 'File1',
            name: 'Inquiry Order File'
        }
    ];

    requiredFields.forEach(field => {
        const $field = $(`#${field.id}`);
        let value;

        if (field.id === 'File1') {
            value = $field[0].files.length > 0 ? $field[0].files[0].name : '';
        } else {
            value = $field.val().trim();
        }

        if (value === "0" || value === "") {
            isValid = false;
            $field.addClass('is-invalid');
            $(`#${field.id}_error`).text(`${field.name} is required`);

            if (!firstErrorField) {
                firstErrorField = $field;
            }
        }
    });

    if (!isValid) {
        $('html, body').animate({
            scrollTop: firstErrorField.offset().top - 100
        }, 500);

        $('#error-message').removeClass('d-none')
            .text('Please fix the highlighted fields before submitting.');
        return;
    }

    let formData = new FormData(document.getElementById('section35Form'));
    const submitBtn = $('button[onclick="SaveSection35Inquiry()"]');
    submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Submitting...');

    $.ajax({
        url: "{{ route('section35.store') }}",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                // Show success message temporarily before redirecting
                $('#success-message').removeClass('d-none').text(response.message);

                // Redirect to listing page after 2 seconds
                setTimeout(function() {
                    window.location.href = "{{ route('get-inquiries-list') }}";
                }, 2000);
            } else {
                if (response.errors) {
                    Object.keys(response.errors).forEach(field => {
                        $(`#${field}`).addClass('is-invalid');
                        $(`#${field}_error`).text(response.errors[field][0]);
                    });

                    $('#error-message').removeClass('d-none')
                        .text('Please fix the highlighted fields before submitting.');
                }
            }
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                Object.keys(errors).forEach(field => {
                    $(`#${field}`).addClass('is-invalid');
                    $(`#${field}_error`).text(errors[field][0]);
                });

                $('#error-message').removeClass('d-none')
                    .text('Please fix the highlighted fields before submitting.');
            } else {
                $('#error-message').removeClass('d-none')
                    .text('An error occurred. Please try again.');
            }
        },
        complete: function() {
            submitBtn.prop('disabled', false).text('Submit');
        }
    });
}
</script>

@endsection