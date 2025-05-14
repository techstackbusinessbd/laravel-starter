@extends('adminlte::page')
@section('title', 'User List')

@section('content')

<div class="row">
    <div class="col-lg-12 mt-3">
        <div class="d-flex justify-content-between mb-3">
            <h4>Role Management</h4>
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createRoleModal">
                + Add New Role
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>SL</th>
                        <th>Role</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Permissions</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($roles as $key => $role)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>
                            <span class="badge badge-info">{{ ucfirst($role->name) }}</span>
                            @if($role->name === 'super-admin')
                            <span class="badge badge-danger">Protected</span>
                            @endif
                        </td>
                        <td>{{ $role->description ?? '—' }}</td>
                        <td>
                            @if ($role->name !== 'super-admin')
                            <form action="{{ route('roles.toggleStatus', $role->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit"
                                    class="btn btn-sm {{ $role->status ? 'btn-success' : 'btn-danger' }}">
                                    {{ $role->status ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                            @else
                            <span class="text-muted">Always Active</span>
                            @endif
                        </td>
                        <td>
                            @if($role->permissions->isNotEmpty())
                            @foreach($role->permissions as $permission)
                            <span class="badge badge-info mb-1">{{ $permission->name }}</span>
                            @endforeach
                            @else
                            <span class="text-muted">No Permissions</span>
                            @endif
                        </td>
                        <td>
                            {{-- Edit Button --}}
                            @if($role->name !== 'super-admin')
                            <button class="btn btn-sm btn-warning" data-toggle="modal"
                                data-target="#editRoleModal{{ $role->id }}">Edit</button>

                            {{-- Delete Form --}}
                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST"
                                class="d-inline delete-form">
                                @csrf @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger delete-btn"
                                    data-name="{{ $role->name }}">Delete</button>
                            </form>
                            @else
                            <span class="text-muted">No Action</span>
                            @endif
                        </td>
                    </tr>

                    {{-- Include Edit Modal --}}
                    @include('modules.roles.modals.edit', ['role' => $role])
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No roles found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Include Create Modal --}}
        @include('modules.roles.modals.create')
    </div>
</div>
@endsection

@section('js')
@if ($errors->any())
<script>
    $(document).ready(function() {
                $('#createRoleModal').modal('show');
            });
</script>
@endif
@endsection