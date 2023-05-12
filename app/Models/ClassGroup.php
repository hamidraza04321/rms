<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Scopes\HasClassGroup;
use App\Models\Scopes\HasUserClassGroup;

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
            ->select([ 'id', 'name' ]);
    }

    public function userClassGroup()
    {
        return $this->belongsTo(UserClassGroup::class, 'id', 'class_group_id')
            ->where('user_id', auth()->id());
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new HasClassGroup);
        static::addGlobalScope(new HasUserClassGroup);
    }
}
