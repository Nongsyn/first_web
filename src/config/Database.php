
<?php

class Databases {

    private string $host = "127.0.0.1";
    private string $dbname = "studentdb";
    private string $username = "root";
    private string $password = "1234";

    public function connect(): PDO {

        try {

            $conn = new PDO(
                "mysql:host={$this->host};port=3307;dbname={$this->dbname};charset=utf8mb4",
                $this->username,
                $this->password
            );

            $conn->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            return $conn;

        } catch (PDOException $e) {

            die("Database Connection Error: " . $e->getMessage());
        }
    }
}

?>
