<!-- Edit Permission Modal -->
<div class="modal fade" id="editPermissionModal{{ $permission->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editPermissionLabel{{ $permission->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="editPermissionLabel{{ $permission->id }}">Edit Permission: {{
                        ucfirst($permission->name) }}</h5>
                    <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    {{-- Permission Name --}}
                    <div class="form-group">
                        <label for="editPermissionName{{ $permission->id }}">Permission Name <span
                                class="text-danger">*</span></label>
                        <input type="text" name="name" id="editPermissionName{{ $permission->id }}" class="form-control"
                            value="{{ $permission->name }}" required>
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Description --}}
                    <div class="form-group">
                        <label for="editPermissionDesc{{ $permission->id }}">Description (optional)</label>
                        <textarea name="description" id="editPermissionDesc{{ $permission->id }}" class="form-control"
                            rows="2">{{ $permission->description }}</textarea>
                        @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning btn-sm">Update Permission</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>