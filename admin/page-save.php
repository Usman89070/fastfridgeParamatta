<?php
require __DIR__ . '/includes/db.php';
require __DIR__ . '/includes/auth.php';
require __DIR__ . '/includes/functions.php';

require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: pages.php');
    exit;
}

csrf_verify();

$slug = trim($_POST['slug'] ?? '');

function fail_page(string $message, string $slug): void {
    $_SESSION['flash_error'] = $message;
    header('Location: page-form.php?slug=' . urlencode($slug));
    exit;
}

if ($slug === '') {
    header('Location: pages.php');
    exit;
}

$title = trim($_POST['title'] ?? '');
$h1 = trim($_POST['h1'] ?? '');
$metaDescription = trim($_POST['meta_description'] ?? '');
$ogTitle = trim($_POST['og_title'] ?? '');
$ogDescription = trim($_POST['og_description'] ?? '');
$canonicalUrl = trim($_POST['canonical_url'] ?? '');
$primaryKeyword = trim($_POST['primary_keyword'] ?? '');
$secondaryKeywords = trim($_POST['secondary_keywords'] ?? '');
$robotsMeta = $_POST['robots_meta'] ?? 'index,follow';
$schemaJsonInput = trim($_POST['schema_json'] ?? '');

if ($title === '') {
    fail_page('Meta title is required.', $slug);
}

$allowedRobots = ['index,follow', 'noindex,follow', 'noindex,nofollow'];
if (!in_array($robotsMeta, $allowedRobots, true)) {
    $robotsMeta = 'index,follow';
}

$schemaJson = '';
if ($schemaJsonInput !== '') {
    $decoded = json_decode($schemaJsonInput, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        fail_page('JSON-LD schema is not valid JSON: ' . json_last_error_msg(), $slug);
    }
    // Store it re-encoded (consistent formatting) rather than the raw
    // typed text, so a stray trailing comma a browser's editor fixed up
    // doesn't round-trip oddly.
    $schemaJson = json_encode($decoded, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}

$db = get_db();
$stmt = $db->prepare(
    'UPDATE pages SET title = ?, h1 = ?, meta_description = ?, og_title = ?, og_description = ?, canonical_url = ?, primary_keyword = ?, secondary_keywords = ?, robots_meta = ?, schema_json = ? WHERE slug = ?'
);
$stmt->execute([
    $title, $h1, $metaDescription, $ogTitle, $ogDescription, $canonicalUrl,
    $primaryKeyword, $secondaryKeywords, $robotsMeta,
    $schemaJson !== '' ? $schemaJson : null,
    $slug,
]);

$_SESSION['flash_success'] = 'Page updated.';
header('Location: pages.php');
exit;
