<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Scopes\HasClass;
use App\Models\Scopes\HasSession;
use App\Models\Scopes\HasClassSection;
use App\Models\Scopes\HasClassGroup;
use App\Traits\ActiveScopeTrait;
use Awobaz\Compoships\Compoships;

class StudentSession extends Model
{
    use HasFactory,
        Compoships,
    	SoftDeletes,
        ActiveScopeTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'student_sessions';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'session_id',
        'class_id',
        'section_id',
        'group_id',
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

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function session()
    {
        return $this->belongsTo(Session::class)
            ->select([ 'id', 'name' ]);
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id')
            ->select([ 'id', 'name' ]);
    }

    public function section()
    {
        return $this->belongsTo(Section::class)
            ->select([ 'id', 'name' ]);
    }

    public function group()
    {
        return $this->belongsTo(Group::class)
            ->select([ 'id', 'name' ]);
    }

    public function classSection()
    {
        return $this->belongsTo(ClassSection::class, [ 'class_id', 'section_id' ], [ 'class_id', 'section_id' ]);
    }

    public function classGroup()
    {
        return $this->belongsTo(ClassGroup::class, [ 'class_id', 'group_id' ], [ 'class_id', 'group_id' ]);
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new HasSession);
        static::addGlobalScope(new HasClass);
        static::addGlobalScope(new HasClassSection);
        static::addGlobalScope(new HasClassGroup);
    }
}
