<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrow;
use App\Models\Item;
use App\Models\RequestItem;


class CustodianController extends Controller
{
    // DASHBOARD
//     public function index()
// {
//     $department = auth()->user()->department;

//     $borrows = Borrow::with(['user', 'item'])
//         ->whereHas('item', function ($q) use ($department) {
//             $q->where('department', $department);
//         })
//         ->where(function ($q) {

//             $q->where('status', 'approved')
//               ->orWhere('return_status', 'released')
//               ->orWhere('return_status', 'returned');

//         })
//         ->latest()
//         ->get();

//     return view('custodian.dashboard', compact('borrows'));
// }

public function index(Request $request)
{
    $department = auth()->user()->department;

    $query = Borrow::with(['user', 'item'])

        ->whereHas('item', function ($q) use ($department) {
            $q->where('department', $department);
        })

        ->where(function ($q) {

            $q->where('status', 'approved')
              ->orWhere('return_status', 'released')
              ->orWhere('return_status', 'returned');

        });

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

    if ($request->status == 'approved') {

        // READY FOR RELEASE
        $query->where('status', 'approved')
              ->where('return_status', 'borrowed');

    } elseif ($request->status == 'released') {

        $query->where('return_status', 'released');

    } elseif ($request->status == 'returned') {

        $query->where('return_status', 'returned');

    }

}

    $borrows = $query
    ->latest()
    ->paginate(5)
    ->withQueryString();

    return view(
        'custodian.dashboard',
        compact('borrows')
    );
}

    // RELEASE ITEM
    // public function release($id)
    // {
    //     $borrow = Borrow::findOrFail($id);

    //     $borrow->return_status = 'released';
    //     $borrow->save();

    //     return back()->with('success', 'Item released');
    // }
// public function release(Request $request, $id)
// {
//     $borrow = Borrow::findOrFail($id);

//     $borrow->update([
//         'status' => 'released',
//         'released_brand' => $request->brand_name,
//         'released_serial' => $request->serial_number,
//         'remarks' => $request->remarks,
//         'released_by' => auth()->id(),
//     ]);

//     return redirect('/custodian/borrowings')
//         ->with('success', 'Item successfully released');
// }

// public function release(Request $request, $id)
// {
//     $borrow = Borrow::findOrFail($id);

//     $request->validate([
//         'brand_name' => 'required',
//         'serial_numbers' => 'required|array',
//         'remarks' => 'nullable'
//     ]);

//     $borrow->brand_name = $request->brand_name;

//     // SAVE MULTIPLE SERIALS
//     $borrow->serial_number = json_encode($request->serial_numbers);

//     $borrow->remarks = $request->remarks;

//     $borrow->return_status = 'released';

//     $borrow->released_at = now();

//     $borrow->save();

//     return redirect('/custodian/dashboard')
//         ->back()
//         ->with('success', 'Item released successfully.');
// }
    // RETURN ITEM
    public function returnItem($id)
    {
        $borrow = Borrow::findOrFail($id);

        $borrow->return_status = 'returned';
        $borrow->returned_at = now();
        $borrow->save();

        // restore stock
        $item = Item::findOrFail($borrow->item_id);
        $item->quantity += $borrow->quantity;
        $item->save();

        return back()->with('success', 'Item returned');
    }

    // INVENTORY
//     public function inventory()
// {
//     $items = Item::all();

//     $lowStock = Item::where('quantity', '<=', 5)->count();
//     $totalItems = Item::count();

//     $mostBorrowed = \App\Models\Borrow::select('item_id')
//         ->selectRaw('COUNT(*) as total')
//         ->groupBy('item_id')
//         ->orderByDesc('total')
//         ->with('item')
//         ->limit(5)
//         ->get();

//     return view('custodian.inventory', compact(
//         'items',
//         'lowStock',
//         'totalItems',
//         'mostBorrowed'
//     ));
// }

