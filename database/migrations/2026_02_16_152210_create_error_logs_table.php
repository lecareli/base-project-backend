<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('error_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('tenant_id')->nullable()->constrained('tenants')->nullOnDelete();
            $table->foreignUuid('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignUuid('resolved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('source');
            $table->string('level');
            $table->string('error_code')->nullable();
            $table->string('exception_class')->nullable();
            $table->text('message');
            $table->string('file')->nullable();
            $table->integer('line')->nullable();
            $table->text('stack_trace')->nullable();
            $table->string('http_method')->nullable();
            $table->string('url')->nullable();
            $table->string('route_name')->nullable();
            $table->text('query_params')->nullable();
            $table->text('request_payload')->nullable();
            $table->text('request_headers')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('app_module')->nullable();
            $table->string('job_name')->nullable();
            $table->uuid('correlation_id')->nullable();
            $table->text('extra_data')->nullable();
            $table->boolean('is_resolved')->default(false);
            $table->timestamp('resolved_at')->nullable();
            $table->text('resolution_note')->nullable();
            $table->timestamp('created_at')->nullable();

            // indexes
            $table->index(['tenant_id', 'created_at']);
            $table->index(['user_id']);
            $table->index(['resolved_by']);
            $table->index(['is_resolved']);
            $table->index(['level']);
            $table->index(['source']);
            $table->index(['error_code']);
            $table->index(['correlation_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('error_logs');
    }
};
