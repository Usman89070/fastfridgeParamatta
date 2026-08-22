<?php
/**
 * Copy this file to config.php (same folder) and fill in your real
 * Hostinger MySQL credentials. Create the database first in
 * hPanel -> Databases -> MySQL Databases, then import database/schema.sql
 * into it via phpMyAdmin before the admin panel will work.
 *
 * config.php is listed in .gitignore on purpose - never commit real
 * database credentials to git.
 */
return [
    'driver'   => 'mysql',
    'host'     => 'localhost',
    'database' => 'u123456789_fridgeblog',
    'username' => 'u123456789_dbuser',
    'password' => 'replace-with-your-database-password',
    'charset'  => 'utf8mb4',
];