public function inventory()
{
    $department = auth()->user()->department;

    // ONLY ITEMS FROM THIS CUSTODIAN'S DEPARTMENT
    $items = Item::where('department', $department)->get();

    $lowStock = Item::where('department', $department)
        ->where('quantity', '<=', 5)
        ->count();

    $totalItems = Item::where('department', $department)->count();

    $mostBorrowed = \App\Models\Borrow::select('item_id')
        ->selectRaw('COUNT(*) as total')
        ->whereHas('item', function ($q) use ($department) {
            $q->where('department', $department);
        })
        ->groupBy('item_id')
        ->orderByDesc('total')
        ->with('item')
        ->limit(5)
        ->get();

    return view('custodian.inventory', compact(
        'items',
        'lowStock',
        'totalItems',
        'mostBorrowed'
    ));
}

    // VERIFY PAGE
    public function verifyPage()
    {
        return view('custodian.verify');
    }

    // VERIFY LOGIC
    public function verify(Request $request)
    {
        $borrow = Borrow::where('reference_number', $request->reference)->first();

        if (!$borrow) {
            return back()->with('error', 'Invalid reference');
        }

        return view('custodian.verify-result', compact('borrow'));
    }
    public function overview()
{
    $borrowed = \App\Models\Borrow::where('return_status', 'borrowed')->count();
    $released = \App\Models\Borrow::where('return_status', 'released')->count();
    $returned = \App\Models\Borrow::where('return_status', 'returned')->count();

    $overdue = \App\Models\Borrow::where('return_status', 'released')
        ->where('created_at', '<', now()->subDays(3))
        ->count();

    return view('custodian.overview', compact(
        'borrowed',
        'released',
        'returned',
        'overdue'
    ));
}

public function lowStock()
{
    $department = auth()->user()->department;

    $items = Item::where('department', $department)
        ->where('quantity', '<=', 5)
        ->get();

    return view('custodian.low-stock', compact('items'));
}
public function releaseForm($id)
{
    $borrow = Borrow::with('item', 'user')->findOrFail($id);

    return view('custodian.borrowings.release', compact('borrow'));
}

public function showRelease($id)
{
    $borrow = Borrow::with('item', 'user')
        ->findOrFail($id);

    return view('custodian.release-item', compact('borrow'));
}

// public function releaseItem(Request $request, $id)
// {
//     $borrow = \App\Models\Borrow::findOrFail($id);

//     $request->validate([
//         'serial_number' => 'required',
//         'remarks' => 'required',
//     ]);

//     // SAVE RELEASE INFO
//     $borrow->released_serial_number = $request->serial_number;
//     $borrow->remarks = $request->remarks;

//     // STATUS
//     $borrow->return_status = 'released';

//     $borrow->released_at = now();

//     $borrow->save();

//     return redirect('/custodian/dashboard')
//         ->with('success', 'Item released successfully.');
// }
public function releaseItem(Request $request, $id)
{
    $borrow = Borrow::findOrFail($id);

    $request->validate([
        'brand_name' => 'required|string|max:255',
        'serial_numbers' => 'required|array',
        'serial_numbers.*' => 'required|string|max:255',
        'remarks' => 'nullable|string'
    ]);

    // SAVE BRAND
    $borrow->brand_name = $request->brand_name;

    // SAVE MULTIPLE SERIAL NUMBERS
    $borrow->serial_number = json_encode($request->serial_numbers);

    // SAVE REMARKS
    $borrow->remarks = $request->remarks;

    // STATUS
    $borrow->status = 'released';
    $borrow->return_status = 'released';

    // RELEASE DATE
    $borrow->released_at = now();

    if ($borrow->request_location === 'outside') {

    $qrData =
        "REF: {$borrow->reference_number} | " .
        "ITEM: {$borrow->item->item_name} | " .
        "QTY: {$borrow->quantity}";

    $borrow->qr_code = base64_encode(
        \SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)
            ->generate($qrData)
    );
}

    $borrow->save();

    return redirect('/custodian')
        ->with('success', 'Item released successfully.');
}

public function releaseList()
{
    $requests = RequestItem::with([
        'user',
        'item'
    ])
    ->where('status', 'approved')
    ->where(function ($q) {
        $q->whereNull('release_status')
          ->orWhere('release_status', 'pending');
    })
    ->latest()
    ->get();

    return view(
        'custodian.request-release',
        compact('requests')
    );
}
}