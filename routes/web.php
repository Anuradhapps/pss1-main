<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    Auth\LoginController,
    Auth\RegisterController,
    Auth\ForgotPasswordController,
    Auth\ResetPasswordController,
    Auth\JoinController,
    Auth\TwoFaController,
    CollectorController,
    PestDataCollectController,
    PestController,
    ReportController,
    UserController,
    ChartController,
    TestController
};
use App\Exports\UsersExport;
use App\Http\Livewire\{
    Admin\Dashboard,
    Admin\AuditTrails,
    Admin\SentEmails\SentEmails,
    Admin\SentEmails\SentEmailsBody,
    Admin\Settings\Settings,
    Admin\Roles\Roles,
    Admin\Roles\Edit,
    Admin\Users\Users,
    Admin\Users\EditUser,
    Admin\Users\ShowUser,
    Admin\Programs\ConductedPrograms,
    Collector\CollectorLivewire,
    DeputyDirector\DeputyDashboard,
    ExtensionAndTrainingDirector\DashboardExtensionAndTrainingDirector,
    LocationManager,
};

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', Dashboard::class)->name('dashboard');

Route::middleware(['web', 'guest'])->group(function () {
    Route::get('/', [LoginController::class, 'showLoginForm']);
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);

    Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset/{token}', [ResetPasswordController::class, 'reset'])->name('password.reset.update');

    Route::get('/join/{token}', [JoinController::class, 'index'])->name('join');
    Route::put('/join/{id}', [JoinController::class, 'update'])->name('join.update');

    Route::get('/help', function () {
        return view('help.index');
    })->name('loginhelp');
});

