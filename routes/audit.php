<?php

use App\Http\Controllers\AuditController;
use App\Models\AuditAlotment;
use Illuminate\Support\Facades\Route;


Route::get('audit-dashboard', [AuditController::class, 'show'])->name('audit.dashboard');
Route::get('auditalotment', [AuditController::class, 'auditshow'])->name('auditalotment');
Route::post('/fetch-societies-for-audit', [AuditController::class, 'fetchSocieties'])->name('fetch-societies-for-audit');
Route::post('/save-audit-allotment', [AuditController::class, 'saveAllotment'])->name('save-audit-allotment');
Route::get('/get-allotted-societies', [AuditController::class, 'getAllottedData'])->name('get-allotted-societies');
Route::get('/alotement-lst', [AuditController::class, 'auditData'])->name('auditlst');
Route::get('/audit-allotment/data', [AuditController::class, 'getAuditAllotmentList'])->name('get.auditAllotment.list');
Route::post('/audit-allotment/update-dates', [AuditController::class, 'updateAuditDates'])->name('auditAllotment.updateDates');
// Audit form routes
Route::get('audit-form', [AuditController::class, 'auditFormShow'])->name('audit.auditForm');
Route::get('/edit/{id}', [AuditController::class, 'editAudit'])->name('audit.edit');
Route::post('/audit/submit', [AuditController::class, 'storeAuditData'])->name('audit.submit');
Route::get('/get-society-details', [AuditController::class, 'getSocietyDetails'])->name('get.society.details');
Route::get('/audits/bank', [AuditController::class, 'bankListing'])->name('audits.bank');
Route::get('/audits/society', [AuditController::class, 'societyListing'])->name('audits.society');
// society Login

Route::get('audit-plan-approval-by-society', [AuditController::class, 'auditAprvalBysociety'])->name('audit-plan-approval-society');
Route::get('auditor-planning', [AuditController::class, 'getAuditorPlanning'])->name('auditor-planning');
Route::post('/audit-society-approval', [AuditController::class, 'storeSocietyApproval'])->name('audit.society-approval.store');
