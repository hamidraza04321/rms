<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\UserClassPermission;
use App\Models\UserClassGroupPermission;

class ClassGroup extends Model
{
    use HasFactory,
    	SoftDeletes;

    protected $table = 'class_groups';
    protected $fillable = [ 'class_id', 'group_id' ];
    protected $guarded = [ 'id', 'created_at', 'updated_at' ];

    public function group()
    {
    	return $this->belongsTo(Group::class);
    }

    public function hasGroupPermission($user_id)
    {
        // Get class permission Id
        $class_permission_id = UserClassPermission::where([
            'class_id' => $this->class_id,
            'user_id' => $user_id
        ])->value('id');

        // Check permission for group
        return UserClassGroupPermission::where([
            'class_permission_id' => $class_permission_id,
            'group_id' => $this->group_id
        ])->exists();
    }
}
