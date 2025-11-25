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
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained('partners')->onDelete('cascade');
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');

            // Changed booking_id from foreignId to string (since you're using TNR0001-like IDs)
            $table->string('booking_id'); 

            $table->string('unit_name');

            // Removed booking_date as requested
            $table->decimal('total_amount', 15, 2);

            // Option 1: If you're storing "2%" as string
            $table->string('partner_commission_rate');

            // Option 2: Use this if storing 2.00 as decimal
            // $table->decimal('partner_commission_rate', 5, 2);

            $table->decimal('amount', 15, 2); // Commission amount
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commissions');
    }
};
