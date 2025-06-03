<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DisasterReport;
use App\Models\Earthquake;
use App\Models\Wind;
use Barryvdh\DomPDF\Facade\Pdf;

class DisasterReportController extends Controller
{
    /**
     * Display a listing of the disaster reports with search and pagination.
     */
    public function index(Request $request)
    {
        $query = DisasterReport::query();

        // Filter by date if provided
        if ($request->filled('search_date')) {
            $query->whereDate('date', $request->search_date);
        }

        // Filter by location if provided
        if ($request->filled('search_location')) {
            $query->where('location', 'like', '%' . $request->search_location . '%');
        }

        $reports = $query->orderBy('date', 'desc')->paginate(5);

        return view('disaster_reports.index', compact('reports'));
    }


    /**
     * Show the form for creating a new disaster report.
     */
    public function create()
    {
        $earthquakes = Earthquake::all();
        $winds = Wind::all();

        return view('disaster_reports.create', compact('earthquakes', 'winds'));
    }

    /**
     * Store a newly created disaster report in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'disaster_id' => 'required|integer',
            'disaster_type' => 'required|in:earthquake,wind',
            'date' => 'required|date',
            'location' => 'required|string',
            'damage_status' => 'required|in:Minimal,Moderate,Severe,Worst,Catastrophic'
        ]);

        DisasterReport::create($request->all());

        return redirect()->route('disaster_reports.index')
                         ->with('success', 'Disaster report added successfully.');
    }

    /**
     * Generate PDF report of all disaster reports.
     */
    public function print()
    {
        $reports = DisasterReport::all();
        $pdf = Pdf::loadView('disaster_reports.pdf', compact('reports'));
        return $pdf->download('disaster_reports.pdf');
    }
}
