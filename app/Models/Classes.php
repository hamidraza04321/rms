<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ActiveScopeTrait;
use App\Models\Scopes\HasUserClass;

class Classes extends Model
{
    use HasFactory,
    	SoftDeletes,
        ActiveScopeTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'classes';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 
        'is_active',
        'created_by',
        'updated_by'
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

    public function sections()
    {
    	return $this->hasMany(ClassSection::class, 'class_id');
    }

    public function groups()
    {
    	return $this->hasMany(ClassGroup::class, 'class_id');
    }

    public function subjects()
    {
        return $this->hasMany(ClassSubject::class, 'class_id');
    }

    public function userClass()
    {
        return $this->belongsTo(UserClass::class, 'id', 'class_id')
            ->where('user_id', auth()->id());
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    public static function booted()
    {
        static::addGlobalScope(new HasUserClass);
    }
}
