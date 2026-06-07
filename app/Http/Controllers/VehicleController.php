<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;

class VehicleController extends Controller
{
    // SHOW ALL VEHICLES
    public function index()
    {
        $vehicles = Vehicle::latest()->get();

        return view('admin.vehicles.index', compact('vehicles'));
    }

    // SHOW CREATE PAGE
    public function create()
    {
        return view('admin.vehicles.create');
    }

    // SAVE VEHICLE
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'plate_number' => 'required|string|max:255|unique:vehicles,plate_number',
            'type' => 'required|string|max:255',
            'status' => 'required',
        ]);

        Vehicle::create([
            'name' => $request->name,
            'plate_number' => $request->plate_number,
            'type' => $request->type,
            'status' => $request->status,
        ]);

        return redirect('/admin/vehicles')
            ->with('success', 'Vehicle added successfully');
    }

    // DELETE VEHICLE
    public function destroy($id)
    {
        $vehicle = Vehicle::findOrFail($id);

        $vehicle->delete();

        return back()->with('success', 'Vehicle deleted successfully');
    }
    public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required'
    ]);

    $vehicle = Vehicle::findOrFail($id);

    $vehicle->status = $request->status;

    $vehicle->save();

    return back()->with(
        'success',
        'Vehicle status updated successfully.'
    );
}
}