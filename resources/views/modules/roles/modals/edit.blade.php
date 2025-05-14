<!-- Edit Modal -->
<div class="modal fade" id="editRoleModal{{ $role->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('roles.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title">Edit Role: {{ ucfirst($role->name) }}</h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Role Name</label>
                        <input type="text" name="name" value="{{ $role->name }}" class="form-control" required>
                    </div>

                    <div class="form-group mt-2">
                        <label>Description</label>
                        <input type="text" name="description" value="{{ $role->description }}" class="form-control">
                    </div>

                    <div class="form-group mt-3">
                        <label>Permissions</label>
                        <div class="row">
                            @foreach($permissions as $permission)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                        value="{{ $permission->name }}" id="perm{{ $role->id }}_{{ $permission->id }}"
                                        {{ $role->permissions->contains($permission) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm{{ $role->id }}_{{ $permission->id }}">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning btn-sm">Update Role</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>