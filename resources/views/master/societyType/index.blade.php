@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="container-fluid">
                    <form id="addSocietyForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <fieldset>
                                    <legend>Add Type Of Society</legend>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <input type="hidden" id="societyTypeId" name="id" value="0" />

                                                <div class="col-lg-6 form-group">
                                                    <label for="typeofsoceity" class="form-label">Type Of
                                                        Society *</label>
                                                    <input type="text" id="typeofsoceity" name="type"
                                                        class="form-control" placeholder="Enter Type Of Society"
                                                        required>
                                                    <div class="invalid-feedback" id="typeError"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="col-lg-12" style="text-align: right;margin-top:30px;">
                                    <button type="button" class="btn btn-primary" id="submitBtn">Submit</button>
                                    <button type="reset" class="btn btn-secondary" id="cancelBtn">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card shadow-lg border-0 rounded">
            <div class="card-body">
                <h4 class="text-center text-primary fw-bold mb-3">List Of Type Of Societies</h4>

                <table id="datatable" class="table table-bordered nowrap" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Society Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($societyTypes as $key => $type)
                        <tr id="row-{{ $type->id }}">
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $type->type }}</td>
                            <td>
                                <button class="btn btn-sm btn-primary edit-btn" data-id="{{ $type->id }}"
                                    data-type="{{ $type->type }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $type->id }}">
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


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    $('#submitBtn').click(function(e) {
        e.preventDefault();

        // Clear previous errors
        $('#typeError').text('').hide();
        $('#typeofsoceity').removeClass('is-invalid');

        let typeValue = $('#typeofsoceity').val().trim();

        if (typeValue === '') {
            $('#typeofsoceity').addClass('is-invalid');
            $('#typeError').text('This field is required.').show();
            return;
        }

        // Prepare form data
        let formData = {
            id: $('#societyTypeId').val(),
            type: $('#typeofsoceity').val(),
            _token: '{{ csrf_token() }}'
        };

        // Determine if we're creating or updating
        let url = formData.id > 0 ?
            '/society-types/' + formData.id :
            '{{ route("society-types.store") }}';

        let method = formData.id > 0 ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            type: method,
            data: formData,
            success: function(response) {
                if (formData.id > 0) {
                    // Update existing row
                    $(`#row-${formData.id} td:nth-child(2)`).text(response.data.type);
                    $(`#row-${formData.id} .edit-btn`).data('type', response.data.type);

                    // SweetAlert for update
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: response.message ||
                            'Society type updated successfully.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    // Add new row
                    let newRow = `<tr id="row-${response.data.id}">
                    <td>${$('#datatable tbody tr').length + 1}</td>
                    <td>${response.data.type}</td>
                    <td>
                        <button class="btn btn-sm btn-primary edit-btn" data-id="${response.data.id}" data-type="${response.data.type}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger delete-btn" data-id="${response.data.id}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>`;
                    $('#datatable tbody').append(newRow);

                    // SweetAlert for create
                    Swal.fire({
                        icon: 'success',
                        title: 'Created!',
                        text: response.message ||
                            'Society type created successfully.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }

                // Reset the form
                $('#addSocietyForm')[0].reset();
                $('#societyTypeId').val('0');
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    if (errors.type) {
                        $('#typeofsoceity').addClass('is-invalid');
                        $('#typeError').text(errors.type[0]).show();
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong.'
                    });
                }
            }
        });
    });


    // Edit button click handler
    $(document).on('click', '.edit-btn', function() {
        let id = $(this).data('id');
        let type = $(this).data('type');

        $('#societyTypeId').val(id);
        $('#typeofsoceity').val(type);
        $('html, body').animate({
            scrollTop: 0
        }, 'slow');
    });

    // Delete button click handler
    $(document).on('click', '.delete-btn', function() {
        let id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/society-types/' + id,
                    type: 'POST', // still POST
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE' // spoof DELETE
                    },
                    success: function(response) {
                        Swal.fire(
                            'Deleted!',
                            response.message,
                            'success'
                        );
                        $(`#row-${id}`).remove();
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'Something went wrong.',
                            'error'
                        );
                    }
                });
            }
        });
    });


    // Cancel button click handler
    $('#cancelBtn').click(function() {
        $('#societyTypeId').val('0');
    });
});
</script>