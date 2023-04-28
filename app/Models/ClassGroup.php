<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class ClassGroup extends Model
{
    use HasFactory,
    	SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'class_groups';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
    	'class_id',
    	'group_id'
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
    	'id',
    	'created_at',
    	'updated_at'
    ];

    public function group()
    {
    	return $this->belongsTo(Group::class)
            ->select(['id', 'name']);
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('hasGroup', function (Builder $builder) {
            $builder->has('group');
        });
    }
}
