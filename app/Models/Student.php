<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'students';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
    	'admission_no',
    	'roll_no',
    	'class_id',
    	'section_id',
    	'group_id',
    	'first_name',
    	'last_name',
    	'gender',
    	'dob',
    	'religion',
    	'caste',
    	'mobile_no',
    	'email',
    	'admission_date',
    	'student_image',

    	// Father Details
        'father_name',
        'father_email',
    	'father_cnic',
    	'father_phone',
        'father_occupation',
    	'father_image',

    	// Mother Details
    	'mother_name',
        'mother_email',
        'mother_cnic',
        'mother_phone',
        'mother_occupation',
        'mother_image',

    	// Guardian Details
    	'guardian_is',
    	'guardian_name',
        'guardian_email',
    	'guardian_cnic',
    	'guardian_phone',
    	'guardian_relation',
    	'guardian_occupation',
    	'guardian_image',

    	// Address
    	'current_address',
    	'permenant_address',

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

    protected $dates = [
        'dob',
        'admission_date'
    ];

    /**
     * Get the Student full name.
     */
    public function fullName()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
