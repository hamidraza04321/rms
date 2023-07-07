<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use DDZobov\PivotSoftDeletes\Model;
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
    	return $this->belongsToMany(ClassSection::class, 'class_sections', 'class_id', 'section_id')
            ->withSoftDeletes()
            ->withTimestamps();
    }

    public function groups()
    {
    	return $this->belongsToMany(ClassGroup::class, 'class_groups', 'class_id', 'group_id')
            ->withSoftDeletes()
            ->withTimestamps();
    }

    public function subjects()
    {
        return $this->belongsToMany(ClassSubject::class, 'class_subjects', 'class_id', 'subject_id')
            ->withSoftDeletes()
            ->withTimestamps();
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
