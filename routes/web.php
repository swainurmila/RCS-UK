<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AmendmentController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ComplaintVerificationController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\AppealController;
use App\Http\Controllers\DocumentVerificationController;
use App\Http\Controllers\SocietyRegistration\ApplicationVerificationController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\InspectionController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\RolePermissionsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MasterController;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RedirectIfAuthenticatedWithRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

Route::post('/login', [LoginController::class, 'login'])->name('user-login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::post('/create-registration', [RegisterController::class, 'register'])->name('create.registration');
Route::post('/society-registration', [RegisterController::class, 'societyRegister'])->name('society.registration');



Route::post('/check-aadhar-exists', [RegisterController::class, 'checkAadharExists'])->name('aadhar.exists');
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('all.dashboard');
    }
    return view('auth.login');
})->name('login.view');
Route::get('/registration', [RegisterController::class, 'showregister'])->name('registration');
Route::post('/check-mobno-exists', [RegisterController::class, 'checkMobileEmail'])->name('check.mobile.exists');
// Route::post('/check-email-exists', [RegisterController::class, 'checkEmailExists'])->name('check.email.exists');

Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');

Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');

Route::post('/reset-passwordd', [ResetPasswordController::class, 'reset'])->name('password.update');


// Route::get('lang/{lang}', [LanguageController::class, 'switchLang'])->name('lang.switch');
Route::post('/change-language', [DashboardController::class, 'switch'])
    ->name('language.switch');
