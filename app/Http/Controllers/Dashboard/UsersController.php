<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $query = trim((string) $request->input('q', ''));
        $role = trim((string) $request->input('role', ''));

        $users = User::with('roles')
            ->withCount(['projects', 'proposals', 'contracts'])
            ->when($query !== '', function ($builder) use ($query) {
                $builder->where(function ($search) use ($query) {
                    $search->where('name', 'like', '%' . $query . '%')
                        ->orWhere('email', 'like', '%' . $query . '%');
                });
            })
            ->when($role !== '', function ($builder) use ($role) {
                $builder->whereHas('roles', function ($roleQuery) use ($role) {
                    $roleQuery->where('name', $role);
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $stats = [
            'users' => User::count(),
            'clients' => User::whereHas('roles', function ($query) {
                $query->where('name', 'client');
            })->count(),
            'freelancers' => User::whereHas('roles', function ($query) {
                $query->where('name', 'freelancer');
            })->count(),
            'with_contracts' => User::has('contracts')->count(),
        ];

        return view('dashboard.users.index', [
            'users' => $users,
            'query' => $query,
            'role' => $role,
            'stats' => $stats,
        ]);
    }

    public function edit(User $user)
    {
        return view('dashboard.users.edit', [
            'user' => $user->load('roles', 'freelancer'),
            'roles' => Role::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['integer', 'exists:roles,id'],
        ]);

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        $user->roles()->sync($data['roles'] ?? []);

        return redirect()
            ->route('dashboard.users.index')
            ->with('success', 'User account updated successfully.');
    }

    public function bulk(Request $request)
    {
        $data = $request->validate([
            'user_ids' => ['required', 'array'],
            'user_ids.*' => ['integer', 'exists:users,id'],
            'action' => ['required', Rule::in(['delete'])],
        ]);

        if ($data['action'] === 'delete') {
            User::whereIn('id', $data['user_ids'])->delete();
        }

        return redirect()
            ->route('dashboard.users.index')
            ->with('success', 'Bulk user action completed successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()
            ->route('dashboard.users.index')
            ->with('success', 'User account deleted successfully.');
    }
}
