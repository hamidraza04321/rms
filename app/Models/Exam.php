<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ActiveScopeTrait;
use App\Traits\CurrentSessionTrait;
use App\Models\Scopes\HasSession;

class Exam extends Model
{
    use HasFactory,
    	SoftDeletes,
        ActiveScopeTrait,
        CurrentSessionTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'exams';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'session_id',
        'name',
        'description',
        'is_active',
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

    public function session()
    {
        return $this->belongsTo(Session::class)
            ->select([ 'id', 'name' ]);
    }

    public function classes()
    {
        return $this->hasMany(ExamClass::class, 'exam_id');
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    public static function booted()
    {
        static::addGlobalScope(new HasSession);
    }
}
