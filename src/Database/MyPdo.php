<?php

namespace Database;
use PDO;

class MyPdo extends PDO
{
    private static ?self $instance = null;

    private const DB_HOST = "localhost";
    private const DB_NAME = "gestion_notes";   // adapte avec ta base
    private const DB_USER = "root";            // par défaut sous XAMPP
    private const DB_PASS = "";                // vide par défaut
    private const DB_CHARSET = "utf8mb4";

    private function __construct()
    {
        $dsn = "mysql:host=" . self::DB_HOST . ";dbname=" . self::DB_NAME . ";charset=" . self::DB_CHARSET;

        parent::__construct($dsn, self::DB_USER, self::DB_PASS);

        // Configuration PDO
        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}