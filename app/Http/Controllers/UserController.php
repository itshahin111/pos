<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Mail\OtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{

    function loginPage()
    {
        return view('pages.auth.login-page');
    }




    public function registration(Request $request)
    {
        try {
            $request->validate([
                'firstName' => 'required|string|max:255',
                'lastName' => 'required|string|max:255',
                'phone' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email',
                'password' => 'required|string|min:8',
            ]);
            User::create([
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'User Registered Successfully'
            ], 200);
        } catch (Exception $exception) {
            return response()->json([
                'status' => 'failed',
                'message' => $exception->getMessage()
            ]);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:8',
            ]);
            $user = User::where('email', $request->input('email'))->first();

            if (
                !$user || !Hash::check($request->input('password'), $user->password)
            ) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Invalid credentials'
                ]);
            }
            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json([
                'status' => 'success',
                'message' => 'User logged in successfully',
                'token' => $token
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'status' => 'failed',
                'message' => $exception->getMessage()
            ]);
        }
    }

    function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'User logged out successfully'
        ]);
        // return redirect('/loginPage');

    }

    function userProfile(Request $request)
    {
        // $user = auth()->user();
        // return response()->json([
        //     'status' => 'success',
        //     'user' => $user
        // ], 200);

        $email = $request->header('email');
        $user = User::where('email', '=', $email)->first();
        return response()->json([
            'status' => 'success',
            'message' => 'Request Successful',
            'data' => $user
        ], 200);

    }
    function updateProfile(Request $request)
    {
        try {
            $request->validate([
                'firstName' => 'required|string|max:255',
                'lastName' => 'required|string|max:255',
                'phone' => 'required|string|max:255',
            ]);
            User::where('id', '=', Auth::id())->update(
                [
                    'firstName' => $request->firstName,
                    'lastName' => $request->lastName,
                    'phone' => $request->phone
                ]
            );
            return response()->json([
                'status' => 'success',
                'message' => 'Profile updated successfully'
            ], 200);
        } catch (Exception $exception) {
            return response()->json([
                'status' => 'failed',
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    function sendOtp(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string|email|max:255',
            ]);
            $email = $request->input('email');
            $otp = rand(1000, 9999);
            $user = User::where('email', '=', $email)->count();
            if ($user == 1) {
                Mail::to($email)->send(new OtpMail($otp));
                User::where('email', '=', $email)->update(['otp' => $otp]);
                return response()->json([
                    'status' => 'success',
                    'message' => '4 Digit OTP sent successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'User not found'
                ], 404);
            }
        } catch (Exception $exception) {
            return response()->json([
                'status' => 'failed',
                'message' => $exception->getMessage()
            ], 500);
        }
    }
    function verifyOtp(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string|email|max:255',
                'otp' => 'required|string|min:4'
            ]);
            $email = $request->input('email');
            $otp = $request->input('otp');
            $user = User::where('email', '=', $email)->where('otp', '=', $otp)->first();
            if (!$user) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'User not found'
                ], 404);
            }

            User::where('email', '=', $email)->update(['otp' => '0']);
            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json([
                'status' => 'success',
                'message' => 'User logged in successfully',
                'token' => $token
            ]);

        } catch (Exception $exception) {
            return response()->json([
                'status' => 'failed',
                'message' => $exception->getMessage()
            ], 500);
        }
    }
    function resetPassword(Request $request)
    {
        try {
            $request->validate([
                'password' => 'required|string|min:8'
            ]);
            $id = Auth::id();
            $password = $request->input('password');
            User::where('id', '=', $id)->update(['password' => Hash::make($password)]);
            return response()->json([
                'status' => 'success',
                'message' => 'Password updated successfully'
            ], 200);

        } catch (Exception $exception) {
            return response()->json([
                'status' => 'failed',
                'message' => $exception->getMessage()
            ], 500);
        }
    }
}
