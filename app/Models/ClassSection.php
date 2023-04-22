<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassSection extends Model
{
    use HasFactory,
    	SoftDeletes;

    protected $table = 'class_sections';
    protected $fillable = [ 'class_id', 'section_id' ];
    protected $guarded = [ 'id', 'created_at', 'updated_at' ];

    public function section()
    {
    	return $this->belongsTo(Section::class)->withDefault();
    }
}
