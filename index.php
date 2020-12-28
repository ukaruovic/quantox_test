<?php

use App\Models\Db\Students;
use App\Models\Board;
use App\Common\Export;

require __DIR__.'/vendor/autoload.php';

$id = isset($_GET['student']) ? intval($_GET['student']) : 0;

$students = new Students();

if($id > 0) {
    $student = $students->find($id);

    if($student) {
        $board = new Board($student);
        $export = $board->makeExport(new Export());
        $export->output();
    } else {
        echo 'No Student found.';
    }
} else {
    $students = $students->all();

    include __DIR__ . '/app/Views/student-list.php';
}
