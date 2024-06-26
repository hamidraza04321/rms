<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Scopes\HasUserClassSubject;
use App\Models\Scopes\HasSubject;

class ClassSubject extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'class_subjects';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
    	'class_id',
    	'subject_id'
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
            ->select(['id', 'name']);
    }

    public function userClassSubject()
    {
        return $this->belongsTo(UserClassSubject::class, 'id', 'class_subject_id')
            ->where('user_id', auth()->id());
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new HasSubject);
        static::addGlobalScope(new HasUserClassSubject);
    }
}
