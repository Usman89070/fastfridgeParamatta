<?php
/**
 * PDO database connection, shared by every admin page and by the public
 * blog.php / blog-post.php pages.
 */

function get_db(): PDO {
    static $db = null;
    if ($db !== null) {
        return $db;
    }

    $configFile = __DIR__ . '/config.php';
    if (!file_exists($configFile)) {
        http_response_code(500);
        die('Database not configured. Copy admin/includes/config.example.php to admin/includes/config.php and fill in your Hostinger MySQL credentials, then import database/schema.sql.');
    }

    $config = require $configFile;
    $driver = $config['driver'] ?? 'mysql';

    if ($driver === 'sqlite') {
        // Local/testing only - production always uses mysql.
        $dsn = 'sqlite:' . $config['path'];
    } else {
        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=%s',
            $config['host'],
            $config['database'],
            $config['charset'] ?? 'utf8mb4'
        );
    }

    try {
        $db = new PDO(
            $dsn,
            $config['username'] ?? null,
            $config['password'] ?? null,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );
    } catch (PDOException $e) {
        http_response_code(500);
        die('Database connection failed. Double-check admin/includes/config.php credentials.');
    }

    return $db;
}
