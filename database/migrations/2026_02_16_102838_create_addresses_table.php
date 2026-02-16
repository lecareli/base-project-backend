<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuidMorphs('addressable');
            $table->foreignUuid('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->string('type', 50)->default('BILLING');
            $table->boolean('is_primary')->default(false);
            $table->string('zip', 12);
            $table->string('street', 150);
            $table->string('number', 20)->nullable();
            $table->string('complement', 80)->nullable();
            $table->string('district', 80)->nullable();
            $table->string('city', 80);
            $table->string('state', 2);
            $table->string('country', 2)->default('BR');
            $table->string('ibge_code', 10)->nullable();
            $table->timestamps();
            $table->softDeletes();

            //index
            $table->index(['tenant_id']);
            $table->index(['is_primary']);
            $table->index(['type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
