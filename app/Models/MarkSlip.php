<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\HasSubject;
use App\Models\Scopes\HasSection;
use App\Models\Scopes\HasExamClass;

class MarkSlip extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mark_slips';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'exam_class_id',
        'section_id',
        'subject_id',
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

    public function subject()
    {
        return $this->belongsTo(Subject::class)
            ->select([ 'id', 'name' ]);
    }

    public function section()
    {
        return $this->belongsTo(Section::class)
            ->select([ 'id', 'name' ]);
    }

    public function examClass()
    {
        return $this->belongsTo(ExamClass::class, 'exam_class_id')
            ->select([ 'id', 'exam_id', 'class_id' ]);
    }

    public function examRemarks()
    {
        return $this->hasMany(ExamRemarks::class, 'mark_slip_id');
    }

    public function examGradeRemarks()
    {
        return $this->hasMany(ExamGradeRemarks::class, 'mark_slip_id');
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    public static function booted()
    {
        static::addGlobalScope(new HasSubject);
        static::addGlobalScope(new HasSection);
        static::addGlobalScope(new HasExamClass);
    }
}
