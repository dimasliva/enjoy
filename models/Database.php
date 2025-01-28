<?php


// Класс для управления подключением к базе данных
class Database
{
    private static $connection = null;

    public static function getConnection()
    {
        if (self::$connection === null) {
            // Настройте параметры подключения
            $host = DB_HOST;
            $user = DB_USER;
            $password = DB_PASS;
            $database = DB_NAME;

            self::$connection = new mysqli($host, $user, $password, $database);

            // Проверка на ошибки подключения
            if (self::$connection->connect_error) {
                die("Connection failed: " . self::$connection->connect_error);
            }
        }

        return self::$connection;
    }
}
