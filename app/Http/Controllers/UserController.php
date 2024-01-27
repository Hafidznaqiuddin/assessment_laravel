<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('table_page', compact('users'));
    }

    public function create()
    {
        return view('form_page');
    }

    public function store(Request $request)
    {
        // Validation - you might want to customize this based on your requirements
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'gender' => 'required|in:male,female',
            'birthday' => 'required|date',
            'status_active' => 'required|boolean',
        ]);

        // Create a new user instance
        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'gender' => $request->input('gender'),
            'birthday' => $request->input('birthday', '2000-01-01'),
            'status_active' => $request->has('status_active') ? 1 : 0,
        ]);

        // Save the user to the database
        $user->save();
        Session::flash('success', 'Data Saved Successfully');
        // Redirect to the form page after successful form submission
        return redirect()->route('user.create');
    }


    public function checkEmail(Request $request)
    {
        $email = $request->query('email');

        // Perform the check (replace this with your actual logic)
        $isAvailable = !User::where('email', $email)->exists();

        return response()->json(['isAvailable' => $isAvailable]);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('user.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        // Validation - you might want to customize this based on your requirements
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'gender' => 'required|in:male,female',
            'birthday' => 'required|date',
            'status_active' => 'boolean',
        ]);

        // Find the user by ID
        $user = User::findOrFail($id);

        // Update user attributes
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'gender' => $request->input('gender'),
            'birthday' => $request->input('birthday'),
            'status_active' => $request->has('status_active') ? 1 : 0,
        ]);

        // Redirect to the table page after successful update
        return redirect()->route('user.index');
    }

    public function destroy($id)
    {
        try {
            // Find the user by ID and delete
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
