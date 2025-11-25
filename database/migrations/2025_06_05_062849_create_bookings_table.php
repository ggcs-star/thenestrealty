<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->string('referred_by')->default('Default');
            $table->string('unit_name');
            $table->float('unit_size');
            $table->string('unit_unit'); // Sq. Feet or Sq. Yard
            $table->date('booking_date');
            $table->date('followup_date');
            $table->decimal('invoice_amount', 12, 2);
            $table->decimal('other_amount', 12, 2)->default(0);
            $table->decimal('total_amount', 12, 2);
            $table->enum('status', ['Booked', 'Cancelled'])->default('Booked');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
