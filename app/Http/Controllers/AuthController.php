<?php

namespace App\Http\Controllers;

use App\Traits\HttpResponses;
use App\Models\User; // Import the User model
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Import the Hash facade
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Laravel\Sanctum\PersonalAccessToken;



class AuthController extends Controller
{
    use HttpResponses;

    public function login(Request $request)
    {
        $validatedData = $request->validate([

            'email' => 'required|email|max:100|email',
            'password' => 'required|string|min:8',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($validatedData['password'], $user->password)) {
            return response(['message' => 'Invalid Email or Password'], 401);
        }
        else
        {
            $token = $user->createToken('Login Token of ' . $user->name)->plainTextToken;
            $response = [
                'user' => $user,
                'token' => $token,
            ];
        }
        return response($response, 201);
    }
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:8',
            'shop_id' => 'required',
            'role' => 'required',
        ]);

        $role = $validatedData['role'] == 'admin' ? 1 : 2;

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'shop_id' => $validatedData['shop_id'],
            'role' => $role,
        ]);

        Session::put('role', $role);

        Auth::login($user);

        // Redirect or perform any additional actions after successful registration
    }





    // public function logout()
    // {
    //     auth()->user()->tokens()->delete();
    //     return Response(['message'=> 'Logged Out Successfully.'],401);;
    // }
    public function logout()
    {
    $user = auth()->user();
    PersonalAccessToken::where('tokenable_id', $user->id)->delete();

    return response(['message' => 'Logged Out Successfully.'], 200);
    }
    // public function showLoginForm()
    // {
    //     // Your existing code...

    //     $user = User::with('shopkeeper')->find(auth()->shop_id());
    //     dd($user);
    //     return view('dashboard', compact('user'));
    // }

}
