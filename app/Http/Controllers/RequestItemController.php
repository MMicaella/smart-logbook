<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

use App\Models\Item;
use App\Models\RequestItem;

use App\Notifications\SystemNotification;

use App\Services\OtpService;
class RequestItemController extends Controller
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
    public function create(Request $request)
    {
        $departments = Item::whereNotNull('department')
            ->distinct()
            ->pluck('department');

        $categories = collect();
        $items = collect();

        if ($request->department) {
            $categories = Item::where('department', $request->department)
                ->distinct()
                ->pluck('category');
        }

        if ($request->department && $request->category) {
            $items = Item::where('department', $request->department)
                ->where('category', $request->category)
                ->get();
        }

        return view('request.create', compact(
            'departments',
            'categories',
            'items'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | STEP 1: STORE + SEND OTP
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'purpose' => 'required',
            'fund_source' => 'required',
        ]);

        $item = Item::findOrFail($request->item_id);

        if ($request->quantity > $item->quantity) {
            return back()->with('error', 'Not enough stock.');
        }

        // TEMP SESSION DATA (IMPORTANT)
        session([
            'request_item_data' => [
                'item_id' => $request->item_id,
                'quantity' => $request->quantity,
                'purpose' => $request->purpose,
                'fund_source' => $request->fund_source,
                'request_location' => $request->request_location,
            ]
        ]);

        // // OTP
        // $otp = rand(100000, 999999);

        // session([
        //     'request_otp_code' => $otp,
        //     'request_otp_expires' => now()->addMinutes(5)
        // ]);

        $otp = $this->otpService->generate(auth()->user()->email, 'request');

        $this->otpService->sendEmail(
    auth()->user()->email,
    $otp,
    'request',
    [
        'item' => $item->item_name,
        'quantity' => $request->quantity,
        'purpose' => $request->purpose,
    ]
);
        return redirect('/request-item/verify-otp');
    }

    /*
    |--------------------------------------------------------------------------
    | OTP PAGE
    |--------------------------------------------------------------------------
    */
    public function otpPage()
    {
        return view('otp.verify-request-item');
    }

    /*
    |--------------------------------------------------------------------------
    | VERIFY OTP + SAVE
    |--------------------------------------------------------------------------
    */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ]);

        // // CHECK SESSION
        // if (!session()->has('request_otp_code')) {
        //     return redirect('/request-item')
        //         ->with('error', 'OTP session expired.');
        // }

        // // CHECK EXPIRY
        // if (now()->gt(session('request_otp_expires'))) {
        //     session()->forget([
        //         'request_item_data',
        //         'request_otp_code',
        //         'request_otp_expires'
        //     ]);

        //     return redirect('/request-item')
        //         ->with('error', 'OTP expired. Try again.');
        // }

        // // CHECK OTP
        // if ($request->otp != session('request_otp_code')) {
        //     return back()->with('error', 'Invalid OTP.');
        // }

        $result = $this->otpService->verify(
    auth()->user()->email,
    $request->otp,
    'request'
);

if (!$result['status']) {

    return back()->with(
        'error',
        $result['message']
    );

}

        $data = session('request_item_data');

        if (!$data) {
            return redirect('/request-item')
                ->with('error', 'Session expired.');
        }

        RequestItem::create([
            'reference_number' => 'REQ-' . strtoupper(Str::random(8)),
            'user_id' => auth()->id(),
            'item_id' => $data['item_id'],
            'quantity' => $data['quantity'],
            'purpose' => $data['purpose'],
            'fund_source' => $data['fund_source'],
            'request_location' => $data['request_location'],
            'status' => 'pending',
        ]);

        // session()->forget([
        //     'request_item_data',
        //     'request_otp_code',
        //     'request_otp_expires'
        // ]);

        session()->forget([
    'request_item_data'
]);

        return redirect('/my-requests')
            ->with('success', 'Request submitted successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | MY REQUESTS
    |--------------------------------------------------------------------------
    */
    public function myRequests()
    {
        $requests = RequestItem::with('item')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('user.requests', compact('requests'));
    }
    public function index(Request $request)
{
    $requests = RequestItem::with(['user', 'item']);

    // SEARCH
    if ($request->search) {
        $requests->where(function ($q) use ($request) {
            $q->where('reference_number', 'like', '%' . $request->search . '%')
              ->orWhere('status', 'like', '%' . $request->search . '%')
              ->orWhereHas('user', function ($u) use ($request) {
                  $u->where('name', 'like', '%' . $request->search . '%');
              })
              ->orWhereHas('item', function ($i) use ($request) {
                  $i->where('item_name', 'like', '%' . $request->search . '%');
              });
        });
    }

    // STATUS FILTER
    if ($request->status) {
        $requests->where('status', $request->status);
    }

    $requests = $requests->latest()->get();

    return view('request.index', compact('requests'));
}
/*
|--------------------------------------------------------------------------
| APPROVE
|--------------------------------------------------------------------------
*/

public function approve($id)
{
    $requestItem = RequestItem::findOrFail($id);

    $requestItem->status = 'approved';

    $requestItem->save();

    $requestItem->user->notify(

        new SystemNotification(

            'Your item request was approved.',

            '/my-requests'

        )

    );

    return back()->with(
        'success',
        'Request approved successfully.'
    );
}

/*
|--------------------------------------------------------------------------
| REJECT
|--------------------------------------------------------------------------
*/

public function reject($id)
{
    $requestItem = RequestItem::findOrFail($id);

    $requestItem->status = 'rejected';

    $requestItem->save();

    $requestItem->user->notify(

        new SystemNotification(

            'Your item request was rejected.',

            '/my-requests'

        )

    );

    return back()->with(
        'success',
        'Request rejected successfully.'
    );
}
public function archive()
{
    $requests = RequestItem::where(
        'is_archived',
        true
    )->latest()->get();

    return view(
        'archive.requests',
        compact('requests')
    );
}

public function releaseQueue()
{
    $requests = RequestItem::with([
        'user',
        'item'
    ])
    ->where('status', 'approved')
    ->where('release_status', 'pending')
    ->latest()
    ->get();

    return view(
        'custodian.requests',
        compact('requests')
    );
}

public function release($id)
{
    $requestItem = RequestItem::findOrFail($id);

    $requestItem->release_status = 'released';

    $requestItem->released_by = auth()->id();

    $requestItem->released_at = now();

    $requestItem->save();

    $requestItem->user->notify(

        new SystemNotification(

            'Your requested item is now ready for release.',

            '/my-requests'

        )

    );

    return back()->with(
        'success',
        'Item released successfully.'
    );
}
}