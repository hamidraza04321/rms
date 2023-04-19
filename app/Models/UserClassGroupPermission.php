<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserClassGroupPermission extends Model
{
    use HasFactory;

    protected $table = 'user_class_group_permissions';
    protected $fillable = [ 'class_permission_id', 'group_id' ];
    protected $guarded = [ 'id', 'created_at', 'updated_at' ];
}
