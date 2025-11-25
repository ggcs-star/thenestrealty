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
        Schema::create('points', function (Blueprint $table) {
            $table->id();
            $table->decimal('rupee_per_point', 10, 2)->default(10.00);
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

        });

              DB::table('points')->insert([
            'rupee_per_point' => 10.00,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('points');
    }
};
