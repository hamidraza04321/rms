<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ActiveRecords;

class Classes extends Model
{
    use HasFactory,
    	SoftDeletes,
    	ActiveRecords;

    protected $table = 'classes';
    protected $fillable = [ 'id', 'name', 'is_active' ];
    protected $guarded = [ 'id', 'created_at', 'updated_at' ];
}
