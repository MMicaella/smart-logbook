<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\CustodianController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\RequestItemController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReportController;

use App\Models\Borrow;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/

Route::get('/', fn () => view('welcome'));

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
    ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/', fn () => view('admin.dashboard'));

        Route::get('/bookings', [BookingController::class, 'index']);
        Route::post('/bookings/{id}/approve', [BookingController::class, 'approve']);
        Route::post('/bookings/{id}/reject', [BookingController::class, 'reject']);
        Route::get('/calendar', [BookingController::class, 'calendar']);

        Route::get('/users', fn () => view('admin.users', [
            'users' => \App\Models\User::all()
        ]));

        Route::post('/users/{id}/approve', function ($id) {
            $user = \App\Models\User::findOrFail($id);
            $user->status = 'approved';
            $user->save();
            return back();
        });

        Route::post('/users/{id}/reject', function ($id) {
            $user = \App\Models\User::findOrFail($id);
            $user->status = 'rejected';
            $user->save();
            return back();
        });

        Route::get('/users/create', [AdminUserController::class, 'create']);
        Route::post('/users/store', [AdminUserController::class, 'store']);

        Route::get('/borrow-requests', [BorrowController::class, 'pending']);
        Route::post('/borrow/{id}/approve', [BorrowController::class, 'approve']);
        Route::post('/borrow/{id}/reject', [BorrowController::class, 'reject']);
        Route::get('/admin/borrow/{id}', [BorrowController::class, 'show']);
        // VIEW ALL BORROW REQUESTS
    Route::get('/borrow/all', [BorrowController::class, 'all'])->name('all');

    // ARCHIVE PAGE
    Route::get('/borrow/archive', [BorrowController::class, 'archive'])->name('archive');

        Route::get('/vehicles', [VehicleController::class, 'index']);
        Route::get('/vehicles/create', [VehicleController::class, 'create']);
        Route::post('/vehicles/store', [VehicleController::class, 'store']);
        Route::post('/vehicles/{id}/status', [VehicleController::class, 'updateStatus']);
        Route::delete('/vehicles/{id}', [VehicleController::class, 'destroy']);

        Route::get('/drivers', [DriverController::class, 'index']);
        Route::get('/drivers/create', [DriverController::class, 'create']);
        Route::post('/drivers/store', [DriverController::class, 'store']);
        Route::delete('/drivers/{id}', [DriverController::class, 'destroy']);

        Route::get('/request-items', [RequestItemController::class, 'index']);
        Route::post('/request-item/{id}/approve', [RequestItemController::class, 'approve']);
        Route::post('/request-item/{id}/reject', [RequestItemController::class, 'reject']);


         Route::get('/reports', [ReportController::class, 'index']);

        Route::get('/reports/borrows', [ReportController::class, 'borrowReport']);

        Route::get('/reports/bookings', [ReportController::class, 'bookingReport']);

        Route::get('/reports/requests', [ReportController::class, 'requestReport']);
    });

