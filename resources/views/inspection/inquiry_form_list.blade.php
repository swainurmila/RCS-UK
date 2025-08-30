@extends('layouts.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">{{ __('messages.Inquiries') }}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item">
                                <a href="javascript: void(0);">
                                    {{ __('messages.cooperatives_department') }}
                                </a>
                            </li>
                            <li class="breadcrumb-item active">{{ __('messages.Inquiries') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="inquiries-datatable" class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>{{ __('messages.SINo') }}</th>
                                    <th>{{ __('messages.District') }}</th>
                                    <th>{{ __('messages.Block') }}</th>
                                    <th>{{ __('messages.Society-Type') }}</th>
                                    <th>{{ __('messages.SocietyName') }}</th>
                                    <th>{{ __('messages.Inquiry-File') }}</th>
                                    <th>{{ __('messages.Remarks') }}</th>
                                    <th>{{ __('messages.Action') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- View Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">{{ __('messages.View-Inquiry-Details') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th style="width: 30%">District:</th>
                                <td id="district"></td>
                            </tr>
                            <tr>
                                <th>Block:</th>
                                <td id="block"></td>
                            </tr>
                            <tr>
                                <th>Society Type:</th>
                                <td id="society_type"></td>
                            </tr>
                            <tr>
                                <th>Society Name:</th>
                                <td id="society_name"></td>
                            </tr>
                            <tr>
                                <th>Inquiry File:</th>
                                <td id="inquiry_file"></td>
                            </tr>
                            <tr>
                                <th>Remarks:</th>
                                <td id="remarks"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    var table = $('#inquiries-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('get-inquiries-list') }}",
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'district_name',
                name: 'district_name'
            },
            {
                data: 'block_name',
                name: 'block_name'
            },
            {
                data: 'society_type',
                name: 'society_type'
            },
            {
                data: 'society_name',
                name: 'society_name'
            },
            {
                data: 'inquiry_file',
                name: 'inquiry_file',

            },
            {
                data: 'remarks',
                name: 'remarks'
            },
            {
                data: 'action',
                name: 'action',
            }
        ],
        responsive: true,
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>"
            }
        },
        drawCallback: function() {
            $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
        }
    });

    $(document).on('click', '.view-inquiry', function() {
        $('#district').text($(this).data('district'));
        $('#block').text($(this).data('block'));
        $('#society_type').text($(this).data('society_type'));
        $('#society_name').text($(this).data('society_name'));
        $('#remarks').text($(this).data('remarks'));

        const inquiryFile = $(this).data('inquiry_file');
        const $inquiryFileCell = $('#inquiry_file');
        $inquiryFileCell.empty();

        if (inquiryFile) {
            const fileExt = inquiryFile.split('.').pop().toLowerCase();
            let path = '{{ asset("storage") }}/' + inquiryFile;

            if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExt)) {
                $inquiryFileCell.html(`
                    <a href="${path}" target="_blank" class="d-inline-block">
                        <img src="${path}" class="img-thumbnail" style="max-height: 100px;" alt="Inquiry File">
                        <div class="small text-muted mt-1">Click to view full size</div>
                    </a>
                `);
            } else {
                $inquiryFileCell.html(`
                    <a href="${path}" target="_blank" class="btn btn-sm btn-outline-primary" download>
                        <i class="bi bi-download"></i> Download File
                    </a>
                `);
            }
        } else {
            $inquiryFileCell.html('<span class="text-muted">No File Attached</span>');
        }

        $('#viewModal').modal('show');
    });
});
</script>
@endsection