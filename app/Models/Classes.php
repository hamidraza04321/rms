<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ActiveScopeTrait;
use App\Models\UserClass;
use Auth;

class Classes extends Model
{
    use HasFactory,
    	SoftDeletes,
        ActiveScopeTrait;

    protected $table = 'classes';
    protected $fillable = [ 'id', 'name', 'is_active', 'created_by', 'updated_by' ];
    protected $guarded = [ 'id', 'created_at', 'updated_at' ];

    public function sections()
    {
    	return $this->hasMany(ClassSection::class, 'class_id')
            ->has('section');
    }

    public function groups()
    {
    	return $this->hasMany(ClassGroup::class, 'class_id')
            ->has('group');
    }

    public function subjects()
    {
        return $this->hasMany(ClassSubject::class, 'class_id')
            ->has('subject');
    }

    // public function hasAllPermission($user_id)
    // {
    //     // Pluck section, group, and section ids of class in array
    //     $class_sections = $this->sections->pluck('section_id')->toArray();
    //     $class_subjects = $this->subjects->pluck('subject_id')->toArray();
    //     $class_groups = $this->groups->pluck('group_id')->toArray();

    //     // Get user permissions
    //     $permissions = UserClassPermission::where([
    //         'class_id' => $this->id,
    //         'user_id' => $user_id
    //     ])->first();

    //     // Pluck section, group, and section ids of class in array
    //     $section_permissions = $permissions?->sectionPermissions->pluck('section_id')->toArray();
    //     $subject_permissions = $permissions?->subjectPermissions->pluck('subject_id')->toArray();
    //     $group_permissions = $permissions?->groupPermissions->pluck('group_id')->toArray();

    //     // Match two array and store in $permission variable
    //     $permission[] = ($class_sections == $section_permissions);
    //     $permission[] = ($class_subjects == $subject_permissions);
    //     $permission[] = ($class_groups == $group_permissions);

    //     if ($this->id == 10) {
    //         dd($group_permissions);
    //     }

    //     return !in_array(false, $permission);
    // }
}
