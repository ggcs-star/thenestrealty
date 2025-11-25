<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('loans', function (Blueprint $table) {
        $table->id();
        $table->string('customer_name');
        $table->string('booking_id');
        $table->string('unit_name')->default('Default Display');
        $table->string('bank_name')->nullable();
        $table->string('employee_name')->nullable();
        $table->string('employee_number')->nullable();
        $table->decimal('loan_amount', 12, 2)->nullable();
        $table->string('loan_stage')->nullable();
        $table->text('notes')->nullable();
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
