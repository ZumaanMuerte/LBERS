<?php

namespace App\Http\Controllers;

use App\Models\Wind;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class WindController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = Wind::query();

    if ($request->filled('search')) {
        $query->where('location', 'like', '%' . $request->search . '%')
              ->orWhere('wind_signal', 'like', '%' . $request->search . '%');
    }

    $winds = $query->orderBy('date', 'desc')->paginate(5);

    return view('winds.index', compact('winds'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('winds.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        Wind::create($request->all());
        return redirect()->route('winds.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Wind $wind)
    {
        return redirect()->route('winds.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wind $wind)
    {
        //
        return view('winds.edit', compact('wind'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wind $wind)
    {
        //
        $wind->update($request->all());
        return redirect()->route('winds.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wind $wind)
    {
        $wind->delete();

        return redirect()->route('winds.index')
                        ->with('success', 'Wind report deleted successfully.');
    }


    public function exportPdf(Request $request)
    {
        $winds = Wind::orderBy('id')->get();

        $pdf = Pdf::loadView('winds.pdf', compact('winds'))
                ->setPaper('a4', 'landscape');

        return $pdf->download('wind-records.pdf');
    }
    //generatePDF
}
