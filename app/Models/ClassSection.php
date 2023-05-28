<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Scopes\HasUserClassSection;
use App\Models\Scopes\HasSection;
use Awobaz\Compoships\Compoships;

class ClassSection extends Model
{
    use HasFactory,
    	SoftDeletes,
        Compoships;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'class_sections';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
    	'class_id',
    	'section_id'
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

    public function section()
    {
    	return $this->belongsTo(Section::class)
            ->select([ 'id', 'name' ]);
    }

    public function userClassSection()
    {
        return $this->belongsTo(UserClassSection::class, 'id', 'class_section_id')
            ->where('user_id', auth()->id());
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new HasSection);
        static::addGlobalScope(new HasUserClassSection);
    }
}
