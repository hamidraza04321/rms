<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\UserClassPermission;
use App\Models\UserClassSectionPermission;

class ClassSection extends Model
{
    use HasFactory,
    	SoftDeletes;

    protected $table = 'class_sections';
    protected $fillable = [ 'class_id', 'section_id' ];
    protected $guarded = [ 'id', 'created_at', 'updated_at' ];

    public function section()
    {
    	return $this->belongsTo(Section::class)->withDefault();
    }

    public function hasSectionPermission($user_id)
    {
        // Get class permission Id
        $class_permission_id = UserClassPermission::where([
            'class_id' => $this->class_id,
            'user_id' => $user_id
        ])->value('id');

        // Check permission for section
        return UserClassSectionPermission::where([
            'class_permission_id' => $class_permission_id,
            'section_id' => $this->section_id
        ])->exists();
    }
}
