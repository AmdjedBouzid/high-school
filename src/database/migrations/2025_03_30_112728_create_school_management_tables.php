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
        Schema::create('role', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->timestamps();
        });

        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email', 255)->unique();
            $table->string('password', 255);
            $table->foreignId('role_id')->nullable()->constrained('role')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('supervisor_info', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('user')->onDelete('cascade');
            $table->string('phone_number', 20)->nullable();
            $table->enum('sexe', ['M', 'F'])->nullable();
            $table->string('address', 255)->nullable();
            $table->timestamps();
        });

        Schema::create('record_status', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->timestamps();
        });

        Schema::create('student_type', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->timestamps();
        });

        Schema::create('student', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('class', 50);
            $table->string('code', 50)->unique();
            $table->foreignId('record_status_id')->nullable()->constrained('record_status')->onDelete('set null');
            $table->foreignId('student_type_id')->nullable()->constrained('student_type')->onDelete('set null');
            $table->timestamp('inserted_at')->useCurrent();
            $table->timestamps();
        });

        Schema::create('student_supervisor', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('user')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('student')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
            $table->primary(['user_id', 'student_id']);
        });

        Schema::create('absence', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('student')->onDelete('cascade');
            $table->date('day');
            $table->string('class_index', 50);
            $table->string('address', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop tables in reverse order to respect foreign key constraints
        Schema::dropIfExists('absence');
        Schema::dropIfExists('student_supervisor');
        Schema::dropIfExists('student');
        Schema::dropIfExists('student_type');
        Schema::dropIfExists('record_status');
        Schema::dropIfExists('supervisor_info');
        Schema::dropIfExists('user');
        Schema::dropIfExists('role');
    }
};