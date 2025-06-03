<?php

namespace App\Http\Controllers;

use App\Models\Earthquake;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class EarthquakeController extends Controller
{
    // Admin: Full CRUD and print methods remain unchanged

    /**
     * Admin: Display a listing of earthquakes (full view).
     */
    public function index(Request $request)
    {
        $query = Earthquake::query();

        if ($request->filled('search')) {
            $query->where('location', 'like', '%' . $request->search . '%')
                  ->orWhere('intensity_scale', 'like', '%' . $request->search . '%');
        }

        $earthquakes = $query->orderBy('date', 'desc')->paginate(5);

        return view('earthquakes.index', compact('earthquakes'));
    }

    /**
     * User: Display a listing of earthquakes (read-only, user view).
     */
    public function userindex(Request $request)
    {
        $query = Earthquake::query();

        if ($request->filled('search')) {
            $query->where('location', 'like', '%' . $request->search . '%');
            // Optional: omit intensity search for users if preferred
        }

        $earthquakes = $query->orderBy('date', 'desc')->paginate(5);

        return view('user.earthquakes.index', compact('earthquakes'));
    }

    // The rest of your existing admin methods (create, store, edit, update, destroy, print) remain the same

    public function create()
    {
        return view("earthquakes.create");
    }

    public function store(Request $request)
    {
        Earthquake::create($request->all());
        return redirect()->route('earthquakes.index');
    }

    public function show(Earthquake $earthquake)
    {
        return redirect()->route('earthquakes.index');
    }

    public function edit(Earthquake $earthquake)
    {
        return view('earthquakes.edit', compact('earthquake'));
    }

    public function update(Request $request, Earthquake $earthquake)
    {
        $earthquake->update($request->all());
        return redirect()->route('earthquakes.index');
    }

    public function destroy(Earthquake $earthquake)
    {
        $earthquake->delete();

        return redirect()->route('earthquakes.index')
                         ->with('success', 'Earthquake deleted successfully.');
    }

    public function print()
    {
        $earthquakes = Earthquake::all();
        $pdf = Pdf::loadView('earthquakes.pdf', compact('earthquakes'));
        return $pdf->download('earthquakes_report.pdf');
    }
}
