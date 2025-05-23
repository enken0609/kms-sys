<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\RaceController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\CertificateTemplateController;

// 管理画面のルート
Route::prefix('admin')->name('admin.')->group(function () {
    // 認証不要のルート
    Route::middleware('guest')->group(function () {
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [LoginController::class, 'login']);
    });

    // 認証が必要なルート
    Route::middleware('auth')->group(function () {
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // レース管理
        Route::resource('races', RaceController::class);
        Route::post('races/{race}/import', [RaceController::class, 'import'])->name('races.import');

        // カテゴリー管理
        Route::resource('categories', CategoryController::class);
        Route::post('categories/{category}/import', [CategoryController::class, 'import'])->name('categories.import');
        Route::get('categories/{category}/csv-sample', [CategoryController::class, 'downloadCsvSample'])->name('categories.csv-sample');
        Route::delete('categories/{category}/results/{result}', [CategoryController::class, 'deleteResult'])->name('categories.results.delete');
        Route::delete('categories/{category}/results', [CategoryController::class, 'bulkDeleteResults'])->name('categories.results.bulk-delete');

        // 記録証テンプレート管理
        Route::resource('certificate-templates', CertificateTemplateController::class);
    });
});

// 公開ページのルート
Route::get('/', [App\Http\Controllers\PublicRaceController::class, 'index'])->name('home');
Route::get('/races', [App\Http\Controllers\PublicRaceController::class, 'index'])->name('public.races.index');
Route::get('/races/{race}', [App\Http\Controllers\PublicRaceController::class, 'showCategory'])->name('public.races.category');
Route::get('/races/{race}/{category}', [App\Http\Controllers\PublicRaceController::class, 'showResult'])->name('public.races.result');
Route::get('/races/{race}/download/{result}', [App\Http\Controllers\PublicRaceController::class, 'downloadCertificate'])->name('public.races.download');
