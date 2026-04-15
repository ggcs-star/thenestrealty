<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();

            // Template Name
            $table->string('name');

            // Full HTML Template (with {{variables}})
            $table->longText('template_html');

            // Optional: Template Type (loan, sale, receipt)
            $table->string('type')->nullable();

            // Optional: store variables (future SaaS use)
            $table->json('variables')->nullable();

            // Status (active / inactive)
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};