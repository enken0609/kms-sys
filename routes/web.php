<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\RaceController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\CertificateTemplateController;
use App\Http\Controllers\PublicRaceController;

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
Route::get('/', [PublicRaceController::class, 'index'])->name('home');

Route::name('public.races.')->group(function () {
    Route::get('/races', [PublicRaceController::class, 'index'])->name('index');
    Route::get('/races/{race}/categories', [PublicRaceController::class, 'showCategory'])->name('category');
    Route::get('/races/{race}/categories/{category}', [PublicRaceController::class, 'showResult'])->name('result');
    Route::get('/races/{race}/results/{result}/download', [PublicRaceController::class, 'downloadCertificate'])->name('download-certificate');
});
