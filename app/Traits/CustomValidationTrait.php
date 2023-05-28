<?php

namespace App\Traits;
use App\Rules\{
    SessionRule,
    ClassRule,
    SectionRule,
    GroupRule,
    UniqueAdmissionNoRule,
    UniqueClassRollNoRule
};

trait CustomValidationTrait
{
    /**
     * Define Rule For Session.
     *
     * @return array
     */
    public function sessionRule($default = 'required')
    {
        return [
            $default,
            new SessionRule
        ];
    }

    /**
     * Define Rule For Class.
     *
     * @return array
     */
    public function classRule($default = 'required')
    {
        return [
            $default,
            new ClassRule
        ];
    }

    /**
     * Define Rule For Section.
     *
     * @return array
     */
    public function sectionRule($class_id, $default = 'required')
    {
        return [
            $default,
            new SectionRule($class_id)
        ];
    }

    /**
     * Define Rule For Group.
     *
     * @return array
     */
    public function groupRule($class_id)
    {
        return [
            'nullable',
            new GroupRule($class_id)
        ];
    }

    /**
     * Define Rule For Student Admission No.
     *
     * @return array
     */
    public function uniqueAdmissionNoRule($student_session_id = null)
    {
        return [
            'required',
            'max:20',
            new UniqueAdmissionNoRule($student_session_id)
        ];
    }

    /**
     * Define Rule For Student Roll No.
     *
     * @return array
     */
    public function uniqueRollNoRule($class_id, $student_id = null, $session_id = null)
    {
        return [
            'required',
            'max:20',
            new UniqueClassRollNoRule($class_id, $student_id, $session_id) // $student_id For ignore in update
        ];
    }
}