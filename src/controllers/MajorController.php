<?php
    require_once __DIR__ . '/../config/Database.php';
    require_once __DIR__ . '/../models/student.php';

    class StudentController {
        private Student $student;

        public function __construct() {
            $database = new Databases();
            $db = $database->connect();

            $this->student = new Student($db);
        }   

        public function index(): void {
            $students = $this->student->getAllStudents();
            require_once __DIR__ . '/../views/Student/index.php';
        }
    }
?>