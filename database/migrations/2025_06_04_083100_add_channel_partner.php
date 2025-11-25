<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('partner_name');
            $table->string('number_contact');
            $table->string('mail_id')->unique();
            $table->date('date_of_birth');
            $table->string('aadhaar_card')->unique();
            $table->string('pan_card')->unique();
            $table->string('commission'); // Fixed typo
            $table->string('status');
            $table->timestamps();
            // Remove timestamps if disabled in model
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};