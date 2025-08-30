@extends('layouts.app')
@section('title')
    {{ $title }}
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">{{ __('messages.users') }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="javascript: void(0);">{{ __('messages.CooperativesDepartment') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.users') }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

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

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-end mb-2">
                {{-- @can('role-create') --}}
                <a class="btn btn-success btn-sm" href="{{ route('users-create') }}"><i class="fa fa-plus"></i>
                    {{ __('messages.create-users') }}</a>
                {{-- @endcan --}}
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th width="75px">{{ __('messages.SINo') }}</th>
                        <th>{{ __('messages.name') }}</th>
                        <th>{{ __('messages.email_title') }}</th>
                        <th>{{ __('messages.mobile_number') }}</th>
                        <th>{{ __('messages.Role') }}</th>
                        {{-- <th>{{ __('messages.Division') }}</th> --}}
                        <th>{{ __('messages.District') }}</th>
                        <th>{{ __('messages.Block') }}</th>
                        <th>{{ __('messages.status') }}</th>
                        <th width="160px">{{ __('messages.Action') }}</th>
                    </tr>
                    @foreach ($users as $key => $item)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->mob_no ?? 'NA' }}</td>
                            <td><label class="badge bg-info">{{ $item->role->name ?? 'NA' }}</label></td>
                            {{-- <td>{{ $item->division_name }}</td> --}}
                            <td>{{ $item->getDistrict->name ?? 'NA' }}</td>
                            <td>{{ $item->getBlock->name ?? 'NA' }}</td>
                            <td>
                                @if ($item->is_active == 1)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">In Active</span>
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="{{ route('users-edit', $item->id) }}"><i
                                        class="fas fa-edit"></i> Edit</a>
                                <form method="POST" action="{{ route('users-delete', $item->id) }}" id="deleteForm"
                                    style="display:inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirmDelete(event)"><i class="fas fa-trash"></i>
                                        Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                </table>

                {!! $users->links('pagination::bootstrap-5') !!}
            </div>
        </div>
    </div>
@endsection
