@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="container-fluid">
                    <form id="addInspectorForm">
                        @csrf
                        <input type="hidden" id="inspectorId" name="id" value="0" />

                        <fieldset>
                            <legend>Add Inspector</legend>
                            <div class="row">
                                <div class="col-lg-6 form-group">
                                    <label for="inspectorName" class="form-label">Name *</label>
                                    <input type="text" id="inspectorName" name="name" class="form-control"
                                        placeholder="Enter Name">
                                    <div class="invalid-feedback" id="nameError"></div>
                                </div>

                                <div class="col-lg-6 form-group">
                                    <label for="inspectorDesignation" class="form-label">Designation *</label>
                                    <input type="text" id="inspectorDesignation" name="designation" class="form-control"
                                        placeholder="Enter Designation">
                                    <div class="invalid-feedback" id="designationError"></div>
                                </div>
                            </div>
                        </fieldset>

                        <div class="text-end mt-3">
                            <button type="button" class="btn btn-primary" id="submitBtn">Submit</button>
                            <button type="reset" class="btn btn-secondary" id="cancelBtn">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- List Section --}}
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow-lg border-0 rounded">
            <div class="card-body">
                <h4 class="text-center text-primary fw-bold mb-3">List of Inspectors</h4>

                <table id="inspectorTable" class="table table-bordered nowrap">
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inspectors as $key => $inspector)
                        <tr id="row-{{ $inspector->id }}">
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $inspector->name }}</td>
                            <td>{{ $inspector->designation }}</td>
                            <td>
                                <button class="btn btn-sm btn-primary edit-btn" data-id="{{ $inspector->id }}"
                                    data-name="{{ $inspector->name }}" data-designation="{{ $inspector->designation }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $inspector->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

@endsection

{{-- Scripts --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    $('#submitBtn').click(function(e) {
        e.preventDefault();

        $('#nameError, #designationError').text('').hide();
        $('#inspectorName, #inspectorDesignation').removeClass('is-invalid');

        let formData = {
            id: $('#inspectorId').val(),
            name: $('#inspectorName').val().trim(),
            designation: $('#inspectorDesignation').val().trim(),
            _token: '{{ csrf_token() }}'
        };

        if (!formData.name || !formData.designation) {
            if (!formData.name) {
                $('#inspectorName').addClass('is-invalid');
                $('#nameError').text('This field is required.').show();
            }
            if (!formData.designation) {
                $('#inspectorDesignation').addClass('is-invalid');
                $('#designationError').text('This field is required.').show();
            }
            return;
        }

        let url = formData.id > 0 ? `/inspectors/${formData.id}` : '{{ route("inspectors.store") }}';
        let method = formData.id > 0 ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            type: method,
            data: formData,
            success: function(response) {
                if (formData.id > 0) {
                    let row = $(`#row-${formData.id}`);
                    row.find('td:nth-child(2)').text(response.data.name);
                    row.find('td:nth-child(3)').text(response.data.designation);
                    row.find('.edit-btn').data('name', response.data.name).data(
                        'designation', response.data.designation);

                    Swal.fire('Updated!', response.message, 'success');
                } else {
                    let newRow = `<tr id="row-${response.data.id}">
                        <td>${$('#inspectorTable tbody tr').length + 1}</td>
                        <td>${response.data.name}</td>
                        <td>${response.data.designation}</td>
                        <td>
                            <button class="btn btn-sm btn-primary edit-btn"
                                data-id="${response.data.id}"
                                data-name="${response.data.name}"
                                data-designation="${response.data.designation}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger delete-btn"
                                data-id="${response.data.id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>`;
                    $('#inspectorTable tbody').append(newRow);

                    Swal.fire('Created!', response.message, 'success');
                }

                $('#addInspectorForm')[0].reset();
                $('#inspectorId').val('0');
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    if (errors.name) {
                        $('#inspectorName').addClass('is-invalid');
                        $('#nameError').text(errors.name[0]).show();
                    }
                    if (errors.designation) {
                        $('#inspectorDesignation').addClass('is-invalid');
                        $('#designationError').text(errors.designation[0]).show();
                    }
                } else {
                    Swal.fire('Error', 'Something went wrong', 'error');
                }
            }
        });
    });

    $(document).on('click', '.edit-btn', function() {
        $('#inspectorId').val($(this).data('id'));
        $('#inspectorName').val($(this).data('name'));
        $('#inspectorDesignation').val($(this).data('designation'));
        $('html, body').animate({
            scrollTop: 0
        }, 'slow');
    });

    $(document).on('click', '.delete-btn', function() {
        let id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: 'This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then(result => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/inspectors/${id}`,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        $(`#row-${id}`).remove();
                        Swal.fire('Deleted!', response.message, 'success');
                    },
                    error: function() {
                        Swal.fire('Error!', 'Unable to delete.', 'error');
                    }
                });
            }
        });
    });

    $('#cancelBtn').click(function() {
        $('#inspectorId').val('0');
    });
});
</script>