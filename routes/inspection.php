<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InspectionController;
use App\Http\Controllers\InquiryController;


Route::get('/dashboard', [InspectionController::class, 'show_dashboard'])->name('inspection_dashboard.show');
// Route::get('/details/{id}', [AmendmentController::class, 'amendment_details'])->name('show.ablm_details');
// Route::get('/BylawsMaster', [AmendmentController::class, 'show'])->name('amendment.show');
// Route::post('/society-register',[AmendmentController::class,'ammendmentRegister'])->name('societyRegister');
// Route::get('/get/amendment-list', [AmendmentController::class, 'getAmendmentList'])->name('get.amendment.list');

/* 34Inspection */
Route::get('/inspection-create', [InspectionController::class, 'createInspection'])->name('inspection-create');
Route::get('/inspection-index', [InspectionController::class, 'indexInspection'])->name('inspection-index');
Route::post('/store-inspection', [InspectionController::class, 'storeInspection'])->name('store-inspection');
Route::get('/get-inspection-list', [InspectionController::class, 'getInspectionList'])->name('get-inspection-list');
Route::get('edit-inspection/{id}', [InspectionController::class, 'editInspection'])->name('edit-inspection');
Route::post('update-inspection/{id}', [InspectionController::class, 'updateInspection'])->name('update-inspection');
Route::get('/inspection-applications/{inspection}/history', [InspectionController::class, 'history'])->name('inspection-applications.history');


/* 35Inquiry */
Route::get('/inquiry', [InquiryController::class, 'show_inquiry_form'])->name('show.inquiry_form');
Route::get('/get_blocks_by_district/{district_id}', [InquiryController::class, 'getBlocksByDistrict'])->name('get-blocks_by_district');

Route::get('/get_societies_by_criteria', [InquiryController::class, 'getSocietyByDistrictBlockCategory'])
    ->name('societies.by_criteria');

Route::get('/get_societies_by_category/{categoryName}', [InquiryController::class, 'getSocietiesByCategory']);

Route::get('/get_society_name_by_id/{id}', [InquiryController::class, 'getSocietyNameById']);

Route::post('/submit-section35', [InquiryController::class, 'storeSection35'])->name('section35.store');

Route::get('/get-inquiries-list', [InquiryController::class, 'showInquiriesList'])->name('get-inquiries-list');

Route::get('/get-inquiries35-list', [InquiryController::class, 'section35Index'])->name('get-inquiries35-list');

Route::get('/inquiries/{id}/edit', [InquiryController::class, 'editInquiry'])->name('edit-inquiry');

Route::put('/inquiries/{id}', [InquiryController::class, 'updateInquiry'])->name('update-inquiry');


/*Inspection*/
Route::get('/inspection-record-list', [InspectionController::class, 'inspectionRecords'])->name('inspection-record-list');
Route::get('/get-designation-wise-officers', [InspectionController::class, 'getOfficers'])->name('get-designation-wise-officers');
Route::get('/get-society-count', [InspectionController::class, 'getSocietyCount'])->name('get.society.count');
Route::post('/inspection-target/store', [InspectionController::class, 'storeTarget'])->name('inspection-target.store');
Route::get('inspection-targets/history/{target}', [InspectionController::class, 'targetHistory'])->name('inspection-targets.history');

//Inspection at DRCS and ARCS
// Route::get('/get-blocks/{district_id}', [InspectionController::class, 'getBlocks']);
// web.php
Route::get('/get-assigned-officer', [InspectionController::class, 'getAssignedOfficer'])->name('get.assigned.officer');
Route::get('/get-societies/{district_id}/{block_id}', [InspectionController::class, 'getSocieties'])->name('get-societies');
Route::post('/assign-inspection-societies', [InspectionController::class, 'assignInspectionSocieties'])->name('assign-inspection-societies');
Route::get('/get-societies-checkbox', [InspectionController::class, 'getSocietiesCheckbox'])->name('get.societies.checkbox');



