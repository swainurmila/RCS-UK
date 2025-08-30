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
                                    <legend>Add Objective Of Society</legend>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <input type="hidden" id="societyObjectiveId" name="id" value="0" />

                                                <div class="col-lg-6 form-group">
                                                    <label for="objectiveofsoceity" class="form-label">Objective
                                                        Of Society *</label>
                                                    <input type="text" id="objectiveofsoceity" name="type"
                                                        class="form-control" placeholder="Enter Objective Of Society"
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
                <h4 class="text-center text-primary fw-bold mb-3">List Of Objective Of Societies</h4>

                <table id="datatable" class="table table-bordered nowrap" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Objective Type Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($societyObjectives as $key => $objective)
                        <tr id="row-{{ $objective->id }}">
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $objective->objective }}</td>
                            <td>
                                <button class="btn btn-sm btn-primary edit-btn" data-id="{{ $objective->id }}"
                                    data-type="{{ $objective->objective }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $objective->id }}">
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

        $('#typeError').text('').hide();
        $('#objectiveofsoceity').removeClass('is-invalid');

        let typeValue = $('#objectiveofsoceity').val().trim();

        if (typeValue === '') {
            $('#objectiveofsoceity').addClass('is-invalid');
            $('#typeError').text('This field is required.').show();
            return;
        }

        let formData = {
            id: $('#societyObjectiveId').val(),
            type: $('#objectiveofsoceity').val(),
            _token: '{{ csrf_token() }}'
        };

        let url = formData.id > 0 ?
            '/society-objectives/' + formData.id :
            '{{ route("society-objectives.store") }}';

        let method = formData.id > 0 ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            type: method,
            data: formData,
            success: function(response) {
                if (formData.id > 0) {

                    $(`#row-${formData.id} td:nth-child(2)`).text(response.data.objective);
                    $(`#row-${formData.id} .edit-btn`).data('type', response.data
                        .objective);

                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: response.message ||
                            'Society objective updated successfully.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {

                    let newRow = `<tr id="row-${response.data.id}">
                        <td>${$('#datatable tbody tr').length + 1}</td>
                        <td>${response.data.objective}</td>
                        <td>
                            <button class="btn btn-sm btn-primary edit-btn"
                                data-id="${response.data.id}"
                                data-type="${response.data.objective}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger delete-btn"
                                data-id="${response.data.id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>`;
                    $('#datatable tbody').append(newRow);

                    Swal.fire({
                        icon: 'success',
                        title: 'Created!',
                        text: response.message ||
                            'Society objective created successfully.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }

                $('#addSocietyForm')[0].reset();
                $('#societyObjectiveId').val('0');
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    if (errors.type) {
                        $('#objectiveofsoceity').addClass('is-invalid');
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

    $(document).on('click', '.edit-btn', function() {
        let id = $(this).data('id');
        let type = $(this).data('type');

        $('#societyObjectiveId').val(id);
        $('#objectiveofsoceity').val(type);
        $('html, body').animate({
            scrollTop: 0
        }, 'slow');
    });

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
                    url: '/society-objectives/' + id,
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

    $('#cancelBtn').click(function() {
        $('#societyTypeId').val('0');
    });
});
</script>