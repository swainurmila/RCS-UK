@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">{{ __('messages.Section-34-Inspection-Details') }}</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">
                                        {{ __('messages.cooperatives_department') }}
                                    </a>
                                </li>
                                <li class="breadcrumb-item active">{{ __('messages.Section-34-Inspection-Details') }}</li>
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
                                            <table id="datatable-buttons"
                                                class="table table-striped table-hover display nowrap" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>{{ __('messages.SINo') }}</th>
                                                        <th>{{ __('messages.Financial-year') }}</th>
                                                        <th>{{ __('messages.Inspection-Month') }}</th>
                                                        <th>{{ __('messages.District') }}</th>
                                                        <th>{{ __('messages.Block') }}</th>
                                                        <th>{{ __('messages.SocietyName') }}</th>
                                                        <th>{{ __('messages.Society-Type') }}</th>
                                                        <th>{{ __('messages.Assign-Officer') }}</th>
                                                        <th>{{ __('messages.view_document') }}</th>
                                                        {{-- <th>{{ __('messages.status') }}</th> --}}
                                                        <th>{{ __('messages.Action') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

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

    <div class="modal fade" id="inspectionModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="historyModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ __('messages.Inspection-History') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="inspectionModalBody">
                            <div class="text-center py-4">Loading...</div>
                        </div>
                    </div>
                </div>
            </div>

    <div class="modal fade" id="viewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('messages.View-34-Inspection-Details') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td style="width: 25%"><strong>{{ __('messages.Financial-year') }} :</strong></td>
                                <td style="width: 25%" id="financialyear"></td>
                                <td style="width: 25%"><strong>{{ __('messages.Inspection-Month') }}:</strong></td>
                                <td style="width: 25%" id="inspectionmonth"></td>
                            </tr>

                            <tr>
                                <td style="width: 25%"><strong>{{ __('messages.district') }}:</strong></td>
                                <td style="width: 25%" id="district"></td>
                                <th style="width: 25%"><strong>{{ __('messages.Block') }}:</strong></th>
                                <th style="width: 25%" id="block"></th>
                            </tr>

                            <tr>
                                <td style="width: 25%"><strong>{{ __('messages.Select-Society') }}:</strong></td>
                                <td style="width: 25%" id="society"></td>
                                <td style="width: 25%"><strong>{{ __('messages.Society-Type') }}:</strong></td>
                                <td style="width: 25%" id="societytype"></td>
                            </tr>

                            {{--  <tr>
                                <td style="width: 25%"><strong>Submitted to Role:</strong></td>
                                <td style="width: 25%" id="submitted_to_role"></td>
                                <td style="width: 25%"><strong>Current Role:</strong></td>
                                <td style="width: 25%" id="current_role"></td>
                            </tr> --}}

                            <tr>
                                <td style="width: 25%"><strong>{{ __('messages.Assign-Officer') }}:</strong></td>
                                <td style="width: 25%" id="officer"></td>
                                <td style="width: 25%"><strong>{{ __('messages.Submitted-to-User') }}:</strong></td>
                                <td style="width: 25%" id="submitted_to_user_id"></td>
                            </tr>

                            <tr>
                                <td style="width: 25%"><strong>{{ __('messages.Remarks') }}:</strong></td>
                                <td style="width: 25%" id="remark"></td>
                                <td style="width: 25%"><strong>{{ __('messages.InspecIion-File') }}:</strong></td>
                                <td style="width: 25%" id="upload_inspection"></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script>
        $(function() {

            var table = $('#datatable-buttons').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                scrollX: true,
                responsive: false,
                "columnDefs": [{
                    "defaultContent": "",
                    "targets": "_all",
                }],

                ajax: {
                    url: "{{ route('get-inspection-list') }}",
                },

                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'financial_year',
                        name: 'financial_year',
                    },
                    {
                        data: 'inspection_month',
                        name: 'inspection_month',
                    },
                    {
                        data: 'district_name',
                        name: 'district_name',
                    },
                    {
                        data: 'block_name',
                        name: 'block_name',
                    },
                    {
                        data: 'society_name',
                        name: 'society_name'
                    },
                    {
                        data: 'society_type',
                        name: 'society_type',
                    },
                    {
                        data: 'officer_name',
                        name: 'officer_name',
                    },
                    {
                        data: 'upload_inspection',
                        name: 'upload_inspection',
                    },
                    /* {
                        data: 'status',
                        name: 'status',
                    }, */
                    {
                        data: 'action',
                        name: 'action',
                    }

                ]
            });

        });
    </script>

    <script>
         const url = "{{ asset('storage') }}/";
        $(document).on('click', '.ViewInspectionDetails', function() {

            $("#viewModal").modal('show');

            let financialyearVal = $(this).data('financial_year');
            let inspectionmonthVal = $(this).data('inspection_month');
            let societytypeVal = $(this).data('society_type');
            let uploadinspectionVal = $(this).data('upload_inspection');
            let districtVal = $(this).data('district');
            let descriptionVal = $(this).data('description');
            let blockVal = $(this).data('block');
            let societyval = $(this).data('society');
            let submittedtoroleval = $(this).data('submitted_to_role');
            let submittedtouseridval = $(this).data('submitted_to_user_id');
            let currentroleval = $(this).data('current_role');
            let remarkval = $(this).data('remark');
            let officerval = $(this).data('officer');


            $('#financialyear').text(financialyearVal);
            $('#inspectionmonth').html(inspectionmonthVal);
            $('#societytype').html(societytypeVal);
            $('#district').html(districtVal);
            $('#description').html(descriptionVal);
            $('#block').html(blockVal);
            $('#society').html(societyval);
            $('#submitted_to_role').html(submittedtoroleval);
            $('#submitted_to_user_id').html(submittedtouseridval);
            $('#current_role').html(currentroleval);
            $('#remark').html(remarkval);
            $('#officer').html(officerval);


            const $attachmentCell = $('#upload_inspection');
            $attachmentCell.empty();
           
            if (uploadinspectionVal) {
                $attachmentCell.html(`
                    <a href="javascript:void(0);" target="_blank" class="d-inline-block" onclick="viewAttachment('${url + uploadinspectionVal}')"><i class="fa fa-eye"></i> View
                    </a>
                `);
            }else{
                $attachmentCell.text('No file available');
            }

            /* if (uploadinspectionVal) {
                const fileExt = uploadinspectionVal.split('.').pop().toLowerCase();
                let path = '{{ asset('storage/') }}/' + uploadinspectionVal;

                if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExt)) {
                    // For images, show thumbnail with link to full image
                    $attachmentCell.html(`
                        <a href="${path}" target="_blank" class="d-inline-block">
                            <img src="${path}" class="img-thumbnail" style="max-height: 100px;" alt="Attachment">
                            <div class="small text-muted mt-1">Click to view full size</div>
                        </a>
                    `);
                } else {
                    // For other files, show download link
                    $attachmentCell.html(`
                        <a href="${path}" target="_blank" class="btn btn-sm btn-outline-primary" download>
                            <i class="bi bi-download"></i> Download File
                        </a>
                    `);
                }
            } else {
                $attachmentCell.html('<span class="text-muted">No Attachment</span>');
            } */

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

                const baseUrl = "{{ route('inspection-applications.history', ['inspection' => 'APP_ID']) }}";
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
@endsection
