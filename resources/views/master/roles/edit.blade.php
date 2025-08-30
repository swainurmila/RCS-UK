@extends('layouts.app')
@section('title')
    {{ $title }}
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">{{ __('messages.Edit Role & Permission') }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="javascript: void(0);">{{ __('messages.CooperativesDepartment') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.Edit Role & Permission') }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-end mb-2">
                <a class="btn btn-primary mb-2" href="{{ route('roles') }}"><i class="fa fa-arrow-left"></i>
                    {{ __('messages.back') }}</a>
            </div>
            <form method="POST" action="{{ route('update-permissions', $role->id) }}">
                @csrf

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <h5 class="card-title">{{ __('messages.Role-Name') }}: {{ $role->name }}</h5>
                            {{-- <input type="text" name="name" placeholder="Name" class="form-control"
                                value="{{ $role->name }}"> --}}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{ __('messages.Permission') }}:</strong>
                            <br />

                            <table class="table table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="20%"> {{ __('messages.Module') }} </th>
                                        <th width="20%" class="text-center">{{ __('messages.Add') }}</th>
                                        <th width="20%" class="text-center">{{ __('messages.View') }}</th>
                                        <th width="20%" class="text-center">{{ __('messages.Update') }}</th>
                                        <th width="20%" class="text-center">{{ __('messages.Delete') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permission as $key => $item)
                                        <tr>
                                            @foreach ($item as $k => $value)
                                                <td width="20%" class="{{ $k % 5 == 0 ? '' : 'text-center' }}">

                                                    <div>
                                                        @if ($k % 5 == 0)
                                                            <label>
                                                                {{ $value->name }}
                                                            </label>
                                                        @else
                                                            <input type="checkbox" id="permission-{{ $value->id }}"
                                                                name="permission[{{ $value->id }}]" switch="bool"
                                                                {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}
                                                                value="{{ $value->id }}">
                                                            <label for="permission-{{ $value->id }}" data-on-label="All"
                                                                data-off-label="None"></label>
                                                        @endif

                                                    </div>


                                                </td>
                                            @endforeach
                                        <tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>


        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('input[type="checkbox"]').on('change', function() {
            let isChecked = $(this).is(':checked') ? 1 : 0;
            let permissionId = $(this).val();

            $.ajax({
                url: "{{ route('update-permissions') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    roleId: "{{ $role->id }}",
                    permissionId: permissionId,
                    isChecked: isChecked
                },

                success: function(res) {
                    console.log('Success:', res);
                },
                error: function(err) {
                    console.error('Error:', err);
                }
            });
        });
    });
</script>
