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
        // Inside migration
            Schema::create('collections', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('booking_id');
                $table->unsignedBigInteger('customer_id');
                $table->unsignedBigInteger('partner_id');
                $table->unsignedBigInteger('project_id');
                $table->date('date');
                $table->decimal('amount', 10, 2);
                $table->string('mode');
                $table->timestamps();
            });


    }
    public function create()
{
    return view('collection.create'); // Or whatever your Blade file name is
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collections');
    }

    
};
