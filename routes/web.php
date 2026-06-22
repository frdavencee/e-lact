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
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DocumentController;
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

        Route::get('foto', [LokasiController::class, 'foto'])->name('lokasi.foto');
        Route::post('foto', [FotoLampiranController::class, 'store'])->name('foto.store');
        Route::delete('foto/{foto}', [FotoLampiranController::class, 'destroy'])->name('foto.destroy');

        Route::get('opm', [LokasiController::class, 'opm'])->name('lokasi.opm');
        Route::post('opm', [OpMController::class, 'store'])->name('opm.store');
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
        Route::delete('marking-kabel/{markingKabel}', [MarkingKabelController::class, 'destroy'])->name('marking-kabel.destroy');
    });

    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/create', [ReportController::class, 'create'])->name('reports.create');
    Route::post('reports', [ReportController::class, 'store'])->name('reports.store');
    Route::get('reports/{report}', [ReportController::class, 'show'])->name('reports.show');
    Route::get('reports/{report}/edit', [ReportController::class, 'edit'])->name('reports.edit');
    Route::put('reports/{report}', [ReportController::class, 'update'])->name('reports.update');
    Route::delete('reports/{report}', [ReportController::class, 'destroy'])->name('reports.destroy');

    Route::get('documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::post('documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::get('documents/{document}', [DocumentController::class, 'show'])->name('documents.show');
    Route::delete('documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');
    Route::get('documents/{lokasi}/commissioning', [DocumentController::class, 'commissioning'])->name('documents.commissioning');
    Route::get('documents/{lokasi}/boq', [DocumentController::class, 'boq'])->name('documents.boq');
    Route::get('documents/{lokasi}/evidence-pekerjaan', [DocumentController::class, 'evidencePekerjaan'])->name('documents.evidence-pekerjaan');
    Route::get('documents/{lokasi}/marking-kabel', [DocumentController::class, 'markingKabel'])->name('documents.marking-kabel');
    Route::get('documents/{lokasi}/evidence-odp', [DocumentController::class, 'evidenceOdp'])->name('documents.evidence-odp');
    Route::get('documents/{lokasi}/evidence-aksesoris', [DocumentController::class, 'evidenceAksesoris'])->name('documents.evidence-aksesoris');
    Route::get('documents/{lokasi}/evidence-closure', [DocumentController::class, 'evidenceClosure'])->name('documents.evidence-closure');
    Route::get('documents/{lokasi}/evidence-opm', [DocumentController::class, 'evidenceOpm'])->name('documents.evidence-opm');
    Route::get('documents/{lokasi}/otdr', [DocumentController::class, 'otdr'])->name('documents.otdr');
    Route::get('documents/{lokasi}/mancore', [DocumentController::class, 'mancore'])->name('documents.mancore');
    Route::get('documents/{lokasi}/abd', [DocumentController::class, 'abd'])->name('documents.abd');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

require __DIR__.'/auth.php';
