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
        Schema::create('supervisor_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('phone_number')->nullable();
            $table->enum('sexe', ["M","F"])->nullable();
            $table->string('address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supervisor_infos');
    }
};
