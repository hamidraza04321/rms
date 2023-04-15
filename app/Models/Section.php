<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ActiveRecords;

class Section extends Model
{
    use HasFactory,
    	SoftDeletes,
    	ActiveRecords;

    protected $table = 'sections';
    protected $fillable = [ 'id', 'name', 'is_active', 'created_by', 'updated_by' ];
    protected $guarded = [ 'id', 'created_at', 'updated_at' ];

    public function sectionClasses()
    {
    	return $this->hasMany(ClassSection::class, 'section_id');
    }
}
