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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('ex_unit')->default(0); // Use unsigned integer for unit count
            $table->text('address'); // Use text for potentially long addresses
            $table->string('builder_name');
            $table->string('builder_number', 20); // Limit phone number length
            
            // Foreign key relationship instead of string
            $table->unsignedBigInteger('assigned_employee');
            $table->foreign('assigned_employee')->references('id')->on('employees')
                  ->onDelete('cascade'); // Or 'restrict' based on your business logic
            
            $table->json('documents')->nullable();
            $table->timestamps();
            
            // Add indexes for better performance
            $table->index('assigned_employee');
            $table->index('builder_name');
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};