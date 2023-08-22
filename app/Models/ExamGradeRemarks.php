<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamGradeRemarks extends Model
{
    use HasFactory,
    	SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'exam_grade_remarks';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'remarkable_type',
        'remarkable_id',
        'mark_slip_id',
        'student_session_id',
        'grade_id',
    	'created_by',
    	'updated_by'
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
    	'id',
    	'created_at',
    	'updated_at'
    ];

    /**
     * Get all of the models that own remarks.
     */
    public function remarkable()
    {
        return $this->morphTo();
    }
}
