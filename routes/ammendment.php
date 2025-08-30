<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AmendmentController;
use App\Http\Middleware\Authenticate;

Route::middleware([Authenticate::class])->group(
     function () {

Route::get('/dashboard', [AmendmentController::class, 'show_ablm_dashboard'])->name('show.ablm_dashboard');
Route::get('/list', [AmendmentController::class, 'amendment_listing'])->name('show.ablm_listing');
Route::get('/details/{id}', [AmendmentController::class, 'amendment_details'])->name('show.ablm_details');
Route::get('/BylawsMaster', [AmendmentController::class, 'show'])->name('amendment.show');
Route::post('/society-register',[AmendmentController::class,'ammendmentRegister'])->name('societyRegister');
Route::get('/get/amendment-list', [AmendmentController::class, 'getAmendmentList'])->name('get.amendment.list');
Route::post('/amendment/take-action', [AmendmentController::class, 'takeAction'])->name('amendment.takeAction');
Route::get('/amendment/history/{amendment}', [AmendmentController::class, 'history'])->name('amendment.history');
Route::get('/amendment/edit/{id}', [AmendmentController::class, 'edit'])->name('amendment.edit');
Route::get('/amendment/dashboard/filter', [AmendmentController::class, 'filterDashboard'])->name('amendment.dashboard.filter');
Route::get('/get-societies-by-category', [AmendmentController::class, 'getSocietiesByCategory'])->name('ajax.societies.by.category');
Route::get('/get-society-details', [AmendmentController::class, 'getSocietyDetails'])->name('ajax.society.details');
  }
);



