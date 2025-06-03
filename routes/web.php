<?php

use App\Http\Controllers\AccountRoleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EarthquakeController;
use App\Http\Controllers\DisasterReportController;
use App\Http\Controllers\WindController;

// 1) Public “welcome” (unauthenticated) page
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// 2) Catch‐all “/dashboard” that delegates to the role‐specific dashboard
Route::get('/dashboard', function () {
    $user = Auth::user();
    switch ($user->role) {
        case 'admin':
            return redirect()->route('admin.dashboard');
        case 'staff':
            return redirect()->route('staff.dashboard');
        default:
            return redirect()->route('user.dashboard');
    }
})->middleware(['auth'])->name('dashboard');

// (3) Actual role‐specific pages (named EXACTLY as we reference them in Blade)
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth'])->name('admin.dashboard');

Route::get('/staff/dashboard', function () {
    return view('staff.dashboard');
})->middleware(['auth'])->name('staff.dashboard');

// 4) (Your other authenticated routes)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class,'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class,'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class,'destroy'])->name('profile.destroy');
});

// Earthquakes
Route::get('/earthquakes', [EarthquakeController::class, 'userindex'])->name('user.earthquakes.index');
Route::get('earthquakes/print', [EarthquakeController::class,'print'])->name('earthquakes.print');
Route::resource('earthquakes', EarthquakeController::class);

Route::resource('accountroles', AccountRoleController::class);

// Winds
Route::get('/winds', [WindController::class, 'userindex'])->name('winds.index');
Route::get('winds/print', [WindController::class,'print'])->name('winds.print');
Route::resource('winds', WindController::class);


// Disaster Reports
Route::get('disaster_reports/print', [DisasterReportController::class,'print'])->name('disaster_reports.print');
Route::resource('disaster_reports', DisasterReportController::class);

Route::prefix('user')->middleware(['auth'])->name('user.')->group(function () {
    // User dashboard view
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('dashboard');

    // User specific routes for earthquakes and winds
    Route::get('/earthquakes', [EarthquakeController::class, 'userindex'])->name('earthquakes.index');
    Route::get('/winds', [WindController::class, 'userindex'])->name('winds.index');

    // If you want users to have access to other actions, define those routes explicitly or create a resource with limited methods.
});
require __DIR__.'/auth.php';
