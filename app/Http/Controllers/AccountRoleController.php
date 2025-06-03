<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountRoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'admin') {
                abort(403, 'Unauthorized');
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $role = ['admin', 'staff', 'user'];

        $search = $request->input('search');

        $accounts = User::when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('role', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        })
        ->orderBy('id', 'asc')
        ->whereIn('role', $role)
        ->paginate(5);

        return view('admin.accountrole', compact('accounts', 'role', 'search'));
    }

    public function create()
    {
        return redirect()->route('accountroles.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role']     = 'client';

        User::create($validated);

        return redirect()
            ->route('accountroles.index')
            ->with('success', 'Account added successfully');
    }

    public function show($id)
    {
        return redirect()->route('accountroles.index');
    }

    public function edit($id)
    {
        return redirect()->route('accountroles.index');
    }
    public function update(Request $request, $id)
    {
        $account = User::findOrFail($id);

        $validated = $request->validate([
            'password' => 'nullable|string|min:8',
        ]);

        if (auth()->check() && auth()->user()->role === 'admin') {
            $roleValidated = $request->validate([
                'role' => 'required|in:admin,staff,user',
            ]);
            $validated['role'] = $roleValidated['role'];
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $account->update($validated);

        return redirect()
            ->route('accountroles.index')
            ->with('success', 'Account updated successfully');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return redirect()
            ->route('accountroles.index')
            ->with('success', 'Account deleted successfully');
    }
}
