@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">{{ __('messages.Edit-Section-34-Inspection') }}</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">
                                        {{ __('messages.cooperatives_department') }}
                                    </a>
                                </li>
                                <li class="breadcrumb-item active">{{ __('messages.Edit-Section-34-Inspection') }}</li>
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
                            <form method="POST"
                                action="{{ route('update-inspection', ['id' => Crypt::encryptString($inspection->id)]) }}"
                                enctype="multipart/form-data">
                                @csrf
                                <fieldset>
                                    <legend>{{ __('messages.Section-34-Inspection') }}</legend>

                                    <div class="row">

                                        <div class="col-md-3 form-group">
                                            <label>
                                                <span class="step-label"></span>
                                                {{ __('messages.Financial-year') }}
                                            </label>
                                            <select id="financial_year_id" name="financial_year_id"
                                                class="form-select form-control">
                                                <option value="">{{ __('messages.Select-Financial-year') }}</option>
                                                @foreach ($financial_year as $financialyear)
                                                    <option value="{{ $financialyear->id }}"
                                                        @if (isset($inspection->financial_year_id)) {{ $inspection->financial_year_id == $financialyear->id ? 'selected' : '' }}
                                                        @else
                                                            {{ $loop->first ? 'selected' : '' }} @endif>
                                                        {{ $financialyear->financial_year }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3 form-group">
                                            <label>
                                                <span class="step-label"></span>
                                                {{ __('messages.Inspection-Month') }}
                                            </label>
                                            <select id="inspection_month" name="inspection_month"
                                                class="form-select form-control">
                                                <option value="">{{ __('messages.Select-Inspection-Month') }}
                                                </option>
                                                @foreach (range(1, 12) as $month)
                                                    <option value="{{ $month }}"
                                                        @isset($inspection->inspection_month)
                                                            {{ $inspection->inspection_month == $month ? 'selected' : '' }}
                                                        @else
                                                            {{ now()->month == $month ? 'selected' : '' }}
                                                        @endisset>
                                                        {{ \Carbon\Carbon::create()->month($month)->translatedFormat('F') }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3 form-group">
                                            <label><span class="step-label"></span>
                                                {{ __('messages.district') }}</label>
                                            <select id="district_id" name="district_id" class="form-select form-control"
                                                onchange="getBlock(this)">
                                                <option value="">{{ __('messages.Select-District') }}
                                                </option>
                                                @foreach ($district as $districts)
                                                    <option
                                                        value="{{ $districts->id }}"{{ $inspection->district_id == $districts->id ? 'selected' : '' }}>
                                                        {{ $districts->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label><span class="step-label"></span> {{ __('messages.Block') }}</label>
                                            <select id="block_id" name="block_id" class="form-select form-control">
                                                <option value="0">{{ __('messages.Select-Block') }}</option>
                                                @foreach ($block as $blocks)
                                                    <option
                                                        value="{{ $blocks->id }}"{{ $inspection->block_id == $blocks->id ? 'selected' : '' }}>
                                                        {{ $blocks->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3 form-group">
                                            <label><span
                                                    class="step-label"></span>{{ __('messages.Type-of-society') }}</label>
                                            <select id="society_type" name="society_type" class="form-select form-control">
                                                <option value="">{{ __('messages.Select-Type-of-society') }}</option>
                                                @foreach ($society_type as $societytype)
                                                    <option
                                                        value="{{ $societytype->id }}"{{ $inspection->society_type == $societytype->id ? 'selected' : '' }}>
                                                        {{ $societytype->type }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3 form-group">
                                            <label><span
                                                    class="step-label"></span>{{ __('messages.Select-Society') }}</label>
                                            <select class="form-select form-control" id="society_id" name="society_id">
                                                <option value="">{{ __('messages.Select-Society') }}</option>
                                                @if (isset($inspection->society_id) && $inspection->society_id)
                                                    @foreach ($societies as $society)
                                                        @if ($society->id == $inspection->society_id)
                                                            <option value="{{ $society->id }}" selected>
                                                                {{ $society->society_name }}</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>

                                        {{-- <div class="col-md-3 form-group">
                                            <label>{{ __('messages.Inspection-Form') }}</label>
                                            <input type="file" class="form-control" id="File"
                                                name="inspection_attachment" />
                                        </div> --}}

                                        <div class="col-md-3 form-group">
                                            <label>{{ __('messages.Upload-Inspection-Form') }}</label>
                                            <input type="file" class="form-control" id="File1"
                                                name="upload_inspection" />
                                            @if (!empty($inspection->upload_inspection))
                                                <div class="mb-2">
                                                    <a href="{{ asset('storage/' . $inspection->upload_inspection) }}"
                                                        target="_blank">
                                                        <i class="fa fa-eye"></i> View
                                                    </a>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="col-md-12">
                                            <label for="txtRemarks">{{ __('messages.Remarks') }}</label>
                                            <textarea id="txtRemarks" name="remark" class="form-control" rows="10"></textarea>
                                        </div>

                                    </div><!-- end row -->

                                </fieldset>

                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        <button type="submit"
                                            class="btn btn-md btn-success px-3">{{ __('messages.submit') }}</button>
                                    </div>
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
        function getBlock(d) {
            var url = "{{ route('get-block') }}";
            var district_id = d.value;
            if (district_id != '') {
                $('#block_id').empty();
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "district_id": district_id
                    },
                    dataType: "JSON",
                    success: function(res) {
                        $('#block_id').html(res.options);
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            // Initialize society dropdown when page loads if society_type is already selected
            if ($('#society_type').val()) {
                updateSocietyDropdown();
            }

            $('#society_type').on('change', function() {
                updateSocietyDropdown();
            });

            function updateSocietyDropdown() {
                let society_type = $('#society_type').val();
                let selectedSociety = '{{ $inspection->society_id ?? '' }}';

                if (society_type) {
                    $.ajax({
                        url: '{{ route('get.society.name') }}',
                        type: 'GET',
                        data: {
                            society_type: society_type
                        },
                        success: function(response) {
                            let options =
                                '<option value="">{{ __('messages.Select-Society') }}</option>';
                            $.each(response, function(key, value) {
                                let selected = (value.id == selectedSociety) ? ' selected' : '';
                                options += '<option value="' + value.id + '"' + selected + '>' +
                                    value.society_name + '</option>';
                            });
                            $('#society_id').html(options);
                        },
                        error: function(xhr) {
                            console.error('Error fetching societies:', xhr.responseText);
                            $('#society_id').html(
                                '<option value="">{{ __('messages.Error-loading-societies') }}</option>'
                            );
                        }
                    });
                } else {
                    $('#society_id').html('<option value="">{{ __('messages.Select-Society') }}</option>');
                }
            }
        });
    </script>

    {{--  <script>
        $('#society_type').on('change', function() {
            let society_type = $('#society_type').val();

            if (society_type) {
                $.ajax({
                    url: '{{ route('get.society.name') }}',
                    type: 'GET',
                    data: {
                        society_type: society_type
                    },
                    success: function(response) {
                        let options = '<option value="">Select Society Name</option>';
                        $.each(response, function(key, value) {
                            options += '<option value="' + value.id + '">' + value
                                .society_name +
                                '</option>';
                        });
                        $('#society_id').html(options);
                    }
                });
            }
        });
    </script> --}}
@endsection
