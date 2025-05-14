@extends('adminlte::page')
@section('title', 'User List')

@section('content')

<div class="row">
    <div class="col-lg-12 mt-3">
        <!-- Create Button -->
        <div class="d-flex justify-content-between mb-3">
            <h4>User Management</h4>
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createUserModal">
                + Add New User
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role(s)</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $key => $user)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @foreach ($user->roles as $role)
                            <span class="badge badge-info">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        {{-- Status Toggle --}}
                        <td>
                            @if ($user->hasRole('Super Admin'))
                            <!-- Super Admin, Status Toggle Disabled -->
                            <button class="btn btn-sm btn-secondary" disabled>Active</button>
                            @else
                            @if ($user->status)
                            <form action="{{ route('users.toggleStatus', $user->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-success" title="Click to Deactivate">
                                    Active
                                </button>
                            </form>
                            @else
                            <form action="{{ route('users.toggleStatus', $user->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-danger" title="Click to Activate">
                                    Inactive
                                </button>
                            </form>
                            @endif
                            @endif
                        </td>

                        {{-- Action Buttons --}}
                        <td>
                            @if ($user->hasRole('Super Admin'))
                            <!-- Super Admin, Action Buttons Disabled -->
                            <button class="btn btn-sm btn-secondary" disabled>Edit</button>
                            <button class="btn btn-sm btn-secondary" disabled>Delete</button>
                            @else
                            <button class="btn btn-sm btn-warning" data-toggle="modal"
                                data-target="#editUserModal{{ $user->id }}">
                                Edit
                            </button>

                            <!-- Delete Button -->
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger delete-btn"
                                    data-name="{{ $user->name }}">
                                    Delete
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>

                    {{-- Include Edit Modal --}}
                    @include('modules.users.modals.edit', ['user' => $user])
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No users found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Include Create Modal -->
        @include('modules.users.modals.create')
    </div>
</div>
@endsection

@section('js')
@if ($errors->any())
<script>
    $(document).ready(function() {
                $('#createUserModal').modal('show');
            });
</script>
@endif
@endsection