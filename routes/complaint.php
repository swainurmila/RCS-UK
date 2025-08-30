<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ComplaintVerificationController;
use App\Http\Middleware\Authenticate;


Route::middleware([Authenticate::class])->group(
    function () {
        Route::get('/submit', [ComplaintController::class, 'show_complaint'])->name('show.complaint');
        Route::get('/list', [ComplaintController::class, 'listing'])->name('listing.complaint');
        Route::post('/store', [ComplaintController::class, 'storeComplaint'])->name('complaint.store');
        Route::get('/get/compliant-list', [ComplaintController::class, 'getComplaintList'])->name('get.complaint.list');

        Route::post('/districts-by-division', [ComplaintController::class, 'getDistrictsByDivision'])->name('get-districts-by-division');
        Route::post('/subdivisions-by-district', [ComplaintController::class, 'getSubdivisionsByDistrict'])->name('get-subdivisions-by-district');
        Route::post('/blocks-by-district', [ComplaintController::class, 'getBlocksByDistrict'])->name('get-blocks-by-district');
        Route::post('/society-by-block', [ComplaintController::class, 'getSocietyByBlock'])->name('get-societies-by-block');

        Route::get('/dashboard', [ComplaintController::class, 'showDashboard'])->name('show.complaint-dashboard');
        Route::get('/get-users-by-role', [ComplaintController::class, 'getUsersByRole'])->name('get-users-by-role');
        Route::post('/create-committee-member', [ComplaintController::class, 'assignCommitteeMember'])->name('create-committee-member');
        Route::get('/get-committee-list', [ComplaintController::class, 'committeeList'])->name('complaint-assigned-to-committee');

        Route::post('/committee-take-action', [ComplaintVerificationController::class, 'commTakeAction'])->name('committee-take-action');
        Route::post('/resolution/store', [ComplaintVerificationController::class, 'finalResolution'])->name('resolution.store');
        Route::post('/forward/compaint', [ComplaintVerificationController::class, 'forwardcomplaintapp'])->name('forwardcomplaint.store');
        Route::post('/get-authorized-person-name', [ComplaintController::class, 'getAuthorizedPersonName'])->name('get.authorized.name');
        Route::post('/complaints/filter', [ComplaintController::class, 'filter'])->name('complaints.filter');
        Route::post('/forward-action-store', [ComplaintController::class, 'forwardAction'])->name('forward-action-store');
    }
);