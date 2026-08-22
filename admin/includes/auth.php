<?php
/**
 * Session-based auth guard for the admin panel. Include this (after db.php)
 * at the top of every protected admin page.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/admin/',
        'httponly' => true,
        'samesite' => 'Lax',
        'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
    ]);
    session_start();
}

function current_admin_username(): ?string {
    return $_SESSION['admin_username'] ?? null;
}

function is_logged_in(): bool {
    return isset($_SESSION['admin_id']);
}

function require_login(): void {
    if (!is_logged_in()) {
        header('Location: login.php');
        exit;
    }
}

function login_admin(int $id, string $username): void {
    // Regenerate the session id on login to prevent session fixation.
    session_regenerate_id(true);
    $_SESSION['admin_id'] = $id;
    $_SESSION['admin_username'] = $username;
}

function logout_admin(): void {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie('PHPSESSID', '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
    session_destroy();
}
