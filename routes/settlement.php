<?php

use App\Http\Controllers\Settlement\SettlementController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Authenticate;


Route::middleware([Authenticate::class])->group(
    function () {
        Route::get('/dashboard', [SettlementController::class, 'showDashboard'])->name('show.settlement-dashboard');
        Route::get('/add-settlement', [SettlementController::class, 'addSettlement'])->name('add-settlement');
        Route::post('/settlement-store', [SettlementController::class, 'settlementStore'])->name('settlement-store');
        Route::post('/save-arbitration-application', [SettlementController::class, 'saveApplication'])->name('save.arbitration.application');



        /*Route::get('/list', [ComplaintController::class, 'listing'])->name('listing.complaint');
        Route::post('/store', [ComplaintController::class, 'storeComplaint'])->name('complaint.store');
        Route::get('/get/compliant-list', [ComplaintController::class, 'getComplaintList'])->name('get.complaint.list'); */



        /* Route::get('/get-users-by-role', [ComplaintController::class, 'getUsersByRole'])->name('get-users-by-role');
        Route::post('/create-committee-member', [ComplaintController::class, 'assignCommitteeMember'])->name('create-committee-member');
        Route::get('/get-committee-list', [ComplaintController::class, 'committeeList'])->name('complaint-assigned-to-committee'); */

        /* Route::post('/committee-take-action', [ComplaintVerificationController::class, 'commTakeAction'])->name('committee-take-action');
        Route::post('/resolution/store', [ComplaintVerificationController::class, 'finalResolution'])->name('resolution.store');
        Route::post('/forward/compaint', [ComplaintVerificationController::class, 'forwardcomplaintapp'])->name('forwardcomplaint.store');
        Route::post('/get-authorized-person-name', [ComplaintController::class, 'getAuthorizedPersonName'])->name('get.authorized.name');
        Route::post('/complaints/filter', [ComplaintController::class, 'filter'])->name('complaints.filter'); */
    }
);