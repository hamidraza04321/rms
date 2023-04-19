<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ActiveScopeTrait;
use App\Models\UserClassPermission;
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

    public function hasClassPermission($user_id)
    {
        return UserClassPermission::where([
            'class_id' => $this->id,
            'user_id' => $user_id
        ])->exists();
    }
}
