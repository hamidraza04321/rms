<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\UserClassPermission;
use App\Models\UserClassGroup;

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
}
