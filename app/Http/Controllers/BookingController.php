<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Notifications\SystemNotification;
use App\Services\OtpService;
class BookingController extends Controller
{

protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE FORM
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $vehicles = Vehicle::where('status', 'available')->get();
        $drivers = Driver::all();

        return view('booking.create', compact('vehicles', 'drivers'));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE (SEND OTP)
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'required|exists:drivers,id',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'destination' => 'required',
            'purpose' => 'required',
        ]);

        /*
        | Save booking data temporarily
        */
        session([
            'booking_data' => [
                'vehicle_id' => $request->vehicle_id,
                'driver_id' => $request->driver_id,
                'date' => $request->date,
                'time' => $request->time,
                'destination' => $request->destination,
                'purpose' => $request->purpose,
            ]
        ]);

        // /*
        // | Generate OTP
        // */
        // $otp = rand(100000, 999999);

        // session([
        //     'booking_otp_code' => $otp,
        //     'booking_otp_expires_at' => now()->addMinutes(5)
        // ]);

        /*
        | Send OTP email
        */
        $otp = $this->otpService->generate(auth()->user()->email, 'booking');

        $this->otpService->sendEmail(
            auth()->user()->email,
            $otp,
            'booking',
    [
        'vehicle' => Vehicle::find($request->vehicle_id)?->name,
        'driver' => Driver::find($request->driver_id)?->name,
        'destination' => $request->destination,
        'purpose' => $request->purpose,
    ]
);

        return redirect('/booking/verify-otp');
    }

    /*
    |--------------------------------------------------------------------------
    | OTP PAGE
    |--------------------------------------------------------------------------
    */
    public function otpPage()
    {
        return view('otp.verify-booking');
    }

    /*
    |--------------------------------------------------------------------------
    | VERIFY OTP + CREATE BOOKING
    |--------------------------------------------------------------------------
    */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ]);

        // /*
        // | Check session exists
        // */
        // if (
        //     !session()->has('booking_otp_code') ||
        //     !session()->has('booking_otp_expires_at')
        // ) {
        //     return redirect('/booking')
        //         ->with('error', 'OTP session expired.');
        // }

        // /*
        // | Check expiration
        // */
        // if (now()->gt(session('booking_otp_expires_at'))) {

        //     session()->forget([
        //         'booking_data',
        //         'booking_otp_code',
        //         'booking_otp_expires_at'
        //     ]);

        //     return redirect('/booking')
        //         ->with('error', 'OTP expired. Please try again.');
        // }

        // /*
        // | Check OTP match
        // */
        // if ($request->otp != session('booking_otp_code')) {
        //     return back()->with('error', 'Invalid OTP.');
        // }

        $result = $this->otpService->verify(
    auth()->user()->email,
    $request->otp,
    'booking'
);

if (!$result['status']) {

    return back()->with(
        'error',
        $result['message']
    );

}

        $data = session('booking_data');

        if (!$data) {
            return redirect('/booking')
                ->with('error', 'Booking session expired.');
        }

        /*
        | Create booking
        */
        Booking::create([
            'reference_number' => 'VB-' . strtoupper(Str::random(8)),
            'user_id' => auth()->id(),
            'vehicle_id' => $data['vehicle_id'],
            'driver_id' => $data['driver_id'],
            'date' => $data['date'],
            'time' => $data['time'],
            'destination' => $data['destination'],
            'purpose' => $data['purpose'],
            'status' => 'pending',
        ]);

        // /*
        // | Clear session
        // */
        // session()->forget([
        //     'booking_data',
        //     'booking_otp_code',
        //     'booking_otp_expires_at'
        // ]);

        session()->forget([
    'booking_data'
]);

        return redirect('/my-bookings')
            ->with('success', 'Booking submitted successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN LIST
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $bookings = Booking::with('vehicle', 'user', 'driver');

        if ($request->search) {
            $bookings->where(function ($query) use ($request) {
                $query->where('reference_number', 'like', '%' . $request->search . '%')
                    ->orWhereHas('user', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%');
                    })
                    ->orWhereHas('vehicle', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%');
                    });
            });
        }

        if ($request->status) {
            $bookings->where('status', $request->status);
        }

        if ($request->date_filter == 'today') {
            $bookings->whereDate('created_at', today());
        } elseif ($request->date_filter == 'month') {
            $bookings->whereMonth('created_at', now()->month);
        } elseif ($request->date_filter == 'year') {
            $bookings->whereYear('created_at', now()->year);
        }

        return view('booking.index', [
            'bookings' => $bookings->latest()->get()
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | APPROVE
    |--------------------------------------------------------------------------
    */
    // public function approve($id)
    // {
    //     $booking = Booking::findOrFail($id);

    //     $booking->update([
    //         'status' => 'approved'
    //     ]);

    //     return back()->with('success', 'Booking approved');
    // }

    public function approve($id)
{
    $booking = Booking::findOrFail($id);

    $booking->update([
        'status' => 'approved'
    ]);

    $booking->user->notify(

        new SystemNotification(

            'Your vehicle booking was approved.',

            '/my-bookings'

        )

    );

    return back()->with('success', 'Booking approved');
}

    /*
    |--------------------------------------------------------------------------
    | REJECT
    |--------------------------------------------------------------------------
    */
    // public function reject($id)
    // {
    //     $booking = Booking::findOrFail($id);

    //     $booking->update([
    //         'status' => 'rejected'
    //     ]);

    //     return back()->with('success', 'Booking rejected');
    // }

    public function reject($id)
{
    $booking = Booking::findOrFail($id);

    $booking->update([
        'status' => 'rejected'
    ]);

    $booking->user->notify(

        new SystemNotification(

            'Your vehicle booking was rejected.',

            '/my-bookings'

        )

    );

    return back()->with('success', 'Booking rejected');
}

    /*
    |--------------------------------------------------------------------------
    | CALENDAR
    |--------------------------------------------------------------------------
    */
    public function calendar()
    {
        $bookings = Booking::with('vehicle', 'user', 'driver')
            ->where('status', 'approved')
            ->get();

        $events = [];

        foreach ($bookings as $booking) {
            $events[] = [
                'title' => $booking->vehicle->name,
                'start' => $booking->date . 'T' . $booking->time,
                'vehicle' => $booking->vehicle->name,
                'driver' => $booking->driver->name ?? 'No Driver',
                'user' => $booking->user->name,
                'destination' => $booking->destination,
                'purpose' => $booking->purpose,
                'status' => $booking->status,
            ];
        }

        return view('booking.calendar', compact('events'));
    }
    public function archive()
{
    $bookings = Booking::where(
        'is_archived',
        true
    )->latest()->get();

    return view(
        'archive.bookings',
        compact('bookings')
    );
}
}