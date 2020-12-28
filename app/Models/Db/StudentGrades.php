<?php

namespace App\Models\Db;

class StudentGrades extends Db
{
    protected $table = 'student_grades';

    public function getByStudentId($studentId)
    {
        return parent::getBy('student_id', $studentId);
    }
}