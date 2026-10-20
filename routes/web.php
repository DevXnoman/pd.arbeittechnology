<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\AccountController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected System Routes
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect()->route('projects.index');
    });

    Route::get('/dashboard', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects', [ProjectController::class, 'list'])->name('projects.list');

    // Accounts & Finance Module Routes
    Route::get('/accounts', [AccountController::class, 'index'])->name('accounts.index');
    Route::get('/accounts/export', [AccountController::class, 'export'])->name('accounts.export');
    Route::post('/accounts/expenses', [AccountController::class, 'storeExpense'])->name('accounts.expenses.store');
    Route::put('/accounts/expenses/{expense}', [AccountController::class, 'updateExpense'])->name('accounts.expenses.update');
    Route::delete('/accounts/expenses/{expense}', [AccountController::class, 'destroyExpense'])->name('accounts.expenses.destroy');

    // Money Receipt & Invoices
    Route::get('/invoices', [InvoiceController::class, 'create'])->name('invoices.create');
    Route::post('/invoices', [InvoiceController::class, 'store'])->name('invoices.store');
    Route::get('/invoices/{receipt}', [InvoiceController::class, 'show'])->name('invoices.show');
    Route::delete('/invoices/{receipt}', [InvoiceController::class, 'destroy'])->name('invoices.destroy');

    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');

    // Lead Tracking System Routes
    Route::get('/leads', [LeadController::class, 'index'])->name('leads.index');
    Route::get('/leads/create', [LeadController::class, 'create'])->name('leads.create');
    Route::post('/leads', [LeadController::class, 'store'])->name('leads.store');
    Route::get('/leads/export', [LeadController::class, 'export'])->name('leads.export');
    Route::post('/leads/import', [LeadController::class, 'import'])->name('leads.import');
    Route::delete('/leads/campaigns/delete', [LeadController::class, 'destroyCampaign'])->name('leads.campaigns.destroy');
    Route::get('/leads/{lead}', [LeadController::class, 'show'])->name('leads.show');
    Route::get('/leads/{lead}/edit', [LeadController::class, 'edit'])->name('leads.edit');
    Route::put('/leads/{lead}', [LeadController::class, 'update'])->name('leads.update');
    Route::patch('/leads/{lead}/quick-update', [LeadController::class, 'quickUpdate'])->name('leads.quick-update');
    Route::post('/leads/{lead}/notes', [LeadController::class, 'addNote'])->name('leads.add-note');
    Route::post('/leads/{lead}/convert', [LeadController::class, 'convertToProject'])->name('leads.convert');
    Route::delete('/leads/{lead}', [LeadController::class, 'destroy'])->name('leads.destroy');
});

// One-time artisan migration runner for production (shared hosting without terminal)
Route::get('/run-artisan-migrate', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        $migrateOutput = \Illuminate\Support\Facades\Artisan::output();

        \Illuminate\Support\Facades\Artisan::call('storage:link');
        $storageOutput = \Illuminate\Support\Facades\Artisan::output();

        \Illuminate\Support\Facades\Artisan::call('optimize:clear');
        $optimizeOutput = \Illuminate\Support\Facades\Artisan::output();

        return response("<pre style='background:#0f172a;color:#38bdf8;padding:20px;border-radius:10px;font-family:monospace;'>🚀 Migration & Storage Link Results:\n\n=== MIGRATE ===\n" . e($migrateOutput) . "\n=== STORAGE ===\n" . e($storageOutput) . "\n=== OPTIMIZE ===\n" . e($optimizeOutput) . "\n\nAll tasks completed successfully! You can now access /leads</pre>");
    } catch (\Throwable $e) {
        return response("<pre style='color:red;padding:20px;'>Error running migrations: " . e($e->getMessage()) . "</pre>", 500);
    }
});



