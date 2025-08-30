@extends('layouts.app')
@section('title')
    {{ $title }}
@endsection
@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">{{ __('messages.Role Management') }}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a
                                    href="javascript: void(0);">{{ __('messages.CooperativesDepartment') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('messages.Role Management') }}</li>
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
                    <a class="btn btn-success btn-sm" href="{{ route('roles-create') }}"><i class="fa fa-plus"></i>
                        {{ __('messages.create-new-role') }}</a>
                    {{-- @endcan --}}
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th width="100px">{{ __('messages.SINo') }}</th>
                            <th>{{ __('messages.Role-Name') }}</th>
                            <th>{{ __('messages.Display-Name') }}</th>
                            <th>{{ __('messages.Description') }}</th>
                            <th width="280px">{{ __('messages.Action') }}</th>
                        </tr>
                        @foreach ($roles as $key => $role)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ ucfirst($role->name) }}</td>
                                <td>{{ $role->display_name ?? 'NA' }}</td>
                                <td>{{ $role->description ?: 'NA' }} </td>
                                <td>

                                    {{-- <a class="btn btn-info btn-sm" href="{{ route('roles.show', $role->id) }}"><i
                                            class="fas fa-list"></i>
                                        Show</a> --}}
                                    {{-- @can('role-edit') --}}
                                    <a class="btn btn-primary btn-sm" href="{{ route('roles-edit', $role->id) }}"><i
                                            class="fas fa-edit"></i>
                                        Edit</a>

                                    {{-- @endcan --}}

                                    {{-- @can('role-delete') --}}
                                    <form method="POST" action="{{ route('roles-delete', $role->id) }}"
                                        style="display:inline" id="deleteForm">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirmDelete(event)"><i class="fas fa-trash"></i>
                                            Delete</button>
                                    </form>
                                    {{-- {{ route('roles.destroy', $role->id) }} --}}
                                    {{-- @endcan --}}
                                </td>
                            </tr>
                        @endforeach

                    </table>

                    {!! $roles->links('pagination::bootstrap-5') !!}
                </div>
            </div>
        </div>
    </div>
@endsection
