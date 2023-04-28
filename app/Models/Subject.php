<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ActiveScopeTrait;

class Subject extends Model
{
    use HasFactory,
    	SoftDeletes,
    	ActiveScopeTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'subjects';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 
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

    public function subjectClasses()
    {
    	return $this->hasMany(ClassSubject::class, 'subject_id');
    }
}
