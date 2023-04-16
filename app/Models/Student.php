<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ActiveScopeTrait;

class Student extends Model
{
    use HasFactory,
    	SoftDeletes,
        ActiveScopeTrait;

    protected $table = 'students';
    protected $fillable = [ 'is_active' ];
    protected $guarded = [ 'id', 'created_at', 'updated_at' ];
}
