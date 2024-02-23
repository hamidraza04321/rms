<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\ActiveScopeTrait;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, ActiveScopeTrait, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userDetail()
    {
        return $this->belongsTo(UserDetail::class, 'id', 'user_id');
    }

    public function classes()
    {
        return $this->belongsToMany(Classes::class, 'user_classes', 'user_id', 'class_id')
            ->withTimestamps();
    }

    public function classSections()
    {
        return $this->belongsToMany(ClassSection::class, 'user_class_sections', 'user_id', 'class_section_id')
            ->withTimestamps();
    }

    public function classSubjects()
    {
        return $this->belongsToMany(ClassSubject::class, 'user_class_subjects', 'user_id', 'class_subject_id')
            ->withTimestamps();
    }

    public function classGroups()
    {
        return $this->belongsToMany(ClassGroup::class, 'user_class_groups', 'user_id', 'class_group_id')
            ->withTimestamps();
    }
}
