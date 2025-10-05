<?php

namespace Database;

class MyPdo extends \PDO
{
    private static ?self $instance = null;

    public static function getInstance(): self
    {
        if (null === self::$instance) {
            self::$instance = new self('mysql:host=127.0.0.1;dbname=symplyNote;charset=utf8mb4', 'root', '');
        }

        return self::$instance;
    }
}
