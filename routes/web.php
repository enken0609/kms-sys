<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\PublicRaceController::class, 'index'])->name('public.races.index');

// Public routes for race results
Route::get('/races', [App\Http\Controllers\PublicRaceController::class, 'index'])->name('public.races.index');
Route::get('/races/{race}', [App\Http\Controllers\PublicRaceController::class, 'showCategory'])->name('public.races.category');
Route::get('/races/{race}/{category}', [App\Http\Controllers\PublicRaceController::class, 'showResult'])->name('public.races.result');
Route::get('/races/{race}/download/{result}', [App\Http\Controllers\PublicRaceController::class, 'downloadCertificate'])->name('public.races.download');

// Route::get('/public/races/{race}/categories/{category}', [App\Http\Controllers\PublicRaceController::class, 'showCategory'])->name('public.races.categories.show');
// Route::get('/public/category/{category}/results', [App\Http\Controllers\ResultController::class, 'index'])->name('public.results.index');
// Route::get('/public/races/{race}/{category}/leaderboard', [App\Http\Controllers\PublicRaceController::class, 'leaderboard'])->name('public.leaderboard');
// Route::get('/public/races/{race}/{category}/result', [App\Http\Controllers\PublicRaceController::class, 'result'])->name('public.result');
// Route::get('/public/category/{category}/result', [App\Http\Controllers\ResultController::class, 'result'])->name('public.result.index');
// Route::get('/public/result/{category}/result/{result}/download', [App\Http\Controllers\ResultController::class, 'downloadCertificate'])->name('public.result.download');


// Route::middleware(['auth'])->prefix('dashboard')->group(function () {
//     Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//     Route::get('/race/list', [App\Http\Controllers\RaceController::class, 'index'])->name('admin.race.list');
//     Route::get('/race/create', [App\Http\Controllers\RaceController::class, 'create'])->name('admin.race.create');
//     Route::post('/race/store', [App\Http\Controllers\RaceController::class, 'store'])->name('admin.race.store');
//     Route::get('/race/edit/{race}', [App\Http\Controllers\RaceController::class, 'edit'])->name('admin.race.edit');
//     Route::put('/race/update/{race}', [App\Http\Controllers\RaceController::class, 'update'])->name('admin.race.update');
//     Route::delete('/race/destroy/{race}', [App\Http\Controllers\RaceController::class, 'destroy'])->name('admin.race.destroy');

//     Route::get('/race/{race}/categories', [App\Http\Controllers\CategoryController::class, 'index'])->name('admin.category.index');
//     Route::get('/race/{race}/categories/{category}/result', [App\Http\Controllers\CategoryController::class, 'result'])->name('admin.category.result');
//     Route::get('/race/{race}/categories/{category}/downloadCertificate/{result}', [App\Http\Controllers\CategoryController::class, 'downloadCertificate'])->name('admin.category.downloadCertificate');
//     Route::post('/race/{race}/categories/{category}/downloadCertificate/{result}/{award_place}/{award_place_count}/{overall_count}', [App\Http\Controllers\CategoryController::class, 'downloadCertificate'])->name('admin.category.downloadCertificate');

//     Route::get('/manual-print', [App\Http\Controllers\CategoryController::class, 'manualPrintForm'])->name('admin.manual.print.form');
//     Route::post('/manual-print', [App\Http\Controllers\CategoryController::class, 'manualPrint'])->name('admin.manual.print');
//     Route::post('/auto-print', [App\Http\Controllers\CategoryController::class, 'autoPrint'])->name('admin.auto.print');

//     Route::get('/race/{race}/categories/create', [App\Http\Controllers\CategoryController::class, 'create'])->name('admin.category.create');
//     Route::post('/race/{race}/categories/store', [App\Http\Controllers\CategoryController::class, 'store'])->name('admin.category.store');
//     Route::get('/race/{race}/categories/edit/{category}', [App\Http\Controllers\CategoryController::class, 'edit'])->name('admin.category.edit');
//     Route::put('/race/{race}/categories/update/{category}', [App\Http\Controllers\CategoryController::class, 'update'])->name('admin.category.update');
//     Route::delete('/race/{race}/categories/destroy/{category}', [App\Http\Controllers\CategoryController::class, 'destroy'])->name('admin.category.destroy');
//     Route::post('/race/{race}/category/update_results/{category}', [App\Http\Controllers\CategoryController::class, 'updateResults'])->name('admin.category.update_results');

//     // Entry routes
//     Route::get('/race/{race}/entries', [App\Http\Controllers\EntryController::class, 'index'])->name('admin.entry.index');
//     Route::get('/race/{race}/entries/create', [App\Http\Controllers\EntryController::class, 'create'])->name('admin.entry.create');
//     Route::post('/race/{race}/entries/store', [App\Http\Controllers\EntryController::class, 'store'])->name('admin.entry.store');
//     Route::get('/race/{race}/entries/edit/{entry}', [App\Http\Controllers\EntryController::class, 'edit'])->name('admin.entry.edit');
//     Route::put('/race/{race}/entries/update/{entry}', [App\Http\Controllers\EntryController::class, 'update'])->name('admin.entry.update');
//     Route::delete('/race/{race}/entries/destroy/{entry}', [App\Http\Controllers\EntryController::class, 'destroy'])->name('admin.entry.destroy');

//     // Import routes
//     Route::get('/race/{race}/entries/import', [App\Http\Controllers\EntryImportController::class, 'showImportForm'])->name('admin.entry.import.form');
//     Route::post('/race/{race}/entries/import', [App\Http\Controllers\EntryImportController::class, 'import'])->name('admin.entry.import');
// });
