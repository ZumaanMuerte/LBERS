<?php

namespace App\Http\Controllers;

use App\Models\Earthquake;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class EarthquakeController extends Controller
{
    /**
     * Display a listing of the resource.
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view("earthquakes.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        Earthquake::create($request->all());
        return redirect()->route('earthquakes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Earthquake $earthquake)
    {
        return redirect()->route('earthquakes.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Earthquake $earthquake)
    {
        //
        return view('earthquakes.edit', compact('earthquake'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Earthquake $earthquake)
    {
        //
        $earthquake->update($request->all());
        return redirect()->route('earthquakes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
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
