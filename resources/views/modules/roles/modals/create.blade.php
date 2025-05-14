<!-- Add Role Modal -->
<div class="modal fade" id="createRoleModal" tabindex="-1" role="dialog" aria-labelledby="createRoleLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="createRoleLabel">Create New Role</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Role Name</label>
                            <input type="text" name="name" class="form-control">
                        </div>

                        {{-- Description --}}
                        <div class="form-group">
                            <label for="roleDesc">Description (optional)</label>
                            <textarea name="description" id="roleDesc" class="form-control" rows="2"
                                placeholder="Short role description..."></textarea>
                            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label>Assign Permissions</label>
                            <div class="row">
                                @foreach($permissions as $permission)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                            class="form-check-input" id="perm{{ $permission->id }}">
                                        <label class="form-check-label" for="perm{{ $permission->id }}">
                                            {{ ucfirst($permission->name) }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btn-sm">Save Role</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>