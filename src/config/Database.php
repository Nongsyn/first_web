<?
class Databases {
    private string $host = "127.0.0.1";
    private string $db = "studentdb";
    private string $user = "root";
    private string $pass = "1234";

    public function connect(): PDO {
        $host = getenv('DB_HOST') ?: $this->host;
        $port = getenv('DB_PORT') ?: '3307';
        $conn = "mysql:host={$host};port={$port};dbname={$this->db};charset=utf8mb4";

        return new PDO(
            $conn,
            $this->user,
            $this->pass,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
    }
}
?>