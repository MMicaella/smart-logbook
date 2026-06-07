<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Services\OtpService;

class OtpController extends Controller
{
    protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    /*
    |--------------------------------------------------------------------------
    | SEND OTP
    |--------------------------------------------------------------------------
    */

    public function sendOtp(Request $request)
    {
        $request->validate([
            'type' => 'required|in:registration,borrow,request,booking',
            'email' => 'nullable|email'
        ]);

        $email = null;

        // REGISTRATION
        if ($request->type === 'registration') {

            $email = $request->email;

        } else {

            // LOGGED IN USER
            if (auth()->check()) {

                $email = auth()->user()->email;
            }
        }

        if (!$email) {

            return back()->with(
                'error',
                'Email not found.'
            );
        }

        // GENERATE OTP
        $otp = $this->otpService->generate(
            $email,
            $request->type
        );

        // SEND EMAIL
        $this->otpService->sendEmail(
    $email,
    $otp,
    $request->type
);

        // STORE SESSION
        session([
            'email' => $email,
            'otp_type' => $request->type,

            'otp_expires_at' => match($request->type) {
                'registration' => now()->addMinutes(3)->timestamp,
                'borrow' => now()->addHours(24)->timestamp,
                'request' => now()->addHours(24)->timestamp,
                'booking' => now()->addHours(24)->timestamp,
    }
        ]);

        // ACTION OTP FLAGS
        if ($request->type !== 'registration') {

            session([
                "otp_verified_{$request->type}" => false,
                "otp_pending_{$request->type}" => true,
            ]);
        }

        return redirect('/verify-otp')
            ->with(
                'success',
                'OTP sent successfully!'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | VERIFY OTP
    |--------------------------------------------------------------------------
    */

    public function verifyOtp(Request $request)
    {
        $otp =
            $request->otp1 .
            $request->otp2 .
            $request->otp3 .
            $request->otp4 .
            $request->otp5 .
            $request->otp6;

        $email = session('email');
        $type  = session('otp_type');

        if (!$email || !$type) {

            return back()->with(
                'error',
                'Session expired.'
            );
        }

        $record = Otp::where('email', $email)
            ->where('type', $type)
            ->where('otp', $otp)
            ->first();

        // INVALID OTP
        if (!$record) {

            return back()->with(
                'error',
                'Invalid OTP.'
            );
        }

        // EXPIRED OTP
        if (now()->gt($record->expires_at)) {

            return back()->with(
                'error',
                'OTP expired.'
            );
        }

        // DELETE OTP AFTER SUCCESS
        $record->delete();

        /*
        |--------------------------------------------------------------------------
        | REGISTRATION OTP
        |--------------------------------------------------------------------------
        */

        if ($type === 'registration') {

            $user = User::where(
                'email',
                $email
            )->first();

            if ($user) {

                $user->email_verified_at = now();

                $user->save();
            }

            session()->forget([
                'email',
                'otp_type'
            ]);

            return redirect('/login')
                ->with(
                    'success',
                    'Email verified successfully!'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | BORROW / REQUEST / BOOKING OTP
        |--------------------------------------------------------------------------
        */

        session([
            "otp_verified_{$type}" => true,
            "otp_pending_{$type}" => false,
            "otp_used_at_{$type}" => now()
        ]);

        return back()->with(
            'success',
            'OTP verified successfully!'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RESEND OTP
    |--------------------------------------------------------------------------
    */

    public function resendOtp(Request $request)
    {
        $email = session('email');
        $type  = session('otp_type');

        if (!$email || !$type) {

            return back()->with(
                'error',
                'Session expired. Please try again.'
            );
        }

        // GENERATE NEW OTP
        $otp = $this->otpService->generate(
            $email,
            $type
        );

        // SEND EMAIL
        $this->otpService->sendEmail(
    $email,
    $otp,
    $type
);

        // KEEP SESSION
        session([
    'email' => $email,
    'otp_type' => $type,

    'otp_expires_at' => match($type) {
        'registration' => now()->addMinutes(3)->timestamp,
        'borrow' => now()->addHours(24)->timestamp,
        'request' => now()->addHours(24)->timestamp,
        'booking' => now()->addHours(24)->timestamp,
    }
]);

        return back()->with(
            'success',
            'OTP resent successfully!'
        );
    }
}