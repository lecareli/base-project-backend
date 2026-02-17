<?php

use App\Modules\Auditing\Presentation\Http\Controllers\Internal\AuditLogController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'tenant:false'])->group(function () {
    Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit_logs.index');
    Route::get('/audit-logs/{id}', [AuditLogController::class, 'show'])->name('audit_logs.show');
});
