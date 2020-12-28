<?php

require __DIR__.'/vendor/autoload.php';

$db = new \App\Models\Db\Db();
$pdo = $db->getPdo();

$commands = [
    'DROP TABLE IF EXISTS student_grades',
    'DROP TABLE IF EXISTS students',
    'CREATE TABLE IF NOT EXISTS students (
                        id  INTEGER PRIMARY KEY AUTOINCREMENT,
                        name VARCHAR (255) DEFAULT NULL,
                        board_type VARCHAR (255) DEFAULT "SCM"
                      )',
    'CREATE TABLE IF NOT EXISTS student_grades (
                    id   INTEGER PRIMARY KEY AUTOINCREMENT,
                    student_id  INTEGER NOT NULL,
                    grade  REAL DEFAULT(0),
                    FOREIGN KEY (student_id)
                    REFERENCES students(student_id) ON UPDATE CASCADE
                                                    ON DELETE CASCADE)',
    "INSERT INTO students (name, board_type)
        VALUES
            ('Petar Petrovic', 'CSM'),
            ('Nikola Nikolic', 'CSM'),
            ('Milos Milosevic', 'CSM'),
            ('Milan Milanovic', 'CSM'),
            ('John Doe', 'CSMB'),
            ('Jane Doe', 'CSMB'),
            ('Gracie Weber', 'CSMB'),
            ('Michael Johnson', 'CSMB')
    ",
    "INSERT INTO student_grades (student_id, grade)
        VALUES
            (1, 6),
            (1, 6),
            (1, 7),
            
            (2, 9),
            (2, 9),
            (2, 7),
            (2, 6),
            
            (3, 5),
            (3, 6),
            (3, 7),
            (3, 9),
            
            (5, 7),
            (5, 6),
            (5, 6),
            (5, 9),
            
            (6, 6),
            (6, 7),
            (6, 8),
            
            (7, 9),
            (7, 9)
            "
];


foreach ($commands as $command) {
    $pdo->exec($command);
}