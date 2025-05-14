<!-- Create Permission Modal -->
<div class="modal fade" id="createPermissionModal" tabindex="-1" role="dialog" aria-labelledby="createPermissionLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('permissions.store') }}" method="POST">
                @csrf

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="createPermissionLabel">Create New Permission</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    {{-- Permission Name --}}
                    <div class="form-group">
                        <label for="permissionName">Permission Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="permissionName" class="form-control" required>
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Description --}}
                    <div class="form-group">
                        <label for="permissionDesc">Description (optional)</label>
                        <textarea name="description" id="permissionDesc" class="form-control" rows="2"></textarea>
                        @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm">Create Permission</button>
                </div>
            </form>
        </div>
    </div>
</div>