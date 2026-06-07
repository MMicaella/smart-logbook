<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Borrow;

class DashboardController extends Controller
{
    

public function index()
{
    $totalItems = Item::count();
    $totalBorrows = Borrow::count();

    $pending = Borrow::where('status', 'pending')->count();
    $approved = Borrow::where('status', 'approved')->count();
    $rejected = Borrow::where('status', 'rejected')->count();

    // RETURN SYSTEM (based on your logic)
    $released = Borrow::where('return_status', 'released')->count();
    $returned = Borrow::where('return_status', 'returned')->count();

    // OVERDUE (example rule: released > 3 days)
    $overdue = Borrow::where('return_status', 'released')
        ->where('created_at', '<', now()->subDays(3))
        ->count();

    return view('dashboard', compact(
        'totalItems',
        'totalBorrows',
        'pending',
        'approved',
        'rejected',
        'released',
        'returned',
        'overdue'
    ));
}
    public function dashboard()
{
    $userId = auth()->id();

    return view('user.dashboard', [
        'borrowCount' => \App\Models\Borrow::where('user_id', $userId)->count(),
        'bookingCount' => \App\Models\Booking::where('user_id', $userId)->count(),
        'pendingCount' => \App\Models\Borrow::where('user_id', $userId)
            ->where('status', 'pending')->count(),
    ]);
}
}
