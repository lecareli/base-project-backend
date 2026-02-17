<?php

use App\Modules\Errors\Presentation\Http\Controllers\Internal\ErrorLogController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'tenant:true'])->group(function () {
    Route::get('/error-logs', [ErrorLogController::class, 'index'])->name('error_logs.index');
    Route::get('/error-logs/{id}', [ErrorLogController::class, 'show'])->name('error_logs.show');
    Route::patch('/error-logs/{id}/resolve', [ErrorLogController::class, 'resolve'])->name('error_logs.resolve');
});
