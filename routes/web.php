<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\BoqController;
use App\Http\Controllers\CommissioningTestController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FotoLampiranController;
use App\Http\Controllers\GenerateDocxController;
use App\Http\Controllers\GeneratePdfController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\MarkingKabelController;
use App\Http\Controllers\OpMController;
use App\Http\Controllers\OtdrController;
use App\Http\Controllers\WaspangController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\BranchController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified', 'role:admin,petugas'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('users', UserController::class)->middleware('role:admin');
    Route::resource('waspang', WaspangController::class);
    Route::resource('lokasi', LokasiController::class);
    Route::get('lokasi/{lokasi}/generate', [GenerateDocxController::class, 'generate'])->name('lokasi.generate');
    Route::get('lokasi/{lokasi}/generate-pdf', [GeneratePdfController::class, 'generate'])->name('lokasi.generate.pdf');
    Route::resource('approvals', ApprovalController::class)->only(['index', 'show']);
    Route::post('approvals/{approval}/approve', [ApprovalController::class, 'approve'])->name('approvals.approve');
    Route::post('approvals/{approval}/reject', [ApprovalController::class, 'reject'])->name('approvals.reject');
    Route::post('approvals', [ApprovalController::class, 'store'])->name('approvals.store');

    Route::prefix('lokasi/{lokasi}')->group(function () {
        Route::get('commissioning', [LokasiController::class, 'commissioning'])->name('lokasi.commissioning');
        Route::post('commissioning-test', [CommissioningTestController::class, 'store'])->name('commissioning-test.store');
        Route::put('commissioning-test', [CommissioningTestController::class, 'update'])->name('commissioning-test.update');
        Route::delete('commissioning-test', [CommissioningTestController::class, 'destroy'])->name('commissioning-test.destroy');
        Route::delete('commissioning-test/image/{image}', [CommissioningTestController::class, 'destroyImage'])->name('commissioning-test.image.destroy');

        Route::get('foto', [LokasiController::class, 'foto'])->name('lokasi.foto');
        Route::post('foto', [FotoLampiranController::class, 'store'])->name('foto.store');
        Route::put('foto/{foto}/label', [FotoLampiranController::class, 'updateLabel'])->name('foto.label');
        Route::delete('foto/{foto}', [FotoLampiranController::class, 'destroy'])->name('foto.destroy');

        Route::get('opm', [LokasiController::class, 'opm'])->name('lokasi.opm');
        Route::post('opm', [OpMController::class, 'store'])->name('opm.store');
        Route::put('opm', [OpMController::class, 'bulkUpdate'])->name('opm.bulk-update');
        Route::put('opm/{opmRecord}', [OpMController::class, 'update'])->name('opm.update');
        Route::delete('opm/{opmRecord}', [OpMController::class, 'destroy'])->name('opm.destroy');

        Route::get('otdr', [LokasiController::class, 'otdr'])->name('lokasi.otdr');
        Route::post('otdr', [OtdrController::class, 'store'])->name('otdr.store');
        Route::delete('otdr/{otdrFile}', [OtdrController::class, 'destroy'])->name('otdr.destroy');

        Route::get('boq', [BoqController::class, 'index'])->name('boq.index');
        Route::post('boq', [BoqController::class, 'store'])->name('boq.store');
        Route::put('boq/{boq}', [BoqController::class, 'update'])->name('boq.update');
        Route::delete('boq/{boq}', [BoqController::class, 'destroy'])->name('boq.destroy');

        Route::get('marking-kabel', [LokasiController::class, 'marking'])->name('lokasi.marking');
        Route::post('marking-kabel', [MarkingKabelController::class, 'store'])->name('marking-kabel.store');
        Route::put('marking-kabel', [MarkingKabelController::class, 'bulkUpdate'])->name('marking-kabel.bulk-update');
        Route::put('marking-kabel/{markingKabel}/label', [MarkingKabelController::class, 'updateLabel'])->name('marking-kabel.label');
        Route::delete('marking-kabel/{markingKabel}', [MarkingKabelController::class, 'destroy'])->name('marking-kabel.destroy');

        Route::post('project', [ProjectController::class, 'store'])->name('project.store');
        Route::put('project/{project}', [ProjectController::class, 'update'])->name('project.update');
    });

    Route::get('documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::post('documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::get('documents/{document}', [DocumentController::class, 'show'])->name('documents.show');
    Route::delete('documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings/logo', [SettingsController::class, 'uploadLogo'])->name('settings.logo');

    Route::get('branch', [BranchController::class, 'index'])->name('branch.index');
    Route::post('branch', [BranchController::class, 'store'])->name('branch.store');
    Route::put('branch/{branch}', [BranchController::class, 'update'])->name('branch.update');
    Route::delete('branch/{branch}', [BranchController::class, 'destroy'])->name('branch.destroy');
});

require __DIR__.'/auth.php';
