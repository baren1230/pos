<div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1"
    aria-labelledby="editUserModalLabel{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel{{ $user->id }}">
                    Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name_{{ $user->id }}" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name_{{ $user->id }}" name="name"
                            value="{{ $user->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="email_{{ $user->id }}" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email_{{ $user->id }}" name="email"
                            value="{{ $user->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_{{ $user->id }}" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password_{{ $user->id }}" name="password">
                        <small class="form-text text-muted">Leave
                            blank if you do not want to change the
                            password.</small>
                    </div>
                    <div class="mb-3">
                        <label for="role_{{ $user->id }}" class="form-label">Role</label>
                        <select class="form-control" id="role_{{ $user->id }}" name="role" required>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}"
                                    {{ $user->role == $role->name ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Pilih
                            role pengguna</small>
                    </div>
                    <!-- Image input removed -->
                    <!-- Removed status field -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
