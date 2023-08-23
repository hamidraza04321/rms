<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Scopes\HasExam;
use App\Models\Scopes\HasClass;
use App\Models\Scopes\HasGroup;

class ExamClass extends Model
{
    use HasFactory,
    	SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'exam_classes';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'exam_id',
        'class_id',
        'group_id',
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

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id')
            ->select([ 'id', 'name' ]);
    }

    public function group()
    {
        return $this->belongsTo(Group::class)
            ->select([ 'id', 'name' ]);
    }

    public function examSchedule()
    {
        return $this->hasMany(ExamSchedule::class, 'exam_class_id');
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    public static function booted()
    {
        static::addGlobalScope(new HasExam);
        static::addGlobalScope(new HasClass);
        static::addGlobalScope(new HasGroup);
    }
}
