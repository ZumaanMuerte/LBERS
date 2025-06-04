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

    // Your existing filters here...
    $query->whereNotNull('damage_status')
          ->where('damage_status', '!=', '')
          ->whereNotNull('damage_report')
          ->where('damage_report', '!=', '');

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('disaster_type', 'like', "%{$search}%")
              ->orWhere('damage_status', 'like', "%{$search}%");
        });
    }

    $sortableColumns = ['disaster_type', 'date', 'damage_status', 'reported_at', 'reporter']; // note: use 'reported_at' not 'reported_by'
    $sortBy = $request->get('sortBy', 'date');
    $sortOrder = $request->get('sortOrder', 'desc');

    if (!in_array($sortBy, $sortableColumns)) {
        $sortBy = 'date';
    }

    // If sorting by reporter, need to join or order differently
    if ($sortBy == 'reporter') {
        // Assuming reporter relationship is loaded; fallback to sorting by reporter name
        $query->with('reporter')->get()->sortBy(function($report) {
            return $report->reporter->name ?? '';
        });
        // But paginate with collection is tricky; simpler way is to sort client-side or implement join in query for sorting.
        // For now, let's ignore server sorting on reporter.
    } else {
        $query->orderBy($sortBy, $sortOrder);
    }

    $reports = $query->paginate(5)->withQueryString();

    // Pass variables to view
    return view('disaster_reports.index', compact('reports', 'sortBy', 'sortOrder'));
}


    public function update(Request $request, DisasterReport $report)
    {
        $request->validate([
            'damage_status' => 'required|in:Minimal,Moderate,Severe,Worst,Catastrophic',
            'damage_report' => 'required|string|max:255',
        ]);

        $report->update([
            'damage_status' => $request->damage_status,
            'damage_report' => $request->damage_report,
            'reported_by' => auth()->id(),
            'reported_at' => now(),
        ]);

        return redirect()->route('disaster_reports.index')->with('success', 'Report updated successfully.');
    }

    public function destroy(DisasterReport $report)
    {
        $report->delete();

        return redirect()->route('disaster_reports.index')->with('success', 'Report deleted successfully.');
    }

    public function create()
    {
        $earthquakes = Earthquake::all();
        $winds = Wind::all();

        return view('disaster_reports.create', compact('earthquakes', 'winds'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'disaster_id' => 'required|integer',
            'disaster_type' => 'required|in:earthquake,wind',
            'date' => 'required|date',
            'location' => 'required|string',
            'damage_status' => 'required|in:Minimal,Moderate,Severe,Worst,Catastrophic',
        ]);

        DisasterReport::create($request->all());

        return redirect()->route('disaster_reports.index')
                         ->with('success', 'Disaster report added successfully.');
    }


    public function print()
    {
        $reports = DisasterReport::all();
        $pdf = Pdf::loadView('disaster_reports.pdf', compact('reports'));
        return $pdf->download('disaster_reports.pdf');
    }


    public function showDisastersForReporting()
    {
        $reportedDisasterIds = DisasterReport::where('reported_by', auth()->id())
            ->pluck('disaster_id')->toArray();

        $earthquakes = Earthquake::whereNotIn('id', $reportedDisasterIds)->get();
        $winds = Wind::whereNotIn('id', $reportedDisasterIds)->get();

        return view('staff.disasters', compact('earthquakes', 'winds'));
    }

    public function submitReport(Request $request, $disasterType, $disasterId)
    {
        $request->validate([
            'damage_status' => 'required|in:Minimal,Moderate,Severe,Worst,Catastrophic',
            'damage_report' => 'required|string|max:255',
        ]);

        $disasterModel = $disasterType === 'earthquake' ? Earthquake::class : Wind::class;
        $disaster = $disasterModel::findOrFail($disasterId);

        DisasterReport::create([
            'disaster_id' => $disasterId,
            'disaster_type' => $disasterType,
            'date' => $disaster->date,
            'location' => $disaster->location,
            'damage_status' => $request->damage_status,
            'damage_report' => $request->damage_report,
            'reported_by' => auth()->id(),
            'reported_at' => now(),
        ]);

        return redirect()->route('staff.reports')->with('success', 'Report submitted successfully.');
    }

    public function showSubmittedReports()
    {
        $reports = DisasterReport::where('reported_by', auth()->id())
            ->with('reporter')
            ->orderBy('reported_at', 'desc')
            ->paginate(10);

        return view('staff.submitted_reports', compact('reports'));
    }
        public function adminReports()
    {
        $reports = DisasterReport::with('reporter')
            ->orderBy('reported_at', 'desc')
            ->paginate(15);

        return view('admin.disaster_reports', compact('reports'));
    }

}
