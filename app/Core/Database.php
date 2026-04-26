<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $pdo = null;

    public static function getConnection(array $config): PDO
    {
        if (self::$pdo !== null) {
            return self::$pdo;
        }

        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=%s',
            $config['host'],
            $config['port'],
            $config['name'],
            $config['charset']
        );

        try {
            self::$pdo = new PDO($dsn, $config['user'], $config['pass'], [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            error_log('DB connection error: ' . $e->getMessage());
            throw $e;
        }

        return self::$pdo;
    }
}


// !! WERSJA DLA HOSTINGU:
// <?php

// namespace App\Core;

// use PDO;
// use PDOException;

// class Database
// {
//     private static ?PDO $pdo = null;

//     public static function getConnection(array $config): PDO
//     {
//         if (self::$pdo !== null) {
//             return self::$pdo;
//         }

//         // POPRAWNY DSN — tylko 2 argumenty!
//         $dsn = sprintf(
//             'mysql:unix_socket=/run/mysqld/mysqld.sock;dbname=%s;charset=%s',
//             $config['name'],
//             $config['charset']
//         );

//         try {
//             self::$pdo = new PDO($dsn, $config['user'], $config['pass'], [
//                 PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
//                 PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//                 PDO::ATTR_EMULATE_PREPARES   => false,
//             ]);
//         } catch (PDOException $e) {
//             error_log('DB connection error: ' . $e->getMessage());
//             throw $e;
//         }

//         return self::$pdo;
//     }
// }
