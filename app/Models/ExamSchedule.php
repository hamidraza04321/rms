<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Scopes\HasSubject;

class ExamSchedule extends Model
{
    use HasFactory,
    	SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'exam_schedules';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'exam_class_id',
        'subject_id',
        'date',
        'start_time',
        'end_time',
        'type',
        'marks',
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

    protected $dates = [ 'date' ];

    public function categories()
    {
        return $this->hasMany(ExamScheduleCategory::class, 'exam_schedule_id');
    }

    public function remarks()
    {
        return $this->morphMany(ExamRemarks::class, 'remarkable');
    }

    public function gradeRemarks()
    {
        return $this->morphMany(ExamGradeRemarks::class, 'remarkable');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class)
            ->select([ 'id', 'name' ]);
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    public static function booted()
    {
        static::addGlobalScope(new HasSubject);
    }
}
