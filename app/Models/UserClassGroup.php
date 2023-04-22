<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserClassGroup extends Model
{
    use HasFactory;

    protected $table = 'user_class_groups';
    protected $fillable = [ 'class_group_id', 'user_id' ];
    protected $guarded = [ 'id', 'created_at', 'updated_at' ];
}
