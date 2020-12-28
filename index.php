<?php

use App\Models\Db\Students;

require __DIR__.'/vendor/autoload.php';

$id = isset($_GET['student']) ? intval($_GET['student']) : 0;

$students = new Students();

if($id > 0) {
    $student = $students->find($id);

    print_r($student->toArray());
} else {
    $students = $students->all();

    include __DIR__ . '/app/Views/student-list.php';
}
