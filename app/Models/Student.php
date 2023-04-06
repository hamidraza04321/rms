<?php

namespace App\Models;

use App\Traits\ActiveRecords;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory,
    	SoftDeletes,
    	ActiveRecords;

    protected $table = 'students';
    protected $fillable = [ 'is_active' ];
    protected $guarded = [ 'id', 'created_at', 'updated_at' ];
}