/*
|--------------------------------------------------------------------------
| CUSTODIAN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:custodian'])
    ->prefix('custodian')
    ->group(function () {

        Route::get('/', [CustodianController::class, 'index']);

        Route::get('/borrowings/{id}/release', [CustodianController::class, 'showRelease']);
        Route::put('/borrowings/{id}/release', [CustodianController::class, 'releaseItem']);

        Route::post('/return/{id}', [CustodianController::class, 'returnItem']);

        Route::get('/verify', [CustodianController::class, 'verifyPage']);
        Route::post('/verify', [CustodianController::class, 'verify']);

        Route::get('/inventory', [CustodianController::class, 'inventory']);
        Route::get('/low-stock', [CustodianController::class, 'lowStock']);
        Route::get('/overview', [CustodianController::class, 'overview']);

        Route::get('/items/create', [ItemController::class, 'create']);
        Route::post('/items', [ItemController::class, 'store']);
        Route::get('/items', [ItemController::class, 'index']);
        Route::get('/items/{id}/edit', [ItemController::class, 'edit']);
        Route::put('/items/{id}', [ItemController::class, 'update']);
        Route::get('/items/{item}', [ItemController::class, 'show']);
        Route::delete('/items/{id}', [ItemController::class, 'destroy']);

        Route::get(
    '/custodian/request-items',
    [RequestItemController::class, 'releaseQueue']
);

Route::get(
    '/request-release',
    [CustodianController::class, 'releaseList']
)->middleware('auth');

Route::post(
    '/request-release/{id}',
    [RequestItemController::class, 'release']
)->middleware('auth');
    });

/*
|--------------------------------------------------------------------------
| USER ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:user'])->group(function () {

    Route::get('/items', [ItemController::class, 'index']);

    Route::get('/borrow', [BorrowController::class, 'create']);
    Route::post('/borrow', [BorrowController::class, 'store']);
    Route::get('/borrow/verify-otp', [BorrowController::class, 'otpPage']);
    Route::post('/borrow/verify-otp', [BorrowController::class, 'verifyOtp']);
    Route::get('/borrow/pending', [BorrowController::class, 'pending']);

    Route::get('/borrow/{id}/qr', [BorrowController::class, 'qr'])->name('borrow.qr');
    Route::get('/gatepass/{id}', [BorrowController::class, 'gatePass']);

    Route::get('/booking', [BookingController::class, 'create']);
    Route::post('/booking', [BookingController::class, 'store']);
    Route::get('/booking/verify-otp', [BookingController::class, 'otpPage']);
    Route::post('/booking/verify-otp', [BookingController::class, 'verifyOtp']);

    Route::get('/request-item', [RequestItemController::class, 'create']);
    Route::post('/request-item/store', [RequestItemController::class, 'store']);
    Route::get('/request-item/verify-otp', [RequestItemController::class, 'otpPage']);
    Route::post('/request-item/verify-otp', [RequestItemController::class, 'verifyOtp']);

    Route::get('/user/dashboard', [DashboardController::class, 'dashboard']);

    // Route::get('/my-borrows', fn () => view('user.borrows', [
    //     'borrows' => Borrow::where('user_id', auth()->id())->get()
    // ]));

    Route::get('/my-borrows', function () {

    $query = Borrow::with('item')
        ->where('user_id', auth()->id());

    // SEARCH
    if (request('search')) {

        $search = request('search');

        $query->where(function ($q) use ($search) {

            $q->where('reference_number', 'like', "%{$search}%")

              ->orWhereHas('item', function ($item) use ($search) {

                    $item->where(
                        'item_name',
                        'like',
                        "%{$search}%"
                    );

              });

        });
    }

    // STATUS FILTER
    if (request('status')) {

        if (
            request('status') == 'released' ||
            request('status') == 'returned'
        ) {

            $query->where(
                'return_status',
                request('status')
            );

        } else {

            $query->where(
                'status',
                request('status')
            );
        }
    }

    // DATE FILTER
    if (request('date_filter') == 'today') {

        $query->whereDate(
            'created_at',
            today()
        );

    } elseif (request('date_filter') == 'month') {

        $query->whereMonth(
            'created_at',
            now()->month
        )->whereYear(
            'created_at',
            now()->year
        );

    } elseif (request('date_filter') == 'year') {

        $query->whereYear(
            'created_at',
            now()->year
        );
    }

    $borrows = $query
        ->latest()
        ->get();

    return view(
        'user.borrows',
        compact('borrows')
    );

});

    Route::get('/my-bookings', fn () => view('user.bookings', [
        'bookings' => \App\Models\Booking::where('user_id', auth()->id())->get()
    ]));

    Route::get('/my-requests', [RequestItemController::class, 'myRequests']);
});

Route::post(
    '/resend-otp',
    [OtpController::class, 'resendOtp']
)->name('otp.resend');
// Route::post(
//     '/otp/resend-registration',
//     [OtpController::class,'resendRegistrationOtp']
// );
/*
|--------------------------------------------------------------------------
| OTP SYSTEM (ONLY CONTROLLER - CLEAN)
|--------------------------------------------------------------------------
*/

// Route::middleware('auth')->group(function () {

//     Route::get('/verify-otp', fn () => view('otp.verify-registration'));

//     Route::post('/otp/send', [OtpController::class, 'sendOtp']);
//     Route::post('/otp/verify', [OtpController::class, 'verifyOtp']);
//     Route::post('/otp/resend', [OtpController::class, 'resendOtp']);

// });

/*
|--------------------------------------------------------------------------
| QR SCAN
|--------------------------------------------------------------------------
*/

Route::get('/scan/{reference}', function ($reference) {

    $borrow = Borrow::where('reference_number', $reference)->first();

    return view('scan-result', [
        'valid' => (bool) $borrow,
        'borrow' => $borrow
    ]);
});


/*
|--------------------------------------------------------------------------
| NOTIFICATIONS
|--------------------------------------------------------------------------
*/
// Route::get('/notifications', function () {

//     return view('notifications.index');

// })->middleware('auth');
Route::middleware(['auth'])->group(function () {

    Route::get(
        '/notifications',
        [NotificationController::class, 'index']
    )->name('notifications');

});
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::view('/archive', 'archive.index');

    Route::get('/archive/borrows',
        [BorrowController::class, 'archive']);

    Route::get('/archive/bookings',
        [BookingController::class, 'archive']);

    Route::get('/archive/requests',
        [RequestItemController::class, 'archive']);

});
/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

Route::post('/logout', function (Request $request) {

    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');

})->name('logout');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';