<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editUserModalLabel{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="editUserModalLabel{{ $user->id }}">Edit User: {{ $user->name }}</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <!-- Name -->
                    <div class="form-group">
                        <label for="name">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email">Email Address <span class="text-danger">*</span></label>
                        <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
                    </div>

                    <!-- Password (optional) -->
                    <div class="form-group">
                        <label for="password">Password <small class="text-muted">(Leave blank to keep current
                                password)</small></label>
                        <input type="password" name="password" class="form-control"
                            placeholder="Enter new password if needed">
                    </div>

                    <!-- Role -->
                    <div class="form-group">
                        <label for="role">Select Role <span class="text-danger">*</span></label>
                        <select name="role" class="form-control" required>
                            <option value="">-- Select Role --</option>
                            @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ $user->roles->contains($role->id) ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status -->
                    <div class="form-group">
                        <label>Status</label><br>
                        <input type="radio" name="status" value="1" {{ $user->status ? 'checked' : '' }}> Active
                        <input type="radio" name="status" value="0" {{ !$user->status ? 'checked' : '' }}>
                        Inactive
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Update User</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
