<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Other methods...

    public function listUsers()
    {
        $users = User::paginate(15);
        $pageSlug = 'userlist';
        return view('userlist', compact('users'));
    }

    public function store(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'role' => 'required|string',
            ]);

            // Create the user
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role, // Store role directly from dropdown
            ]);

            // Redirect back with success message
            flash()->options(['timeout' => 3000, 'position' => 'bottom-center'])->success('User created successfully!');
            return redirect()->route('user.list');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return redirect()->route('user.create') // Redirect back to the form
                ->withErrors($e->validator) // Pass validation errors
                ->withInput(); // Retain input data
        } catch (\Exception $e) {
            // Handle other exceptions
            flash()->options(['timeout' => 3000, 'position' => 'bottom-center'])->error('An error occurred: ' . $e->getMessage());
            return redirect()->route('user.create'); // Redirect back to the form
        }
    }



    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        flash()->options(['timeout' => 3000, 'position' => 'bottom-center'])->info('User has been deleted.');
        return redirect()->route('user.list');
    }
}
