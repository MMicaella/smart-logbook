<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Services\OtpService;

class RegisteredUserController extends Controller
{
    protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    public function create(): View
    {
        return view('auth.register');
    }

    // 🔥 PUT IT HERE
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',

            'employee_number' => 'required',

            'department' => 'required|unique:users,department',

            'email' => 'required|email|unique:users,email',

            'password' => 'required|confirmed|min:8',

        ], [

            'department.unique' =>
                'There is already an account registered for this department.',

            'email.unique' =>
                'This email is already registered.',
        ]);

        // CREATE USER
        $user = User::create([
            'name' => $request->name,

            'email' => $request->email,

            'employee_number' => $request->employee_number,

            'department' => $request->department,

            'password' => Hash::make($request->password),

            'role' => 'user',

            'status' => 'pending',
        ]);

        // STORE OTP SESSION
        session([
            'email' => $user->email,
            'otp_type' => 'registration',

            'otp_expires_at' => now()->addMinutes(3),
        ]);

        // GENERATE OTP
        $otp = $this->otpService->generate(
            $user->email,
            'registration'
        );

        // SEND OTP
        $this->otpService->sendEmail(
            $user->email,
            $otp
        );

        return redirect('/verify-otp')
            ->with('success', 'OTP sent to your email.');
    }
}