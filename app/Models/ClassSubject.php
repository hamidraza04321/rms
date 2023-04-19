<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\UserClassPermission;
use App\Models\UserClassSubjectPermission;

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

    public function hasSubjectPermission($user_id)
    {
        // Get class permission Id
        $class_permission_id = UserClassPermission::where([
            'class_id' => $this->class_id,
            'user_id' => $user_id
        ])->value('id');

        // Check permission for subject
        return UserClassSubjectPermission::where([
            'class_permission_id' => $class_permission_id,
            'subject_id' => $this->subject_id
        ])->exists();
    }
}
