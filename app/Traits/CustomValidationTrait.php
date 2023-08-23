<?php

namespace App\Traits;
use App\Rules\{
    SessionRule,
    ClassRule,
    SectionRule,
    SubjectRule,
    GroupRule,
    UniqueAdmissionNoRule,
    UniqueClassRollNoRule,
    ExamNameRule,
    ExamRule
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
     * Define Rule For Subject.
     *
     * @return array
     */
    public function subjectRule($class_id, $default = 'required')
    {
        return [
            $default,
            new SubjectRule($class_id)
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
    public function uniqueRollNoRule($class_id, $session_id = null, $student_id = null)
    {
        return [
            'required',
            'max:20',
            new UniqueClassRollNoRule($class_id, $session_id, $student_id) // $student_id For ignore in update
        ];
    }

    /**
     * Define Rule For Exam Name.
     *
     * @return array
     */
    public function examNameRule($session_id, $exam_id = null)
    {
        return [
            'required',
            'max:30',
            new ExamNameRule($session_id, $exam_id)
        ];
    }

    /**
     * Define Rule For Exam.
     *
     * @return array
     */
    public function examRule($session_id = null, $default = 'required')
    {
        return [
            $default,
            new ExamRule($session_id)
        ];
    }
}