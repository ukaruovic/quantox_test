<?php

namespace App\Models;

class Student
{
    private $id;
    private $name = '';
    private $board_type = '';
    private $grades = [];

    public function __construct(array $data)
    {
        $this->setAttr($data, 'id');
        $this->setAttr($data, 'name');
        $this->setAttr($data, 'board_type');

        if(isset($data['grades']) && is_array($data['grades'])) {
            $this->setGrades($data['grades']);
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getBoardType()
    {
        return strtoupper($this->board_type);
    }

    public function getGrades()
    {
        return $this->grades;
    }

    public function setGrades(Array $grades = [])
    {
        $this->grades = [];
        if(count($grades)) {
            foreach ($grades as $row) {
                $this->grades[] = isset($row['grade']) ? $row['grade'] : 0;
            }
        }
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'grades' => $this->grades
        ];
    }

    private function setAttr($array, $key)
    {
        $this->$key = isset($array[$key]) ? $array[$key] : '';
    }
}