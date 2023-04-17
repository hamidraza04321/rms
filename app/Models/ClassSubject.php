<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassSubject extends Model
{
    use HasFactory,
    	SoftDeletes;

    protected $table = 'class_subjects';
    protected $fillable = [ 'class_id', 'subject_id' ];
    protected $guarded = [ 'id', 'created_at', 'updated_at' ];

    public function subject()
    {
    	return $this->belongsTo(Subject::class);
    }
}