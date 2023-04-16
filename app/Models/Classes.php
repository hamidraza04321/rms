<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ActiveScopeTrait;

class Classes extends Model
{
    use HasFactory,
    	SoftDeletes,
        ActiveScopeTrait;

    protected $table = 'classes';
    protected $fillable = [ 'id', 'name', 'is_active' ];
    protected $guarded = [ 'id', 'created_at', 'updated_at' ];

    public function sections()
    {
    	return $this->hasMany(ClassSection::class, 'class_id');
    }

    public function groups()
    {
    	return $this->hasMany(ClassGroup::class, 'class_id');
    }
}
