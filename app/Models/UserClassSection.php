<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserClassSection extends Model
{
    use HasFactory;

    protected $table = 'user_class_sections';
    protected $fillable = [ 'class_section_id', 'user_id' ];
    protected $guarded = [ 'id', 'created_at', 'updated_at' ];
}
