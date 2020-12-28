<?php

namespace App\Models\Db;

use App\Models\Student as Student;

class Students extends Db
{
    protected $table = 'students';

    public function find($id)
    {
        return $this->loadStudent(parent::find($id));
    }

    public function all()
    {
        $all = parent::getAll();

        $students = [];

        if(count($all)) {
            foreach ($all as $studentData) {
                $students[] = $this->loadStudent($studentData);
            }
        }

        return $students;
    }

    private function loadStudent($studentData = null)
    {
        $student = null;

        if($studentData) {
            $student = new Student($studentData);

            $sGrades = new StudentGrades();
            $student->setGrades($sGrades->getByStudentId($student->getId()));
        }

        return $student;
    }
}