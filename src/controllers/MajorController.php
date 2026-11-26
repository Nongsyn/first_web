
<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Major.php';

class MajorController {

    private Major $major;

    public function __construct() {

        $database = new Databases();
        $db = $database->connect();

        $this->major = new Major($db);
    }

    public function index(): void {

        $majors = $this->major->getAllMajors();

        require __DIR__ . '/../views/Student/Major.php';
    }
}

?>
