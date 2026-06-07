<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Notifications\BorrowStatusNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Notifications\SystemNotification;
use App\Models\User;
use App\Services\OtpService;

class BorrowController extends Controller
{
    protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE PAGE
    |--------------------------------------------------------------------------
    */

    public function create(Request $request)
    {
        // ALL DEPARTMENTS
        $departments = Item::whereNotNull('department')
            ->distinct()
            ->pluck('department');

        // EMPTY DEFAULTS
        $categories = collect();
        $items = collect();

        // LOAD CATEGORIES
        if ($request->department) {

            $categories = Item::where(
                    'department',
                    $request->department
                )
                ->distinct()
                ->pluck('category');
        }

        // LOAD ITEMS
        if ($request->department && $request->category) {

            $items = Item::where(
                    'department',
                    $request->department
                )
                ->where(
                    'category',
                    $request->category
                )
                ->get();
        }

        return view('borrow.create', compact(
            'departments',
            'categories',
            'items'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE BORROW REQUEST
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {

    //     if (!session('otp_verified_borrow')) {
    //     return back()->with('error', 'OTP verification required for borrowing.');
    // }

        $request->validate([

            'item_id' => 'required|exists:items,id',

            'quantity' => 'required|integer|min:1',

            'purpose' => 'required',

        ]);

        /*
        |--------------------------------------------------------------------------
        | FIND ITEM
        |--------------------------------------------------------------------------
        */

        $item = Item::findOrFail($request->item_id);

        /*
        |--------------------------------------------------------------------------
        | CHECK STOCK
        |--------------------------------------------------------------------------
        */

        if ($request->quantity > $item->quantity) {

            return back()->with(
                'error',
                'Requested quantity exceeds available stock.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | SAVE FORM TEMPORARILY
        |--------------------------------------------------------------------------
        */

        session([

            'borrow_data' => [

                'item_id' => $request->item_id,

                'quantity' => $request->quantity,

                'borrow_location' => $request->borrow_location,

                'purpose' => $request->purpose,

                'department' => $request->department,
                
            ]
        ]);

        /*
        |--------------------------------------------------------------------------
        | GENERATE OTP
        |--------------------------------------------------------------------------
        */

        // $otp = rand(100000, 999999);

        // session([

        //     'otp_code' => $otp,

        //     'otp_expires_at' => now()->addMinutes(5)
        // ]);

        /*
        |--------------------------------------------------------------------------
        | FIND DEPARTMENT HEAD EMAIL
        |--------------------------------------------------------------------------
        */

        $departmentHead = \App\Models\User::where(
                'department',
                auth()->user()->department
            )
            ->where('role', 'user')
            ->whereNotNull('email')
            ->where('email', '!=', '')
            ->first();

        /*
        |--------------------------------------------------------------------------
        | SAFETY CHECK
        |--------------------------------------------------------------------------
        */

        if (!$departmentHead || !$departmentHead->email) {

            return back()->with(
                'error',
                'Department Head email not found.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | SEND OTP EMAIL
        |--------------------------------------------------------------------------
        */

       $otp = app(\App\Services\OtpService::class)->generate(
    $departmentHead->email,
    'borrow'
);

app(\App\Services\OtpService::class)->sendEmail(
    $departmentHead->email,
    $otp,
    'borrow',
    [
        'item' => $item->item_name,
        'quantity' => $request->quantity,
        'borrow_location' => $request->borrow_location,
        'purpose' => $request->purpose,
    ]
);

        return redirect('/borrow/verify-otp')
            ->with(
                'success',
                'OTP sent to Department Head email.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | OTP PAGE
    |--------------------------------------------------------------------------
    */

    public function otpPage()
    {
        return view('otp.verify-borrow');
    }

    /*
    |--------------------------------------------------------------------------
    | VERIFY OTP
    |--------------------------------------------------------------------------
    */

    public function verifyOtp(Request $request)
    {
        $request->validate([

            'otp' => 'required'

        ]);

        // /*
        // |--------------------------------------------------------------------------
        // | CHECK OTP SESSION
        // |--------------------------------------------------------------------------
        // */

        // if (!session('otp_expires_at')) {

        //     return back()->with(
        //         'error',
        //         'OTP session expired.'
        //     );
        // }

        // /*
        // |--------------------------------------------------------------------------
        // | CHECK OTP EXPIRATION
        // |--------------------------------------------------------------------------
        // */

        // if (now()->gt(session('otp_expires_at'))) {

        //     session()->forget([

        //         'borrow_data',

        //         'otp_code',

        //         'otp_expires_at'
        //     ]);

        //     return redirect('/borrow')
        //         ->with(
        //             'error',
        //             'OTP expired. Please request again.'
        //         );
        // }

        // /*
        // |--------------------------------------------------------------------------
        // | CHECK OTP
        // |--------------------------------------------------------------------------
        // */

        // if ($request->otp != session('otp_code')) {

        //     return back()->with(
        //         'error',
        //         'Invalid OTP.'
        //     );
        // }

        $departmentHead = User::where(
    'department',
    auth()->user()->department
)
->where('role', 'user')
->first();

$result = $this->otpService->verify(
    $departmentHead->email,
    $request->otp,
    'borrow'
);

if (!$result['status']) {

    return back()->with(
        'error',
        $result['message']
    );

}

        /*
        |--------------------------------------------------------------------------
        | GET SAVED FORM DATA
        |--------------------------------------------------------------------------
        */

        $data = session('borrow_data');

        if (!$data) {

            return redirect('/borrow')
                ->with(
                    'error',
                    'Borrow session expired.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | CREATE BORROW REQUEST
        |--------------------------------------------------------------------------
        */

        Borrow::create([

            'reference_number' =>
                'BRW-' . strtoupper(Str::random(8)),

            'user_id' => auth()->id(),

            'item_id' => $data['item_id'],

            'quantity' => $data['quantity'],

             'borrow_location' => $data['borrow_location'] ?? 'inside',

            'purpose' => $data['purpose'],

            'department' => $data['department'],

            'status' => 'pending',
        ]);

        /*
        |--------------------------------------------------------------------------
        | CLEAR OTP SESSION
        |--------------------------------------------------------------------------
        */

        // session()->forget([

        //     'borrow_data',

        //     'otp_code',

        //     'otp_expires_at'
        // ]);

        session()->forget([

    'borrow_data'
]);

        return redirect('/my-borrows')
            ->with(
                'success',
                'Borrow request submitted successfully.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | PENDING REQUESTS
    |--------------------------------------------------------------------------
    */

    // public function pending(Request $request)
    // {
    //     $borrows = Borrow::with('user', 'item');

    //     // SEARCH
    //     if ($request->search) {

    //         $borrows->where(function ($query) use ($request) {

    //             $query->where(
    //                     'reference_number',
    //                     'like',
    //                     '%' . $request->search . '%'
    //                 )

    //                 ->orWhere(
    //                     'status',
    //                     'like',
    //                     '%' . $request->search . '%'
    //                 )

    //                 ->orWhereHas('user', function ($q) use ($request) {

    //                     $q->where(
    //                         'name',
    //                         'like',
    //                         '%' . $request->search . '%'
    //                     );
    //                 })

    //                 ->orWhereHas('item', function ($q) use ($request) {

    //                     $q->where(
    //                         'item_name',
    //                         'like',
    //                         '%' . $request->search . '%'
    //                     );
    //                 });
    //         });
    //     }

    //     // STATUS
    //     if ($request->status) {

    //         $borrows->where(
    //             'status',
    //             $request->status
    //         );
    //     }

    //     // DATE FILTER
    //     if ($request->date_filter == 'today') {

    //         $borrows->whereDate(
    //             'created_at',
    //             today()
    //         );

    //     } elseif ($request->date_filter == 'month') {

    //         $borrows->whereMonth(
    //             'created_at',
    //             now()->month
    //         );

    //     } elseif ($request->date_filter == 'year') {

    //         $borrows->whereYear(
    //             'created_at',
    //             now()->year
    //         );
    //     }

    //     $borrows = $borrows->latest()->get();

    //     return view('borrow.pending', compact('borrows'));
    // }

    public function pending(Request $request)
{
    $borrows = Borrow::with('user', 'item')
        ->where('status', 'pending'); // ✅ ADD THIS LINE

    // SEARCH
    if ($request->search) {
        $borrows->where(function ($query) use ($request) {
            $query->where('reference_number', 'like', '%' . $request->search . '%')
                ->orWhere('status', 'like', '%' . $request->search . '%')
                ->orWhereHas('user', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                })
                ->orWhereHas('item', function ($q) use ($request) {
                    $q->where('item_name', 'like', '%' . $request->search . '%');
                });
        });
    }

    // DATE FILTER
    if ($request->date_filter == 'today') {
        $borrows->whereDate('created_at', today());
    } elseif ($request->date_filter == 'month') {
        $borrows->whereMonth('created_at', now()->month);
    } elseif ($request->date_filter == 'year') {
        $borrows->whereYear('created_at', now()->year);
    }

    $borrows = $borrows->latest()->get();

    return view('borrow.pending', compact('borrows'));
}

    /*
    |--------------------------------------------------------------------------
    | APPROVE
    |--------------------------------------------------------------------------
    */

    // public function approve(Request $request, $id)
    // {
    //     $borrow = Borrow::findOrFail($id);

    //     $item = Item::findOrFail($borrow->item_id);

    //     // CHECK STOCK
    //     if ($item->quantity < $borrow->quantity) {

    //         return back()->with(
    //             'error',
    //             'Not enough stock available.'
    //         );
    //     }

    //     // DEDUCT STOCK
    //     $item->quantity -= $borrow->quantity;

    //     $item->save();

    //     // QR CONTENT
    //     $qrData = "REF: {$borrow->reference_number} | ITEM: {$item->item_name} | QTY: {$borrow->quantity}";

    //     $borrow->qr_code = base64_encode(
    //         QrCode::size(200)->generate($qrData)
    //     );

    //     $hours = $request->expiry_hours ?? 24;

    //     $borrow->status = 'approved';

    //     $borrow->approved_by = auth()->id();

    //     $borrow->approved_at = now();

    //     $borrow->expires_at = Carbon::now()->addHours($hours);

    //     $borrow->save();

    //     $borrow->user->notify(
    //         new BorrowStatusNotification($borrow, 'approved')
    //     );

    //     return back()->with(
    //         'success',
    //         'Borrow approved successfully.'
    //     );
    // }


    public function approve(Request $request, $id)
{
    $borrow = Borrow::findOrFail($id);

    $item = Item::findOrFail($borrow->item_id);

    /*
    |--------------------------------------------------------------------------
    | CHECK STOCK
    |--------------------------------------------------------------------------
    */

    if ($item->quantity < $borrow->quantity) {

        return back()->with(
            'error',
            'Not enough stock available.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DEDUCT STOCK
    |--------------------------------------------------------------------------
    */

    $item->quantity -= $borrow->quantity;

    $item->save();

    /*
    |--------------------------------------------------------------------------
    | QR CONTENT
    |--------------------------------------------------------------------------
    */

    // $qrData = "REF: {$borrow->reference_number} | ITEM: {$item->item_name} | QTY: {$borrow->quantity}";

    // $borrow->qr_code = base64_encode(
    //     QrCode::size(200)->generate($qrData)
    // );

    // $hours = $request->expiry_hours ?? 24;

    // $borrow->status = 'approved';

    // $borrow->approved_by = auth()->id();

    // $borrow->approved_at = now();

    // $borrow->expires_at = Carbon::now()->addHours($hours);

    // $borrow->save();

    $borrow->status = 'approved';

    $borrow->approved_by = auth()->id();

    $borrow->approved_at = now();

    $borrow->save();

    /*
    |--------------------------------------------------------------------------
    | NOTIFY USER
    |--------------------------------------------------------------------------
    */

    $borrow->user->notify(

        new SystemNotification(

            'Your borrow request was approved.',

            '/my-borrows'

        )

    );

    /*
    |--------------------------------------------------------------------------
    | NOTIFY CUSTODIANS
    |--------------------------------------------------------------------------
    */

    $custodians = User::where(
        'role',
        'custodian'
    )->get();

    foreach ($custodians as $custodian) {

        $custodian->notify(

            new SystemNotification(

                'Borrow approved and waiting for release.',

                '/custodian'

            )

        );
    }

    return back()->with(
        'success',
        'Borrow approved successfully.'
    );
}

    /*
    |--------------------------------------------------------------------------
    | REJECT
    |--------------------------------------------------------------------------
    */

    // public function reject($id)
    // {
    //     $borrow = Borrow::findOrFail($id);

    //     $borrow->status = 'rejected';

    //     $borrow->approved_by = auth()->id();

    //     $borrow->approved_at = now();

    //     $borrow->save();

    //     $borrow->user->notify(
    //         new BorrowStatusNotification($borrow, 'rejected')
    //     );

    //     return back()->with(
    //         'success',
    //         'Borrow rejected'
    //     );
    // }

    public function reject($id)
{
    $borrow = Borrow::findOrFail($id);

    $borrow->status = 'rejected';

    $borrow->approved_by = auth()->id();

    $borrow->approved_at = now();

    $borrow->save();

    $borrow->user->notify(

        new SystemNotification(

            'Your borrow request was rejected.',

            '/my-borrows'

        )

    );

    return back()->with(
        'success',
        'Borrow rejected'
    );
}

    /*
    |--------------------------------------------------------------------------
    | RELEASE
    |--------------------------------------------------------------------------
    */

    // public function release($id)
    // {
    //     $borrow = Borrow::findOrFail($id);

    //     $borrow->return_status = 'released';

    //     $borrow->save();

    //     return back()->with(
    //         'success',
    //         'Item released.'
    //     );
    // }

    public function release($id)
{
    $borrow = Borrow::findOrFail($id);

    $borrow->return_status = 'released';

    $borrow->save();

    $borrow->user->notify(

        new SystemNotification(

            'Your item is now released by the custodian.',

            '/my-borrows'

        )

    );

    return back()->with(
        'success',
        'Item released.'
    );
}

    /*
    |--------------------------------------------------------------------------
    | RETURN
    |--------------------------------------------------------------------------
    */

    // public function markReturned($id)
    // {
    //     $borrow = Borrow::findOrFail($id);

    //     $borrow->return_status = 'returned';

    //     $borrow->returned_at = now();

    //     // RESTORE STOCK
    //     $item = Item::findOrFail($borrow->item_id);

    //     $item->quantity += $borrow->quantity;

    //     $item->save();

    //     $borrow->save();
        

    //     return back()->with(
    //         'success',
    //         'Item returned successfully.'
    //     );
    // }

    public function markReturned($id)
{
    $borrow = Borrow::findOrFail($id);

    $borrow->return_status = 'returned';

    $borrow->returned_at = now();

    $item = Item::findOrFail($borrow->item_id);

    $item->quantity += $borrow->quantity;

    $item->save();

    $borrow->save();

    $borrow->user->notify(

        new SystemNotification(

            'Borrow marked as returned.',

            '/my-borrows'

        )

    );

    return back()->with(
        'success',
        'Item returned successfully.'
    );
}

    /*
    |--------------------------------------------------------------------------
    | QR PAGE
    |--------------------------------------------------------------------------
    */

    public function qr($id)
    {
        $borrow = Borrow::with([
            'user',
            'item'
        ])->findOrFail($id);

        $borrower = $borrow->user;

        $approvedBy = $borrow->approved_by
            ? \App\Models\User::find($borrow->approved_by)
            : null;

        return view(
            'user.qr',
            compact(
                'borrow',
                'borrower',
                'approvedBy'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | GATEPASS
    |--------------------------------------------------------------------------
    */

    public function gatePass($id)
    {
        $borrow = Borrow::with([
            'user',
            'item'
        ])->findOrFail($id);

        $borrower = $borrow->user;

        return view(
            'user.gatepass',
            compact(
                'borrow',
                'borrower'
            )
        );
    }
   public function all(Request $request)
{
    $query = Borrow::with(['user', 'item']);

    // SEARCH
    if ($request->filled('search')) {

        $search = $request->search;

        $query->where(function ($q) use ($search) {

            $q->where('reference_number', 'like', "%{$search}%")
              ->orWhere('department', 'like', "%{$search}%")
              ->orWhereHas('user', function ($u) use ($search) {

                    $u->where('name', 'like', "%{$search}%");

              })
              ->orWhereHas('item', function ($i) use ($search) {

                    $i->where('item_name', 'like', "%{$search}%");

              });

        });
    }

    // STATUS FILTER
    if ($request->filled('status')) {

        $query->where('status', $request->status);

    }

    // DATE FILTER
    if ($request->date_filter == 'today') {

        $query->whereDate('created_at', now());

    }

    if ($request->date_filter == 'month') {

        $query->whereMonth('created_at', now()->month)
              ->whereYear('created_at', now()->year);

    }

    if ($request->date_filter == 'year') {

        $query->whereYear('created_at', now()->year);

    }

    if ($request->filled('start_date') && $request->filled('end_date')) {
    $query->whereBetween('created_at', [
        $request->start_date . ' 00:00:00',
        $request->end_date . ' 23:59:59'
    ]);
}

    $borrows = $query->latest()->get();

    return view(
        'admin.borrow.all',
        compact('borrows')
    );
}
// public function archive()
// {
//     $borrows = \App\Models\Borrow::whereIn('status', ['approved', 'rejected'])
//         ->latest()
//         ->get();

//     return view('admin.borrow.archive', compact('borrows'));
// }
public function archive()
{
    $borrows = Borrow::where('is_archived', true)
        ->latest()
        ->get();

    return view(
        'archive.borrows',
        compact('borrows')
    );
}
}