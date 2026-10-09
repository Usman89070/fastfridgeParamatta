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

$id = isset($_POST['id']) ? (int)$_POST['id'] : null;
$title = trim($_POST['title'] ?? '');
$slugInput = trim($_POST['slug'] ?? '');
$metaDescription = trim($_POST['meta_description'] ?? '');
$excerpt = trim($_POST['excerpt'] ?? '');
$content = trim($_POST['content'] ?? '');
$readTime = max(1, min(60, (int)($_POST['read_time_minutes'] ?? 5)));
$status = ($_POST['status'] ?? 'draft') === 'published' ? 'published' : 'draft';
$publishedAt = trim($_POST['published_at'] ?? '') ?: date('Y-m-d');

function fail(string $message, ?int $id): void {
    $_SESSION['flash_error'] = $message;
    $target = $id ? "post-form.php?id={$id}" : 'post-form.php';
    header("Location: {$target}");
    exit;
}

if ($title === '') {
    fail('Title is required.', $id);
}
if ($content === '') {
    fail('Post content is required.', $id);
}

if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $publishedAt)) {
    fail('Invalid publish date.', $id);
}

$db = get_db();

if ($slugInput !== '') {
    // Admin explicitly typed a slug - always honour it.
    $slug = slugify($slugInput);
} elseif ($id) {
    // Editing an existing post with the slug field left blank: keep its
    // current URL stable even if the title changed, so existing links and
    // search rankings aren't silently broken.
    $stmt = $db->prepare('SELECT slug FROM blog_posts WHERE id = ?');
    $stmt->execute([$id]);
    $slug = $stmt->fetchColumn() ?: slugify($title);
} else {
    // New post, no slug typed - derive one from the title.
    $slug = slugify($title);
}

$content = sanitize_post_content($content);

// Make sure the slug is unique (append -2, -3, ... if it collides with a
// different post).
$baseSlug = $slug;
$suffix = 2;
while (true) {
    $stmt = $db->prepare('SELECT id FROM blog_posts WHERE slug = ?' . ($id ? ' AND id != ?' : ''));
    $params = $id ? [$slug, $id] : [$slug];
    $stmt->execute($params);
    if (!$stmt->fetch()) {
        break;
    }
    $slug = $baseSlug . '-' . $suffix;
    $suffix++;
}

// Handle featured image upload. When editing and no new file is chosen,
// always keep whatever image is already on the post in the database -
// never trust a client-submitted "existing image" value for this, so a
// missing/tampered hidden field can't silently wipe the image.
$featuredImage = '';
if ($id) {
    $stmt = $db->prepare('SELECT featured_image FROM blog_posts WHERE id = ?');
    $stmt->execute([$id]);
    $featuredImage = $stmt->fetchColumn() ?: '';
}
if (!empty($_FILES['featured_image']['name'])) {
    $uploaded = handle_featured_image_upload($_FILES['featured_image'], $slug);
    if ($uploaded === null) {
        fail('Image upload failed: use a JPG, PNG or WEBP file under 5MB.', $id);
    }
    if ($featuredImage !== '' && $featuredImage !== $uploaded) {
        delete_featured_image_file($featuredImage);
    }
    $featuredImage = $uploaded;
}

if ($id) {
    $stmt = $db->prepare(
        'UPDATE blog_posts SET slug = ?, title = ?, meta_description = ?, excerpt = ?, content = ?, featured_image = ?, read_time_minutes = ?, status = ?, published_at = ? WHERE id = ?'
    );
    $stmt->execute([$slug, $title, $metaDescription, $excerpt, $content, $featuredImage, $readTime, $status, $publishedAt, $id]);
    $_SESSION['flash_success'] = 'Post updated.';
} else {
    $stmt = $db->prepare(
        'INSERT INTO blog_posts (slug, title, meta_description, excerpt, content, featured_image, read_time_minutes, status, published_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
    );
    $stmt->execute([$slug, $title, $metaDescription, $excerpt, $content, $featuredImage, $readTime, $status, $publishedAt]);
    $_SESSION['flash_success'] = 'Post created.';
}

header('Location: index.php');
exit;

/**
 * Validates and stores an uploaded featured image under /image/blog/,
 * returning the site-relative path to store in the database, or null on
 * validation failure. Re-encodes the image via GD rather than trusting the
 * upload bytes outright, and never trusts the client-supplied extension or
 * MIME type for deciding what to write.
 */
function handle_featured_image_upload(array $file, string $slug): ?string {
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }
    if ($file['size'] > 5 * 1024 * 1024) {
        return null;
    }

    $info = @getimagesize($file['tmp_name']);
    if ($info === false) {
        return null;
    }

    $mime = $info['mime'];
    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
    ];
    if (!isset($allowed[$mime])) {
        return null;
    }
    $ext = $allowed[$mime];

    switch ($mime) {
        case 'image/jpeg':
            $image = @imagecreatefromjpeg($file['tmp_name']);
            break;
        case 'image/png':
            $image = @imagecreatefrompng($file['tmp_name']);
            break;
        case 'image/webp':
            $image = @imagecreatefromwebp($file['tmp_name']);
            break;
        default:
            $image = false;
    }
    if ($image === false) {
        return null;
    }

    $targetDir = __DIR__ . '/../image/blog';
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    $filename = $slug . '-' . bin2hex(random_bytes(4)) . '.' . $ext;
    $targetPath = $targetDir . '/' . $filename;

    $saved = match ($mime) {
        'image/jpeg' => imagejpeg($image, $targetPath, 85),
        'image/png' => imagepng($image, $targetPath, 6),
        'image/webp' => imagewebp($image, $targetPath, 85),
        default => false,
    };
    imagedestroy($image);

    if (!$saved) {
        return null;
    }

    return 'image/blog/' . $filename;
}
