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
        Schema::create('customers', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('contact_number');
        $table->string('email')->unique();
        $table->date('dob');
        $table->string('aadhar_number');
        $table->string('pan_number');
        $table->string('referred_by'); // via_builder / via_partner
        $table->string('builder_name')->nullable();
        $table->string('partner_name')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
