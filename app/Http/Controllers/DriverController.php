<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;

class DriverController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SHOW DRIVERS
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $drivers = Driver::all();

        return view('admin.drivers.index', compact('drivers'));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE PAGE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('admin.drivers.create');
    }

    /*
    |--------------------------------------------------------------------------
    | STORE DRIVER
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'license_number' => 'required',
            'contact_number' => 'required',
            'status' => 'required',
        ]);

        Driver::create([
            'name' => $request->name,
            'license_number' => $request->license_number,
            'contact_number' => $request->contact_number,
            'status' => $request->status,
        ]);

        return redirect('/admin/drivers')
            ->with('success', 'Driver added successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE DRIVER
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $driver = Driver::findOrFail($id);

        $driver->delete();

        return back()->with('success', 'Driver deleted.');
    }
}