Route::middleware([Authenticate::class])->group(

    function () {
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('society.dashboard');
        Route::get('/official-dashboard', [DashboardController::class, 'official_dashboard'])->name('official.dashboard');
        Route::get('/all-dashboard', [DashboardController::class, 'all_dashboard'])->name('all.dashboard');
        Route::get('/dashboard', [DashboardController::class, 'all_dashboard1'])->name('dashboard');
        Route::get('/dashboard/filter', [DashboardController::class, 'filter'])->name('dashboard.filter');
        // Route::get('/get-blocks/{district_id}', [RegisterController::class, 'getBlocks']);


        // Route::get('/social-registration', function () {
        //     return view('social_registration');
        // });
        Route::get('/society-registration', [RegisterController::class, 'showSocietyRegistration'])->name('society.register');

        Route::get('/social-registration', [RegisterController::class, 'showSocietyRegistration']);
        Route::get('/get-blocks/{district_id}', [RegisterController::class, 'getBlocks']);
        Route::get('/society-member', [RegisterController::class, 'showSocietyMember']);
        Route::get('/societies/edit/{id}', [RegisterController::class, 'edit'])->name('society.edit');
        Route::post('/delete-member', [RegisterController::class, 'deleteSocietyMember'])->name('member.delete');
        // Route::get('/societies/{id}/view', [RegisterController::class, 'show'])->name('society-regd-applications.view');
        Route::get('/societies/{id}/view', [RegisterController::class, 'show'])->name('society-regd-applications.view');
        // Document Management Routes
        Route::post('/society/update-document-status', [RegisterController::class, 'updateDocumentStatus'])
            ->name('society.updateDocumentStatus');

        Route::post('/society/upload-revised-document', [RegisterController::class, 'uploadRevisedDocument'])
            ->name('society.uploadRevisedDocument');
        Route::post('/save-member', [RegisterController::class, 'saveMember'])->name('save.member');
        Route::post('/delete-member', [RegisterController::class, 'memberDelete'])->name('delete_member');

        Route::post('/document/verify', [DocumentVerificationController::class, 'verifyDocument'])->name('document.verify');
        Route::post('/document/upload-revised', [DocumentVerificationController::class, 'uploadRevisedDocument'])->name('document.upload-revised');
        Route::post('/document/complete-verification', [DocumentVerificationController::class, 'completeVerification'])->name('document.complete-verification');
        

        Route::get('/document/history', [RegisterController::class, 'history'])
            ->name('document.history');

        Route::post('/society/inspection-report', [RegisterController::class, 'storeinspection'])
            ->name('society.inspectionReport.store');
        Route::get('/social-registration-application', function () {
            return view('social_registration_application');
        });
        Route::get('/membership', function () {
            return view('membership_details');
        });
        Route::get('/society-regd-report', function () {
            return view('society_regd_report');
        });
        Route::get('/get-chart-data', [DashboardController::class, 'getChartData'])->name('getChartData');


        // Route::get('/social-regd-app-list', [RegisterController::class, 'social_regd_app_list'])->name('socialregdapp.list');

        /* Roles Permission */
        Route::get('/roles', [RolePermissionsController::class, 'index'])->name('roles');
        Route::get('/roles-create', [RolePermissionsController::class, 'create'])->name('roles-create');
        Route::post('/roles-store', [RolePermissionsController::class, 'store'])->name('roles-store');
        Route::get('/roles-edit/{id}', [RolePermissionsController::class, 'edit'])->name('roles-edit');
        Route::post('update-permissions', [RolePermissionsController::class, 'updatePermission'])->name('update-permissions');
        Route::post('/roles-delete/{id}', [RolePermissionsController::class, 'destroy'])->name('roles-delete');

        /* User */
        Route::get('/users-index', [UserController::class, 'index'])->name('users-index');
        Route::get('/users-create', [UserController::class, 'create'])->name('users-create');
        Route::post('/users-store', [UserController::class, 'store'])->name('users-store');
        Route::get('/users-edit/{id}', [UserController::class, 'edit'])->name('users-edit');
        Route::post('/users-update/{id}', [UserController::class, 'update'])->name('users-update');
        Route::post('/users-delete/{id}', [UserController::class, 'destroy'])->name('users-delete');


        Route::post('get-district', [AjaxController::class, 'getDistrict'])->name('get-district');
        Route::post('get-block', [AjaxController::class, 'getBlock'])->name('get-block');
        Route::get('/get-society-name', [AjaxController::class, 'getSocietyName'])->name('get.society.name');
        // Route::get('/amendment/dashboard', [AmendmentController::class, 'show_ablm_dashboard'])->name('show.ablm_dashboard');
        /* Approval Process */
        Route::get('/social-regd-app-list', [ApplicationVerificationController::class, 'social_regd_app_list'])->name('socialregdapp.list');
        Route::post('/society-regd-applications/action', [ApplicationVerificationController::class, 'takeAction'])->name('applications.takeAction');
        Route::get('/society-regd-applications/{application}/history', [ApplicationVerificationController::class, 'history'])->name('society-regd-applications.history');

        /* End Approval Process */
        Route::get('/history/get', [ApplicationVerificationController::class, 'getHistory'])->name('history.get');

        Route::get('/society-types', [MasterController::class, 'showSocietyTypes'])->name('society-types.show');
        Route::post('/society-types', [MasterController::class, 'saveSocietyTypes'])->name('society-types.store');
        Route::put('/society-types/{id}', [MasterController::class, 'updateSocietyTypes'])->name('society-types.update');
        Route::delete('/society-types/{id}', [MasterController::class, 'deleteSocietyTypes'])->name('society-types.destroy');

        Route::get('/society-objectives', [MasterController::class, 'showSocietyObjectives'])->name('society-objectives.show');
        Route::post('/society-objectives', [MasterController::class, 'saveSocietyObjectives'])->name('society-objectives.store');
        Route::put('/society-objectives/{id}', [MasterController::class, 'updateSocietyObjectives'])->name('society-objectives.update');
        Route::delete('/society-objectives/{id}', [MasterController::class, 'deleteSocietyObjectives'])->name('society-objectives.destroy');

        Route::get('/inspectors', [MasterController::class, 'showInspectors'])->name('inspectors.show');
        Route::post('/inspectors', [MasterController::class, 'saveInspectors'])->name('inspectors.store');
        Route::put('/inspectors/{id}', [MasterController::class, 'updateInspectors'])->name('inspectors.update');
        Route::delete('/inspectors/{id}', [MasterController::class, 'deleteInspectors'])->name('inspectors.destroy');

        /* Complaint Approval Process */
        Route::post('/complaint-applications/action', [ComplaintVerificationController::class, 'compTakeAction'])->name('applications.compTakeAction');
        Route::get('/complaint-applications/{complaint}/history', [ComplaintVerificationController::class, 'history'])->name('complaint-applications.history');


        // Route::get('audit-dashboard', [AuditController::class, 'show'])->name('audit.dashboard');
        // Route::get('auditalotment', [AuditController::class, 'auditshow'])->name('auditalotment');
        Route::get('edit-complaint/{id}', [ComplaintController::class, 'editComplaint'])->name('edit-complaint');
        Route::post('update-complaint/{id}', [ComplaintController::class, 'updateComplaint'])->name('update-complaint');




        // Appeal

        Route::get('/appeal-dashboard', [AppealController::class, 'index'])->name('appeal.dashboard');
        Route::get('/appeal-form', [AppealController::class, 'appealForm'])->name('appeal.form');
        Route::post('/appeal-form', [AppealController::class, 'appealFormStore'])->name('appeal.form.store');
        Route::get('/appeal-list', [AppealController::class, 'appealList'])->name('appeal.list');

        Route::post('/appeal/reject', [AppealController::class, 'reject'])->name('appeal.reject');

        Route::post('/appeal/final-decision', [AppealController::class, 'storeFinalDecision'])->name('appeal.final-decision.store');

        Route::post('/appeal/approve', [AppealController::class, 'approve'])->name('appeal.approve');
        Route::post('/appeal/request-documents', [AppealController::class, 'requestDocuments'])->name('appeal.request-documents');

        Route::get('/appeal/awaiting-documents', [AppealController::class, 'awaitingDocuments'])->name('appeal.awaiting-documents');


        Route::post('/awaiting-documents/submit', [AppealController::class, 'submitDocuments'])->name('awaiting-documents.submit');

        Route::post('/appeal/assign-hiring', [AppealController::class, 'assignHiring'])->name('appeal.assign-hiring');


       


    }
);
Route::post('/send-otp', [AjaxController::class, 'sendOtp'])->name('send.otp');
Route::post('/reset-otp', [AjaxController::class, 'resetOtp'])->name('reset.otp');
Route::post('/verify-otp', [AjaxController::class, 'verifyOtp'])->name('verify.otp');
Route::post('/reset-password', [AjaxController::class, 'resetPassword'])->name('reset.password');
Route::get('/test', function () {
    return view('auth.login');
});
Route::group(['middleware' => ['auth']], function() {
    Route::get('/audit/submission', [AuditController::class, 'create'])->name('audit.submission');
    Route::post('/audit/submit-step1', [AuditController::class, 'storeStep1'])->name('audit.submit.step1');
    Route::post('/audit/submit-step2', [AuditController::class, 'storeStep2'])->name('audit.submit.step2');
    Route::post('/audit/submit-step3', [AuditController::class, 'storeStep3'])->name('audit.submit.step3');
});
