<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AccountRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //$accounts = User::all();
        //Log::info('Fetched accounts:', $accounts->toArray());

        $role = ['admin', 'staff', 'user'];

        $search=$request->input('search');
        $accounts = User:: when ($search, function($query,$search){
            return $query->where('name', 'like',"%$search%")
                        ->orWhere('role','like',"%$search%")
                        ->orWhere('email','like',"%$search%");
        })->paginate(10);
        return view('admin.accountrole', compact('accounts', 'role','search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('admin.accountrole');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'client'; // Default role

        User::create($validated);

        return redirect()->route('admin.accountrole')->with('success', 'Account added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        return redirect()->route('admin.accountrole');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $account = User::findOrFail($id);
        $role = ['admin', 'employee', 'client'];

        // Check if the authenticated user is an admin
        if (auth()->check() && auth()->user()->role === 'admin') {
            return view('admin.accountrole', compact('account', 'role'));
        } else {
            return redirect()->route('admin.accountrole')->with('error', 'You do not have permission to edit this account');
        }
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, $id)
    {
        $account = User::findOrFail($id);

        $validated = $request->validate([
            'password' => 'nullable|string|min:8',
        ]);

        // Allow role update only for admins
        if (auth()->check() && auth()->user()->role === 'admin') {
            $roleValidated = $request->validate([
                'role' => 'required|in:admin,employee,client',]);

        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']); // Don't overwrite with null
        }

        // Update user fields (role, password)
        $account->update($validated);

        // Save the flag and status changes
        $account->save();

        return redirect()->route('admin.accountrole')->with('success', 'Account updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('admin.accountrole')->with('success', 'Account deleted successfully');
    }
}
