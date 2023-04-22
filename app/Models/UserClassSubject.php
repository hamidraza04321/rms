<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserClassSubject extends Model
{
    use HasFactory;

    protected $table = 'user_class_subjects';
    protected $fillable = [ 'class_subject_id', 'user_id' ];
    protected $guarded = [ 'id', 'created_at', 'updated_at' ];
}
