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

    protected $table = 'subjects';
    protected $fillable = [ 'id', 'name', 'is_active', 'created_by', 'updated_by' ];
    protected $guarded = [ 'id', 'created_at', 'updated_at' ];

    public function subjectClasses()
    {
    	return $this->hasMany(ClassSubject::class, 'subject_id');
    }
}
