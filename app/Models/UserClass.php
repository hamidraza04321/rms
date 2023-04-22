<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserClass extends Model
{
    use HasFactory;

    protected $table = 'user_classes';
    protected $fillable = [ 'class_id', 'user_id' ];
    protected $guarded = [ 'id', 'created_at', 'updated_at' ];
}
