<?php
class Database
{
    private const USERNAME = "root";
    private const PASSWORD = "";
    private const DTBNAME = "web_trang_suc";

    public function __construct()
    {
    }

    public function connect()
    {
        try {
            $dtb = new PDO('mysql:host=localhost;dbname=' . self::DTBNAME, self::USERNAME, self::PASSWORD);
            return $dtb;
        } catch (PDOException $e) {
            // Log or handle the error
            error_log('Database connection error: ' . $e->getMessage());
            throw new Exception('Database connection failed');
            die();
        }
    }
}
