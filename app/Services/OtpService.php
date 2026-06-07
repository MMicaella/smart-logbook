<?php

namespace App\Services;

use App\Models\Otp;
use Illuminate\Support\Facades\Mail;

class OtpService
{
    /**
     * Generate OTP and store it in DB
     */
    public function generate($email, $type = 'general')
    {
        $otp = rand(100000, 999999);

        $expiresAt = match ($type) {
    'registration' => now()->addMinutes(3),
    'admin_create' => now()->addMinutes(10),
    'borrow'       => now()->addHours(24),
    'request'      => now()->addHours(24),
    'booking'      => now()->addHours(24),
    default        => now()->addMinutes(3),
};

        Otp::updateOrCreate(
            [
                'email' => $email,
                'type'  => $type,
            ],
            [
                'otp'         => $otp,
                'expires_at'  => $expiresAt,
            ]
        );

        return $otp;
    }

    /**
     * Send OTP email WITH CONTEXT
     */
    // public function sendEmail($email, $otp, $type = 'general', $details = [])
    // {
    //     $subject = match ($type) {
    //         'registration' => 'OTP Verification - Registration',
    //         'borrow'       => 'OTP Verification - Borrow Request',
    //         'request'      => 'OTP Verification - Item Request',
    //         'booking'      => 'OTP Verification - Vehicle Booking',
    //         default        => 'OTP Verification',
    //     };

    //     $message = "Your OTP is: {$otp}\n\n";

    //     switch ($type) {

    //         case 'registration':
    //             $message .= "This OTP is required for account registration.\n";
    //             break;

    //         case 'borrow':
    //             $message .= "Borrow Details:\n";
    //             $message .= "Item: " . ($details['item'] ?? 'N/A') . "\n";
    //             $message .= "Quantity: " . ($details['quantity'] ?? 'N/A') . "\n";
    //             $message .= "Borrow Location: " . ($details['borrow_location'] ?? 'N/A') . "\n";
    //             $message .= "Purpose: " . ($details['purpose'] ?? 'N/A') . "\n";
    //             break;

    //         case 'request':
    //             $message .= "Request Details:\n";
    //             $message .= "Item: " . ($details['item'] ?? 'N/A') . "\n";
    //             $message .= "Quantity: " . ($details['quantity'] ?? 'N/A') . "\n";
    //             $message .= "Purpose: " . ($details['purpose'] ?? 'N/A') . "\n";
    //             break;

    //         case 'booking':
    //             $message .= "Booking Details:\n";
    //             $message .= "Vehicle: " . ($details['vehicle'] ?? 'N/A') . "\n";
    //             $message .= "Driver: " . ($details['driver'] ?? 'N/A') . "\n";
    //             $message .= "Destination: " . ($details['destination'] ?? 'N/A') . "\n";
    //             $message .= "Purpose: " . ($details['purpose'] ?? 'N/A') . "\n";
    //             break;
    //     }

    //     $message .= "\nThis OTP will expire soon. Please do not share it with anyone.";

    //     Mail::raw($message, function ($mail) use ($email, $subject) {
    //         $mail->to($email)
    //              ->subject($subject);
    //     });
    // }

    public function sendEmail($email, $otp, $type = 'general', $details = [])
{
    $subject = match ($type) {
    'registration' => 'OTP Verification - Registration',
    'admin_create' => 'Staff Account Created',
    'borrow' => 'OTP Verification - Borrow Request',
    'request' => 'OTP Verification - Item Request',
    'booking' => 'OTP Verification - Vehicle Booking',
    default => 'OTP Verification',
};

    $title = match ($type) {
    'registration' => 'Account Registration',
    'admin_create' => 'Staff Account Creation',
    'borrow' => 'Borrow Request',
    'request' => 'Item Request',
    'booking' => 'Vehicle Booking',
    default => 'OTP Verification',
};

    $detailsHtml = '';

    foreach ($details as $key => $value) {

        $label = ucwords(str_replace('_', ' ', $key));

        $detailsHtml .= "
            <tr>
                <td style='padding:10px;color:#cbd5e1;font-weight:bold;'>
                    {$label}
                </td>

                <td style='padding:10px;color:white;'>
                    {$value}
                </td>
            </tr>
        ";
    }

    $html = "

    <html>

    <body style='
        background:#0f172a;
        padding:40px;
        font-family:Arial,sans-serif;
    '>

        <div style='
            max-width:700px;
            margin:auto;
            background:rgba(255,255,255,.05);
            border:1px solid rgba(255,255,255,.1);
            border-radius:25px;
            overflow:hidden;
        '>

            <div style='
                background:linear-gradient(135deg,#7f1d1d,#220000);
                padding:30px;
                text-align:center;
            '>

                <h1 style='
                    color:white;
                    margin:0;
                '>
                    Smart LogBook
                </h1>

                <p style='
                    color:#fecaca;
                    margin-top:10px;
                '>
                    {$title}
                </p>

            </div>

            <div style='padding:35px;'>

                <p style='
                    color:#e5e7eb;
                    text-align:center;
                '>
                    Use the OTP below to continue.
                </p>

                <div style='
                    background:#7f1d1d;
                    color:white;
                    font-size:40px;
                    font-weight:bold;
                    text-align:center;
                    padding:20px;
                    border-radius:20px;
                    letter-spacing:8px;
                    margin:25px 0;
                '>

                    {$otp}

                </div>

                <div style='
                    background:rgba(255,255,255,.04);
                    border-radius:20px;
                    padding:20px;
                '>

                    <h3 style='
                        color:white;
                        margin-top:0;
                    '>
                        Transaction Details
                    </h3>

                    <table width='100%'>

                        {$detailsHtml}

                    </table>

                </div>

                <div style='
                    margin-top:20px;
                    background:#1e293b;
                    padding:15px;
                    border-radius:12px;
                '>

                    <p style='
                        color:#fca5a5;
                        margin:0;
                        font-size:13px;
                    '>
                        Do not share this OTP with anyone.
                    </p>

                </div>

            </div>

            <div style='
                text-align:center;
                color:#94a3b8;
                padding:15px;
                border-top:1px solid rgba(255,255,255,.1);
            '>

                Smart LogBook System

            </div>

        </div>

    </body>

    </html>
    ";

    Mail::html($html, function ($mail) use ($email, $subject) {

        $mail->to($email)
             ->subject($subject);

    });
}

    /**
     * Verify OTP
     */
    public function verify($email, $otp, $type = 'general')
    {
        $record = Otp::where('email', $email)
            ->where('type', $type)
            ->where('otp', (string) $otp)
            ->first();

        if (!$record) {
            return [
                'status' => false,
                'message' => 'Invalid OTP'
            ];
        }

        if (now()->gt($record->expires_at)) {
            return [
                'status' => false,
                'message' => 'OTP expired'
            ];
        }

        $record->delete();

        return [
            'status' => true,
            'message' => 'OTP verified successfully'
        ];
    }
}