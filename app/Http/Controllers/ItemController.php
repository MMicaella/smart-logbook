<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();

        return view('items.index', compact('items'));
    }

    public function create()
    {
        return view('items.create');
    }

    /*
    |--------------------------------------------------------------------------
    | STORE ITEM
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $department = auth()->user()->department;

        /*
        |--------------------------------------------------------------------------
        | CHECK DEPARTMENT
        |--------------------------------------------------------------------------
        */

        if (!$department) {

            return back()->with(
                'error',
                'Your account has no department assigned.'
            );

        }

        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'item_name'        => 'required|string|max:255',
            'category'         => 'required|string|max:255',
            'brand_name'       => 'required|string|max:255',
            'quantity'         => 'required|integer|min:1',
            'description'      => 'nullable|string',

            // SERIAL NUMBERS ARRAY
            'serial_numbers'   => 'required|array',
            'serial_numbers.*' => 'required|string|max:255',

        ]);

        /*
        |--------------------------------------------------------------------------
        | SAVE ITEM
        |--------------------------------------------------------------------------
        */

        Item::create([

            'item_name'     => $request->item_name,
            'category'      => $request->category,
            'brand_name'    => $request->brand_name,

            // SAVE AS COMMA SEPARATED
            'serial_number' => implode(',', $request->serial_numbers),

            'quantity'      => $request->quantity,
            'description'   => $request->description,
            'department'    => $department,

        ]);

        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect('/custodian/inventory')
            ->with(
                'success',
                'Item added successfully.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT ITEM
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $item = Item::findOrFail($id);

        return view(
            'custodian.items.edit',
            compact('item')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE QUANTITY
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $request->validate([

            'quantity' => 'required|integer|min:0',

        ]);

        $item = Item::findOrFail($id);

        $item->update([

            'quantity' => $request->quantity,

        ]);

        return redirect('/custodian/inventory')
            ->with(
                'success',
                'Item quantity updated successfully.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW ITEM
    |--------------------------------------------------------------------------
    */

    public function show(Item $item)
    {
        return view(
            'custodian.items.show',
            compact('item')
        );
    }
}