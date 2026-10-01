<?php
/**
 * Dynamically generated sitemap.xml.
 *
 * Static pages are picked up automatically by scanning this directory for
 * top-level *.html files, so a new page just needs to exist on disk to show
 * up here - nothing to edit by hand. Its <lastmod> is the file's own last-
 * modified time, so that stays current automatically too.
 *
 * Blog posts are pulled straight from the blog_posts table, so a new post
 * published from the admin panel appears here immediately as well.
 *
 * .htaccess rewrites the public /sitemap.xml URL to this script.
 */

header('Content-Type: application/xml; charset=UTF-8');

const BASE_URL = 'https://fridgerepairparramatta.com.au';

// Per-page priority/changefreq overrides. Anything not listed here (including
// any brand-new page dropped onto the site later) still gets picked up by the
// directory scan below, just with the $defaultPriority/$defaultChangefreq.
$pageSettings = [
    'about'                    => ['priority' => '0.7', 'changefreq' => 'monthly'],
    'contact'                  => ['priority' => '0.8', 'changefreq' => 'monthly'],
    'blog'                     => ['priority' => '0.7', 'changefreq' => 'weekly'],
    'emergency-fridge-repair'  => ['priority' => '0.9', 'changefreq' => 'weekly'],
    'fridge-repair-cost'       => ['priority' => '0.9', 'changefreq' => 'monthly'],
    'services'                 => ['priority' => '0.9', 'changefreq' => 'monthly'],
    'brands'                   => ['priority' => '0.9', 'changefreq' => 'monthly'],
];
$defaultPriority = '0.6';
$defaultChangefreq = 'monthly';

$urls = [];

// Homepage (and its legacy /fridge-repair-parramatta/ slug alias), pinned
// first with top priority. lastmod comes from index.html's own mtime.
$homeLastmod = file_exists(__DIR__ . '/index.html') ? date('Y-m-d', filemtime(__DIR__ . '/index.html')) : date('Y-m-d');
$urls[] = ['loc' => BASE_URL . '/', 'lastmod' => $homeLastmod, 'changefreq' => 'daily', 'priority' => '1.0'];
$urls[] = ['loc' => BASE_URL . '/fridge-repair-parramatta/', 'lastmod' => $homeLastmod, 'changefreq' => 'daily', 'priority' => '1.0'];

// Every other top-level static page: scan the directory instead of hand-
// listing files, so a new page (any new *.html dropped in the site root)
// shows up here without touching this script.
// - index.html is excluded: already handled above as the homepage.
// - blog-*.html files are excluded: those are legacy static copies of
//   database-backed blog posts, which are listed separately below using
//   their real published/updated dates instead of the static file's mtime.
$htmlFiles = glob(__DIR__ . '/*.html') ?: [];
sort($htmlFiles);
foreach ($htmlFiles as $path) {
    $slug = basename($path, '.html');
    if ($slug === 'index' || str_starts_with($slug, 'blog-')) {
        continue;
    }
    $settings = $pageSettings[$slug] ?? ['priority' => $defaultPriority, 'changefreq' => $defaultChangefreq];
    $urls[] = [
        'loc' => BASE_URL . '/' . $slug,
        'lastmod' => date('Y-m-d', filemtime($path)),
        'changefreq' => $settings['changefreq'],
        'priority' => $settings['priority'],
    ];
}

// Published blog posts, straight from the database. Falls back to just the
// static pages above (rather than a 500) if the database isn't configured
// yet, so the sitemap is never fully broken. get_db() calls die() rather
// than throwing when admin/includes/config.php is missing, so that case is
// checked for up front instead of relying on a try/catch around it.
if (file_exists(__DIR__ . '/admin/includes/config.php')) {
    try {
        require __DIR__ . '/admin/includes/db.php';
        $posts = get_db()->query(
            "SELECT slug, published_at, updated_at FROM blog_posts WHERE status = 'published' ORDER BY published_at DESC, id DESC"
        )->fetchAll();
        foreach ($posts as $post) {
            $lastmodSource = $post['updated_at'] ?? $post['published_at'] ?? 'now';
            $urls[] = [
                'loc' => BASE_URL . '/blog-' . $post['slug'],
                'lastmod' => date('Y-m-d', strtotime($lastmodSource)),
                'changefreq' => 'yearly',
                'priority' => '0.6',
            ];
        }
    } catch (Throwable $e) {
        // Database unreachable (bad credentials, DB down) - the static
        // pages above still go out instead of a broken sitemap.
    }
}

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
foreach ($urls as $url) {
    echo "  <url>\n";
    echo "    <loc>" . htmlspecialchars($url['loc'], ENT_XML1 | ENT_QUOTES) . "</loc>\n";
    echo "    <lastmod>" . htmlspecialchars($url['lastmod'], ENT_XML1 | ENT_QUOTES) . "</lastmod>\n";
    echo "    <changefreq>" . htmlspecialchars($url['changefreq'], ENT_XML1 | ENT_QUOTES) . "</changefreq>\n";
    echo "    <priority>" . htmlspecialchars($url['priority'], ENT_XML1 | ENT_QUOTES) . "</priority>\n";
    echo "  </url>\n";
}
echo '</urlset>' . "\n";
