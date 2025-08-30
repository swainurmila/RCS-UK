<?php

use App\Http\Controllers\ElectionController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Authenticate;
use App\Models\NominationDocument;

Route::middleware([Authenticate::class])->group(
    function () {

        Route::get('election-register', [ElectionController::class, 'show'])->name('election.show');
        Route::get('/dashboard', [ElectionController::class, 'showDashboard'])->name('show.election-dashboard');
        Route::post('/election-store', [ElectionController::class, 'electionregister'])->name('election.nomination.save');
        Route::get('/nomination/{id}/edit', [ElectionController::class, 'edit'])->name('nominations.edit');

        Route::get('/nominations', [ElectionController::class, 'index'])->name('nominations.index');
        Route::get('/election-list', [ElectionController::class, 'electionList'])->name('election.list');
        Route::post('/election-list/date/{id}', [ElectionController::class, 'assignElectionDate']);
        Route::post('/election-list/assign-admin/{id}', [ElectionController::class, 'assignAdministrator']);
        // Route::post('/election-list/document-status/{id}', [ElectionController::class, 'updateDocumentStatus']);
        Route::get('/election-list/documents/{id}', [ElectionController::class, 'viewDocuments']);
        Route::get('/nomination/{id}/remark', [ElectionController::class, 'remark'])->name('nomination.remark');
        Route::post('/nomination/{id}/approve', [ElectionController::class, 'approve'])->name('nomination.approve');
        Route::post('/election-list/document-status/{id}', [ElectionController::class, 'updateDocumentStatus'])->name('/election-list/document-status/{id}');
        Route::post('/election-list/upload-certificate/{id}', [ElectionController::class, 'uploadCompletionCertificate']);
    }
);
