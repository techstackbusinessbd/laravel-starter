@extends('adminlte::page')
@section('title', 'User List')

@section('content')

<div class="row">
    <div class="col-lg-12 mt-3">
        <h4>Assigned Permissions for Role: {{ ucfirst($role->name) }}</h4>

        @if(session('success'))
        <script>
            toastr.success("{{ session('success') }}");
        </script>
        @endif
        @if(session('error'))
        <script>
            toastr.error("{{ session('error') }}");
        </script>
        @endif

        <table class="table table-bordered table-sm">
            <thead class="table-dark">
                <tr>
                    <th>SL</th>
                    <th>Permission Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($role->permissions as $key => $permission)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ ucfirst($permission->name) }}</td>
                    <td>
                        <form action="{{ route('roles.permissions.remove', [$role->id, $permission->id]) }}"
                            method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-muted">No permissions assigned to this role.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <a href="{{ route('roles.permissions', $role->id) }}" class="btn btn-primary btn-sm">Manage Permissions</a>
    </div>
</div>
@endsection