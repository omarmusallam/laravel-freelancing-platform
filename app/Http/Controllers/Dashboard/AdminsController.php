<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminsController extends Controller
{
    public function index()
    {
        return view('dashboard.admins.index', [
            'admins' => Admin::latest()->paginate(12),
        ]);
    }

    public function create()
    {
        return view('dashboard.admins.create', [
            'admin' => new Admin(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:admins,email'],
            'password' => ['required', 'string', 'min:8'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
            'super_admin' => ['nullable', 'boolean'],
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['super_admin'] = (bool) ($data['super_admin'] ?? false);

        Admin::create($data);

        return redirect()
            ->route('dashboard.admins.index')
            ->with('success', 'Admin account created successfully.');
    }

    public function edit(Admin $admin)
    {
        return view('dashboard.admins.edit', [
            'admin' => $admin,
        ]);
    }

    public function update(Request $request, Admin $admin)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('admins', 'email')->ignore($admin->id)],
            'password' => ['nullable', 'string', 'min:8'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
            'super_admin' => ['nullable', 'boolean'],
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $data['super_admin'] = (bool) ($data['super_admin'] ?? false);

        if ($admin->id === auth('admin')->id() && !$data['super_admin']) {
            return redirect()
                ->route('dashboard.admins.index')
                ->with('error', 'You cannot remove super admin privileges from your current session.');
        }

        if ($admin->super_admin && !$data['super_admin'] && Admin::where('super_admin', true)->count() <= 1) {
            return redirect()
                ->route('dashboard.admins.index')
                ->with('error', 'At least one super admin account must remain active.');
        }

        $admin->update($data);

        return redirect()
            ->route('dashboard.admins.index')
            ->with('success', 'Admin account updated successfully.');
    }

    public function destroy(Admin $admin)
    {
        if ($admin->id === auth('admin')->id()) {
            return redirect()
                ->route('dashboard.admins.index')
                ->with('error', 'You cannot delete your current admin session.');
        }

        if ($admin->super_admin && Admin::where('super_admin', true)->count() <= 1) {
            return redirect()
                ->route('dashboard.admins.index')
                ->with('error', 'At least one super admin account must remain active.');
        }

        $admin->delete();

        return redirect()
            ->route('dashboard.admins.index')
            ->with('success', 'Admin account deleted successfully.');
    }
}
