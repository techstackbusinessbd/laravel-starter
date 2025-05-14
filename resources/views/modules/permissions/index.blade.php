@extends('adminlte::page')
@section('title', 'User List')

@section('content')

<div class="row">
    <div class="col-lg-12 mt-3">
        <div class="d-flex justify-content-between mb-3">
            <h4>Permission Management</h4>
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createPermissionModal">
                + Add New Permission
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>SL</th>
                        <th>Permission</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permissions as $key => $permission)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ ucfirst($permission->name) }}</td>
                        <td>{{ $permission->description ?? '—' }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning" data-toggle="modal"
                                data-target="#editPermissionModal{{ $permission->id }}">Edit</button>

                            <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST"
                                class="d-inline">
                                @csrf @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger delete-btn"
                                    data-name="{{ $permission->name }}">Delete</button>
                            </form>
                        </td>
                    </tr>

                    {{-- Include Edit Modal --}}
                    @include('modules.permissions.modals.edit', ['permission' => $permission])
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Include Create Modal --}}
    @include('modules.permissions.modals.create')

</div>
</div>
@endsection

@section('js')
@if ($errors->any())
<script>
    $(document).ready(function() {
                $('#createPermissionModal').modal('show');
            });
</script>
@endif
@endsection