<?php
require __DIR__ . '/admin/includes/db.php';
require __DIR__ . '/admin/includes/functions.php';

$slug = trim($_GET['slug'] ?? '');
$post = null;

if ($slug !== '') {
    $stmt = get_db()->prepare("SELECT * FROM blog_posts WHERE slug = ? AND status = 'published'");
    $stmt->execute([$slug]);
    $post = $stmt->fetch() ?: null;
}

if (!$post) {
    http_response_code(404);
    $pageTitle = 'Article Not Found | Fridge Repair Parramatta';
    $metaDescription = 'The blog article you were looking for could not be found.';
    $canonicalUrl = 'https://fridgerepairparramatta.com.au/blog.html';
    $ogType = 'website';
    require __DIR__ . '/includes/site-header.php';
    ?>
      <section class="py-24 bg-white border-b border-slate-200">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-5">
          <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900">Article Not Found</h1>
          <p class="text-slate-600">This article may have been moved or unpublished.</p>
          <a href="blog.html" class="inline-flex items-center justify-center px-6 py-3 rounded-xl text-base font-bold text-white bg-sky-600 hover:bg-sky-500 shadow-lg transition-all">Back to the Blog</a>
        </div>
      </section>
    <?php
    require __DIR__ . '/includes/site-footer.php';
    exit;
}

// "You might also like" - up to 2 other published posts.
$stmt = get_db()->prepare(
    "SELECT slug, title FROM blog_posts WHERE status = 'published' AND id != ? ORDER BY published_at DESC LIMIT 2"
);
$stmt->execute([$post['id']]);
$otherPosts = $stmt->fetchAll();

$pageTitle = $post['title'] . ' | Fridge Repair Parramatta';
$metaDescription = $post['meta_description'] !== '' ? $post['meta_description'] : $post['excerpt'];
$canonicalUrl = 'https://fridgerepairparramatta.com.au/blog-' . $post['slug'] . '.html';
$ogType = 'article';

require __DIR__ . '/includes/site-header.php';
?>

  <!-- PAGE BANNER -->
  <section class="bg-slate-900 text-white py-14 border-b border-slate-800">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
      <p class="text-xs font-semibold text-slate-400">
        <a href="index.html" class="hover:text-sky-400">Home</a> <span class="mx-1">/</span>
        <a href="blog.html" class="hover:text-sky-400">Blog</a> <span class="mx-1">/</span> <?= e($post['title']) ?>
      </p>
      <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight leading-tight"><?= e($post['title']) ?></h1>
      <div class="flex flex-wrap items-center gap-3 text-xs text-slate-400">
        <span>Fridge Repair Parramatta</span>
        <span>·</span>
        <span><?= e(date('j F Y', strtotime($post['published_at'] ?? 'now'))) ?></span>
        <span>·</span>
        <span><?= (int)$post['read_time_minutes'] ?> min read</span>
      </div>
    </div>
  </section>

  <!-- ARTICLE CONTENT -->
  <section class="py-16 sm:py-20 bg-white border-b border-slate-200">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
      <?php if (!empty($post['featured_image'])): ?>
        <img src="<?= e($post['featured_image']) ?>" alt="<?= e($post['title']) ?>" class="w-full h-auto rounded-2xl border border-slate-200 shadow-md mb-10">
      <?php endif; ?>
      <div class="post-content text-slate-700">
        <?= $post['content'] ?>
      </div>
    </div>
  </section>

  <!-- FINAL CTA -->
  <section class="py-16 bg-slate-900 text-white border-t border-slate-800">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6">
      <h2 class="text-2xl sm:text-3xl font-extrabold">Need a Hand With This?</h2>
      <p class="text-slate-300">Same-day service across Parramatta and Western Sydney, with a free quote before any work starts.</p>
      <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
        <a href="tel:1300240680" class="w-full sm:w-auto px-8 py-4 rounded-xl text-base font-bold text-white bg-emerald-600 hover:bg-emerald-500 shadow-lg transition-all flex items-center justify-center gap-2.5">
          <i data-lucide="phone-call" class="w-5 h-5"></i>
          <span>Call now</span>
        </a>
        <a href="contact.html#contact-form" class="w-full sm:w-auto px-8 py-4 rounded-xl text-base font-bold text-white bg-sky-600 hover:bg-sky-500 shadow-lg transition-all flex items-center justify-center gap-2.5">
          <i data-lucide="calendar" class="w-5 h-5"></i>
          <span>Book Online 24/7</span>
        </a>
      </div>
      <?php if (!empty($otherPosts)): ?>
        <div class="pt-6 border-t border-slate-800 flex flex-col sm:flex-row justify-center items-center gap-x-6 gap-y-2 text-sm">
          <?php foreach ($otherPosts as $other): ?>
            <a href="blog-<?= e($other['slug']) ?>.html" class="text-slate-400 hover:text-sky-400"><?= e($other['title']) ?></a>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
      <a href="blog.html" class="inline-flex items-center gap-1.5 text-sm text-slate-400 hover:text-sky-400 pt-2">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to all articles
      </a>
    </div>
  </section>

<?php require __DIR__ . '/includes/site-footer.php'; ?>
