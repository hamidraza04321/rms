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
        Schema::create('exam_remarks', function (Blueprint $table) {
            $table->id();
            $table->morphs('remarkable');
            $table->foreignId('mark_slip_id')->constrained('mark_slips')->onDelete('cascade');
            $table->foreignId('student_session_id')->constrained('student_sessions')->onDelete('cascade');
            $table->unique([ 'remarkable_type', 'remarkable_id', 'student_session_id' ])->index('unique_exam_remarks');
            $table->integer('remarks');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_remarks');
    }
};
