<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserClassSectionPermission extends Model
{
    use HasFactory;

    protected $table = 'user_class_section_permissions';
    protected $fillable = [ 'class_permission_id', 'section_id' ];
    protected $guarded = [ 'id', 'created_at', 'updated_at' ];
}
