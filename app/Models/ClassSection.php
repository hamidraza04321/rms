<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ClassSection extends Model
{
    use HasFactory,
    	SoftDeletes;

    protected $table = 'classes';
    protected $fillable = [ 'id', 'class_id', 'section_id', 'created_by', 'updated_by', 'deleted_by' ];
    protected $guarded = [ 'id', 'created_at', 'updated_at' ];
}
