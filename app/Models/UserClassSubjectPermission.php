<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserClassSubjectPermission extends Model
{
    use HasFactory;

    protected $table = 'user_class_subject_permissions';
    protected $fillable = [ 'class_permission_id', 'subject_id' ];
    protected $guarded = [ 'id', 'created_at', 'updated_at' ];
}
