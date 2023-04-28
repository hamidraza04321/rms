<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('admission_no', 20);
            $table->string('roll_no', 20);
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->foreignId('section_id')->constrained('sections')->onDelete('cascade');
            $table->foreignId('group_id')->nullable()->constrained('groups')->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('gender');
            $table->date('dob');
            $table->string('religion')->nullable();
            $table->string('caste')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('email')->nullable();
            $table->date('admission_date')->nullable();
            $table->string('student_image')->nullable();
            
            // Father details
            $table->string('father_name')->nullable();
            $table->string('father_email')->nullable();
            $table->string('father_cnic')->nullable();
            $table->string('father_phone')->nullable();
            $table->string('father_occupation')->nullable();
            $table->string('father_image')->nullable();
            
            // Mother details
            $table->string('mother_name')->nullable();
            $table->string('mother_email')->nullable();
            $table->string('mother_cnic')->nullable();
            $table->string('mother_phone')->nullable();
            $table->string('mother_occupation')->nullable();
            $table->string('mother_image')->nullable();

            // Guardian
            $table->string('guardian_is');
            $table->string('guardian_name');
            $table->string('guardian_email')->nullable();
            $table->string('guardian_cnic')->nullable();
            $table->string('guardian_phone');
            $table->string('guardian_relation')->nullable();
            $table->string('guardian_occupation')->nullable();
            $table->string('guardian_image')->nullable();

            // Address
            $table->text('current_address')->nullable();            
            $table->text('permenant_address')->nullable();

            $table->boolean('is_active')->default('1');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
};
