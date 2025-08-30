@extends('layouts.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Edit Inquiry</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" id="editInquiryForm"
                            action="{{ route('update-inquiry', Crypt::encryptString($inquiry->id)) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <label>District</label>
                                    <select id="district_id" name="district_id" class="form-select form-control">
                                        <option value="0">Select</option>
                                        @foreach($districts as $district)
                                        <option value="{{ $district->id }}"
                                            {{ $inquiry->district_id == $district->id ? 'selected' : '' }}>
                                            {{ $district->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3 form-group">
                                    <label>Block</label>
                                    <select id="block_id" name="block_id" class="form-select form-control">
                                        @foreach($blocks as $block)
                                        <option value="{{ $block->id }}"
                                            {{ $inquiry->block_id == $block->id ? 'selected' : '' }}>
                                            {{ $block->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3 form-group">
                                    <label>Type of Society</label>
                                    <select id="society_type" name="society_type" class="form-select form-control">
                                        @foreach($society_types as $type)
                                        <option value="{{ $type }}"
                                            {{ $current_society_type == $type ? 'selected' : '' }}>
                                            {{ $type }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3 form-group">
                                    <label>Society</label>
                                    <select id="society_id" name="society_id" class="form-select form-control">
                                        <option value="{{ $inquiry->society_id }}" selected>
                                            {{ $inquiry->society->society_name }}
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-3 form-group">
                                    <label>Inspector</label>
                                    <select id="inspector_id" name="inspector_id" class="form-select form-control">
                                        <optgroup label="Choose Authority">
                                            <option value="2" {{ $inquiry->inspector_id == 2 ? 'selected' : '' }}>JRCS
                                            </option>
                                            <option value="3" {{ $inquiry->inspector_id == 3 ? 'selected' : '' }}>DCO
                                            </option>
                                            <option value="4" {{ $inquiry->inspector_id == 4 ? 'selected' : '' }}>ARCS
                                            </option>
                                            <option value="5" {{ $inquiry->inspector_id == 5 ? 'selected' : '' }}>BCO
                                            </option>
                                        </optgroup>
                                        <optgroup label="Available Inspectors">
                                            @foreach($inspectors as $inspector)
                                            <option value="{{ $inspector->id }}"
                                                {{ $inquiry->inspector_id == $inspector->id ? 'selected' : '' }}>
                                                {{ $inspector->name }}
                                            </option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                </div>

                                <!-- <div class="col-md-3 form-group">
                                    <label>Current File</label>
                                    @if($inquiry->inquiry_file)
                                    <div>
                                        <a href="{{ asset('storage/'.$inquiry->inquiry_file) }}" target="_blank"
                                            class="btn btn-sm btn-outline-primary">
                                            View Current File
                                        </a>
                                    </div>
                                    @else
                                    <div class="text-muted">No file uploaded</div>
                                    @endif
                                </div> -->

                                <div class="col-md-3 form-group">
                                    <label>Upload New File (Optional)</label>
                                    <input type="file" class="form-control" name="inquiry_file">
                                </div>

                                <div class="col-md-12 form-group">
                                    <label>Remarks</label>
                                    <textarea name="remarks" class="form-control"
                                        rows="5">{{ $inquiry->remarks }}</textarea>
                                </div>

                                <div class="col-12 text-center mt-3">
                                    <button type="submit" class="btn btn-primary">Update Inquiry</button>
                                    <a href="{{ route('get-inquiries-list') }}"
                                        class="btn btn-secondary ml-2">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Add the same district/block/society type change handlers as in your create form
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
                }
            });
        }
    });

    $('#district_id, #block_id, #society_type').change(function() {
        const districtId = $('#district_id').val();
        const blockId = $('#block_id').val();
        const societyType = $('#society_type').val();

        $('#society_id').html('<option value="0">Select</option>');

        if (districtId > 0 && blockId > 0 && societyType !== "0") {
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
                    }
                }
            });
        }
    });

    // Form submission
    $('#editInquiryForm').on('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        $('.invalid-feedback').text('');
        $('.is-invalid').removeClass('is-invalid');

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    setTimeout(() => {
                        window.location.href = response.redirect_url;
                    }, 1500);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    Object.keys(errors).forEach(field => {
                        $(`[name="${field}"]`).addClass('is-invalid');
                        $(`#${field}_error`).text(errors[field][0]);
                    });
                } else {
                    toastr.error('An error occurred. Please try again.');
                }
            }
        });
    });
});
</script>
@endsection