<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->boolean('is_active')->default(true);
            $table->string('type', 2);
            $table->string('display_name', 120);
            $table->string('legal_name', 150)->nullable();
            $table->string('trade_name', 150)->nullable();
            $table->string('document_type', 10);
            $table->string('document_number', 20);
            $table->string('email', 150)->nullable();
            $table->string('phone', 30)->nullable();
            $table->timestamps();
            $table->softDeletes();

            //index
            $table->unique(['document_type', 'document_number']);
            $table->index(['is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
