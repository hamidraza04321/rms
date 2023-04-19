<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserClassPermission extends Model
{
    use HasFactory;

    protected $table = 'user_class_permissions';
    protected $fillable = [ 'class_id', 'user_id' ];
    protected $guarded = [ 'id', 'created_at', 'updated_at' ];

    public function sectionPermissions()
    {
    	return $this->hasMany(UserClassSectionPermission::class, 'class_permission_id');
    }

    public function groupPermissions()
    {
    	return $this->hasMany(UserClassGroupPermission::class, 'class_permission_id');
    }

    public function subjectPermissions()
    {
    	return $this->hasMany(UserClassSubjectPermission::class, 'class_permission_id');
    }
}
