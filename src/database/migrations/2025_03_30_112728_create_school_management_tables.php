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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('username', 30)->unique();
            $table->string('email', 255)->unique();
            $table->string('password', 255)->nullable();
            $table->foreignId('role_id')->nullable()->constrained('roles')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('supervisor_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('phone_number', 10)->nullable();
            $table->string('address', 255)->nullable();
            $table->enum('sexe', ['M', 'F']);
            $table->softDeletes();
            $table->timestamps();
        });


        Schema::create('student_states', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
        });


        Schema::create('student_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('majors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('grade_id')->constrained('grades')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('major_id')->constrained('majors')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('code', 50)->unique();
            $table->enum('sexe', ['M', 'F']);

            $table->foreignId('section_id')->nullable()->constrained('sections')->onDelete('cascade');
            $table->foreignId('student_type_id')->nullable()->constrained('student_types')->onDelete('set null');
            $table->foreignId('student_state_id')->nullable()->constrained('student_states')->onDelete('set null');
            $table->foreignId('inserted_by')->nullable()->constrained('users')->onDelete('set null');
            
            $table->timestamps();
            $table->softDeletes();
        });

        
        Schema::create('student_supervisors', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->primary(['user_id', 'student_id']);
            $table->softDeletes();
        });
        
        Schema::create('absence_actions', function (Blueprint $table) {
            $table->id();
            $table->dateTime('time');
            $table->foreignId('made_by')->nullable()->constrained('users')->onDelete('set null');
        });
        
        Schema::create('absences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('from')->constrained('absence_actions')->onDelete('cascade');
            $table->foreignId('to')->nullable()->constrained('absence_actions')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absences');
        Schema::dropIfExists('student_supervisors');
        Schema::dropIfExists('students');
        Schema::dropIfExists('sections');
        Schema::dropIfExists('majors');
        Schema::dropIfExists('student_types');
        Schema::dropIfExists('record_statuses');
        Schema::dropIfExists('supervisor_infos');
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
    }
};
