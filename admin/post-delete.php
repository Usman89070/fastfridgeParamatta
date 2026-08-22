<?php
require __DIR__ . '/includes/db.php';
require __DIR__ . '/includes/auth.php';
require __DIR__ . '/includes/functions.php';

require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

csrf_verify();

$id = (int)($_POST['id'] ?? 0);
if ($id > 0) {
    $db = get_db();

    $stmt = $db->prepare('SELECT featured_image FROM blog_posts WHERE id = ?');
    $stmt->execute([$id]);
    $post = $stmt->fetch();

    $stmt = $db->prepare('DELETE FROM blog_posts WHERE id = ?');
    $stmt->execute([$id]);

    if ($post && !empty($post['featured_image'])) {
        delete_featured_image_file($post['featured_image']);
    }

    $_SESSION['flash_success'] = 'Post deleted.';
}

header('Location: index.php');
exit;
