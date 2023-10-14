<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ActiveScopeTrait;

class AttendanceStatus extends Model
{
    use HasFactory,
    	SoftDeletes,
        ActiveScopeTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'attendance_statuses';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'short_code',
        'color',
        'is_absent',
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
}
