@extends('appeal.layouts.app')


@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">{{ __('messages.AppealList') }}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('messages.appeal') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('messages.ApplicationsList') }}</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <div class="table-responsive" style="overflow-x: auto;">

                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.SINo') }}</th>
                                        <th>{{ __('messages.appeal_no') }}</th>
                                        <th>{{ __('messages.district_dropdown') }}</th>
                                        <th>{{ __('messages.appellant_name') }}</th>
                                        <th>Appeal By</th>
                                        <th>Request By</th>
                                        <th>Request For</th>

                                        <th>{{ __('messages.Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($awaitingDocuments as $key => $awaiting)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ @$awaiting->appeal->appeal_no }}</td>
                                            <td>{{ @$awaiting->appeal->district->name }}</td>
                                            <td>{{ @$awaiting->appeal->appellant_name ?? 'N/A' }}</td>
                                            <td>
                                                {{ @$awaiting->appeal->user->name }}
                                            </td>
                                            <td>
                                                {{ ucfirst(@$awaiting->askingUser->name) }}
                                            </td>
                                            <td>
                                                {{ @$awaiting->requested_for }}
                                            </td>

                                            <td>
                                                @if (@$awaiting->document_one || @$awaiting->document_two)
                                                    <a href="{{ asset(@$awaiting->document_one) }}"
                                                        class="btn btn-info btn-sm" target="_blank">Document One</a>
                                                    <a href="{{ asset(@$awaiting->document_two) }}"
                                                        class="btn btn-info btn-sm" target="_blank">Document Two</a>
                                                @else
                                                    <button class="btn btn-sm btn-primary btn-sm approve-appeal"
                                                        data-id="{{ $awaiting->id }}" data-bs-toggle="modal"
                                                        data-bs-target="#documentModal">Send</button>
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>





                <div class="modal fade" id="documentModal" tabindex="-1" aria-labelledby="requestDocumentsModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="requestDocumentsModalLabel">Upload Documents</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form id="documentSubmitForm" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="awaiting_id" id="awaiting_id">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="document1" class="form-label">Document 1 <span
                                                class="text-danger">*</span></label>
                                        <input type="file" class="form-control" id="document1" name="document1" required
                                            accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                        <small class="text-muted">Accepted formats: PDF, DOC, JPG, PNG (Max: 5MB)</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="document2" class="form-label">Document 2 <span
                                                class="text-danger">*</span></label>
                                        <input type="file" class="form-control" id="document2" name="document2" required
                                            accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                        <small class="text-muted">Accepted formats: PDF, DOC, JPG, PNG (Max: 5MB)</small>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Submit Documents</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            // Set the awaiting ID when button clicked
            $('.approve-appeal').on('click', function() {
                var awaitingId = $(this).data('id');
                $('#awaiting_id').val(awaitingId);
            });

            // Handle form submission
            $('#documentSubmitForm').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: "{{ route('awaiting-documents.submit') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#approveModal').find('button[type="submit"]').prop('disabled', true)
                            .html(
                                '<span class="spinner-border spinner-border-sm" role="status"></span> Submitting...'
                            );
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#approveModal').modal('hide');
                            location.reload(); // Refresh to show updated status
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                alert(value);
                            });
                        } else {
                            alert('An error occurred. Please try again.');
                        }
                    },
                    complete: function() {
                        $('#approveModal').find('button[type="submit"]').prop('disabled', false)
                            .text('Submit Documents');
                    }
                });
            });
        });
    </script>
@endsection