/*
|--------------------------------------------------------------------------
| Shared Authenticated Routes (Admin & Collector)
|--------------------------------------------------------------------------
*/
Route::middleware(['web', 'auth', 'activeUser', 'IpCheckMiddleware'])->group(function () {
    // Two-Factor Authentication
    Route::prefix('admin')->group(function () {
        Route::get('/2fa', [TwoFaController::class, 'index'])->name('2fa');
        Route::post('/2fa', [TwoFaController::class, 'update'])->name('2fa.update');
        Route::get('/2fa-setup', [TwoFaController::class, 'setup'])->name('2fa-setup');
        Route::post('/2fa-setup', [TwoFaController::class, 'setupUpdate'])->name('2fa-setup.update');
    });

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['web', 'auth', 'activeUser', 'IpCheckMiddleware', 'role:admin'])->prefix('admin')->group(function () {


    // Settings
    Route::get('/settings/system-settings', Settings::class)->name('admin.settings');
    Route::get('/settings/audit-trails', AuditTrails::class)->name('admin.settings.audit-trails.index');
    Route::get('/settings/sent-emails', SentEmails::class)->name('admin.settings.sent-emails');
    Route::get('/settings/sent-emails-body/{id}', SentEmailsBody::class)->name('admin.settings.sent-emails.body');
    Route::get('/settings/roles', Roles::class)->name('admin.settings.roles.index');
    Route::get('/settings/roles/{role}/edit', Edit::class)->name('admin.settings.roles.edit');

    // Users
    Route::get('/users', Users::class)->name('admin.users.index');
    Route::get('/users/{user}/edit', EditUser::class)->name('admin.users.edit');
    Route::get('/users/{user}', ShowUser::class)->name('admin.users.show');

    // Collector Management
    Route::get('/collector', CollectorLivewire::class)->name('admin.collector.records');
    Route::get('/collector/{collector}/edit', [CollectorController::class, 'edit'])->name('admin.collector.edit');
    Route::put('/collector/{collector}', [CollectorController::class, 'update'])->name('admin.collector.update');
    Route::delete('/collector/{collector}/destroy', [CollectorController::class, 'destroy'])->name('admin.collector.destroy');
    Route::get('/admin-collector-view/{id}', [CollectorController::class, 'adminCollectorView'])->name('admin.collectors.view');

    // Pest Data
    Route::get('/collector-show-pest_data/{id}', [PestDataCollectController::class, 'show'])->name('admin.collector.pest.show');
    Route::delete('/pestdata/{id}', [PestDataCollectController::class, 'adminDestroy'])->name('admin.pestdata.destroy');

    // Pest Management
    Route::resource('pest', PestController::class)->except('edit', 'update');
    Route::get('/pest/{id}/edit', [PestController::class, 'edit'])->name('pest.edit');
    Route::put('/pest/{id}', [PestController::class, 'update'])->name('pest.update');

    // Reports
    Route::resource('report', ReportController::class);
    Route::get('/export-last2weeksDataexportToPDF/{id}', [ReportController::class, 'last2weeksDataexportToPDF'])->name('export.last2weeksDataexportToPDF');
    Route::get('/export-collectors-list', [ReportController::class, 'collectorsList'])->name('export.collectorsList');
    Route::get('/export-reportOfOtherInfo', [ReportController::class, 'reportOfOtherInfo'])->name('export.reportOfOtherInfo');

    // Charts
    Route::get('/chart', [ChartController::class, 'index'])->name('chart.index');
    Route::post('/chart/show', [ChartController::class, 'chart'])->name('chart.show');
    Route::get('/chart/aiShow/{id}', [ChartController::class, 'chartAiShow'])->name('chart.ai.show');
    Route::get('/chart/show/allSeason', [ChartController::class, 'allSeasonChart'])->name('chart.show.allSeason');

    // Export
    Route::post('/export-allpestdata', [UserController::class, 'allpestdata'])->name('export.allpestdata');
    Route::post('/export', [UsersExport::class, 'export'])->name('export');

    // Conducted Programs
    Route::get('conducted-programs', ConductedPrograms::class)->name('admin.conducted-programs');



    Route::get('/location-settings', LocationManager::class)->name('location.settings');
});

/*
|--------------------------------------------------------------------------
| Collector Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['web', 'auth', 'activeUser', 'IpCheckMiddleware', 'role:collector'])->prefix('collector')->group(function () {

    // Dashboard & Profile
    Route::get('/', [CollectorController::class, 'index'])->name('collector.index');
    Route::get('/create', [CollectorController::class, 'create'])->name('collector.create');
    Route::get('/newCollector', [CollectorController::class, 'newCollector'])->name('collector.newCollector');
    Route::post('/store', [CollectorController::class, 'store'])->name('collector.store');
    Route::get('/edit/{id}', [CollectorController::class, 'edit'])->name('collector.edit');
    Route::put('/{id}', [CollectorController::class, 'update'])->name('collector.update');
    Route::delete('/collector/{collector}/destroy', [CollectorController::class, 'collectordestroy'])->name('collector.destroy');

    // Pest Data
    Route::prefix('pestdata')->group(function () {
        Route::get('/', [PestDataCollectController::class, 'index'])->name('pestdata.index');
        Route::get('/view/{id}', [PestDataCollectController::class, 'view'])->name('pestdata.view');
        Route::get('/create/{id}', [PestDataCollectController::class, 'create'])->name('pestdata.create');
        Route::post('/store/{id}', [PestDataCollectController::class, 'store'])->name('pestdata.store');
        Route::get('/{id}', [PestDataCollectController::class, 'show'])->name('pestdata.show');
        Route::get('/{id}/edit', [PestDataCollectController::class, 'edit'])->name('pestdata.edit');
        Route::put('/{id}', [PestDataCollectController::class, 'update'])->name('pestdata.update');
        Route::delete('/{id}', [PestDataCollectController::class, 'destroy'])->name('pestdata.destroy');
    });

    Route::get('/help', function () {
        return view('help.index');
    })->name('help');
});



Route::middleware(['web', 'auth', 'activeUser', 'IpCheckMiddleware', 'role:deputyDirector'])->prefix('deputy')->group(function () {
    Route::get('/', DeputyDashboard::class)->name('deputy.dashboard');
});


Route::middleware(['web', 'auth', 'activeUser', 'IpCheckMiddleware', 'role:extensionAndTrainingDirector'])->prefix('extensionAndTrainingDirector')->group(function () {
    Route::get('/', DashboardExtensionAndTrainingDirector::class)->name('extensionAndTrainingDirector.dashboard');
});

Route::get('/weeklyPestRiskIndex', function () {
    return view('chart.Weekly-Pest-Risk-Index');
})->name('weekly-pest-risk.index');
Route::get('/pestseasoncomparison', function () {
    return view('chart.pest-season-comparison');
})->name('pest-season-comparison');
Route::get('/pesttempcomparison', function () {
    return view('chart.pest-temp-comparison');
})->name('pest-temp-comparison');
Route::get('/pestraincomparison', function () {
    return view('chart.pest-rain-comparison');
})->name('pest-rain-comparison');
Route::get('/pestricecomparison', function () {
    return view('chart.pest-rice-variety-comparison');
})->name('pest-rice-variety-comparison');



Route::get('test', function () {
    return view('test');
})->name('test.t');
Route::get('testcontroller', [TestController::class, 'index']);
