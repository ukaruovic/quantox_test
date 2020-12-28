<?php

namespace App\Models;

class Board
{
    private $student;
    private $grades = [];
    private $boardType;

    public function __construct(Student $student)
    {
        $this->student = $student;
        $this->grades = $student->getGrades();
        $this->setBoardType($student->getBoardType());
    }

    public function setBoardType($type)
    {
        $this->boardType = strtoupper($type);
    }

    public function getBoardType()
    {
        return $this->boardType;
    }

    public function makeExport(\App\Common\Export $export)
    {
        $export->setData($this->getResults());

        if($this->getBoardType() == 'CSM') {
            return $export->toJson();
        } elseif($this->getBoardType() == 'CSMB') {
            return $export->toXml();
        }

        return $export;
    }

    public function getResults()
    {
        return [
            'id' => $this->student->getId(),
            'name' => $this->student->getName(),
            'grades' => $this->student->getGrades(),
            'average' => $this->getAvgGrade(),
            'result' => $this->pass() ? 'PASS' : 'FAIL',
        ];
    }

    public function getAvgGrade()
    {
        $numOfGrades = count($this->grades);
        return $numOfGrades > 0 ? round(array_sum($this->grades)/$numOfGrades, 2) : 0;
    }

    public function pass()
    {
        if($this->boardType == 'CSM') {
            return $this->passCsm();
        } elseif($this->boardType == 'CSMB') {
            return $this->passCsmb();
        }

        return false;
    }

    private function passCsm()
    {
        if($this->getAvgGrade($this->grades) >= 7) {
            return true;
        }
        return false;
    }

    private function passCsmb()
    {
        if(count($this->grades) && max($this->grades) > 8) {
            return true;
        }
        return false;
    }
}