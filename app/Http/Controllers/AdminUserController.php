<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Otp;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use App\Services\OtpService;

class AdminUserController extends Controller
{
    protected $otpService;

public function __construct(OtpService $otpService)
{
    $this->otpService = $otpService;
}
    public function create()
    {
        return view('admin.create-user');
    }

    public function store(Request $request)
    {
        // // ✅ Validation
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|email|unique:users,email',
        //     'role' => 'required',
        //     'department' => 'required',
        // ]);
        $request->validate([
    'name' => 'required',
    'email' => 'required|email|unique:users,email',
    'role' => 'required|in:admin,custodian,checker,user',
    'department' => 'required',
]);

        // ✅ Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make(Str::random(12)),
            'role' => $request->role,
            'department' => $request->department,
            'status' => 'approved',
        ]);

       // ✅ Generate OTP using service
$otpCode = $this->otpService->generate(
    $user->email,
    'admin_create'
);

// ✅ Send OTP
$this->otpService->sendEmail(
    $user->email,
    $otpCode
);

        return back()->with('success', 'Staff created. OTP sent to email.');
    }
}