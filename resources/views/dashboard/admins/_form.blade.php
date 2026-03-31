@csrf

<div class="form-group">
    <label for="name">Name</label>
    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $admin->name) }}" required>
</div>

<div class="form-group">
    <label for="email">Email</label>
    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $admin->email) }}" required>
</div>

<div class="form-group">
    <label for="password">{{ $admin->exists ? 'New Password' : 'Password' }}</label>
    <input type="password" class="form-control" id="password" name="password" {{ $admin->exists ? '' : 'required' }}>
    @if ($admin->exists)
        <small class="form-text text-muted">Leave blank to keep the current password.</small>
    @endif
</div>

<div class="form-group">
    <label for="status">Status</label>
    <select class="form-control" id="status" name="status" required>
        <option value="active" @selected(old('status', $admin->status ?: 'active') === 'active')>Active</option>
        <option value="inactive" @selected(old('status', $admin->status) === 'inactive')>Inactive</option>
    </select>
</div>

<div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" value="1" id="super_admin" name="super_admin" @checked(old('super_admin', $admin->super_admin))>
    <label class="form-check-label" for="super_admin">Super admin privileges</label>
</div>

<button class="btn btn-primary">Save Admin</button>
