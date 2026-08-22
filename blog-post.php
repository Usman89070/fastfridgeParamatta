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

// Recent Articles sidebar - other published posts, most recent first.
$stmt = get_db()->prepare(
    "SELECT slug, title, excerpt, published_at FROM blog_posts WHERE status = 'published' AND id != ? ORDER BY published_at DESC LIMIT 5"
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
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
      <p class="text-xs font-semibold text-slate-400">
        <a href="index.html" class="hover:text-sky-400">Home</a> <span class="mx-1">/</span>
        <a href="blog.html" class="hover:text-sky-400">Blog</a> <span class="mx-1">/</span> <?= e($post['title']) ?>
      </p>
      <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight leading-tight max-w-3xl"><?= e($post['title']) ?></h1>
      <div class="flex flex-wrap items-center gap-3 text-xs text-slate-400">
        <span>Fridge Repair Parramatta</span>
        <span>·</span>
        <span><?= e(date('j F Y', strtotime($post['published_at'] ?? 'now'))) ?></span>
        <span>·</span>
        <span><?= (int)$post['read_time_minutes'] ?> min read</span>
      </div>
    </div>
  </section>

  <!-- ARTICLE CONTENT + SIDEBAR -->
  <section class="py-16 sm:py-20 bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid lg:grid-cols-12 gap-12">

        <div class="lg:col-span-8 max-w-3xl">
          <?php if (!empty($post['featured_image'])): ?>
            <img src="<?= e($post['featured_image']) ?>" alt="<?= e($post['title']) ?>" class="w-full h-auto rounded-2xl border border-slate-200 shadow-md mb-10">
          <?php endif; ?>
          <div class="post-content text-slate-700">
            <?= $post['content'] ?>
          </div>
        </div>

        <aside class="lg:col-span-4 space-y-6">
          <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 lg:sticky lg:top-24">
            <h2 class="text-lg font-bold text-slate-900 mb-5">Recent Articles</h2>
            <?php if (empty($otherPosts)): ?>
              <p class="text-sm text-slate-500">More articles coming soon.</p>
            <?php else: ?>
              <div class="space-y-5 divide-y divide-slate-200">
                <?php foreach ($otherPosts as $i => $other): ?>
                  <a href="blog-<?= e($other['slug']) ?>.html" class="group block <?= $i > 0 ? 'pt-5' : '' ?>">
                    <div class="text-xs text-slate-500 mb-1.5"><?= e(date('j F Y', strtotime($other['published_at'] ?? 'now'))) ?></div>
                    <h3 class="font-bold text-slate-900 text-sm leading-snug group-hover:text-sky-700 transition-colors"><?= e($other['title']) ?></h3>
                    <?php if (!empty($other['excerpt'])): ?>
                      <p class="text-xs text-slate-500 mt-1.5 leading-relaxed"><?= e($other['excerpt']) ?></p>
                    <?php endif; ?>
                  </a>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
            <a href="blog.html" class="inline-flex items-center gap-1.5 text-sm font-bold text-sky-700 hover:text-sky-800 mt-6">
              View All Articles <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
          </div>

          <div class="p-6 rounded-2xl bg-slate-900 text-white space-y-3">
            <h2 class="text-base font-bold">Need a Fridge Repair?</h2>
            <p class="text-slate-300 text-sm">Same-day service across Parramatta and Western Sydney, with a free quote first.</p>
            <a href="tel:1300240680" class="flex items-center justify-center gap-2 w-full px-4 py-2.5 rounded-lg text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-500 transition-all">
              <i data-lucide="phone-call" class="w-4 h-4"></i> Call now
            </a>
            <a href="contact.html#contact-form" class="flex items-center justify-center gap-2 w-full px-4 py-2.5 rounded-lg text-sm font-bold text-white bg-sky-600 hover:bg-sky-500 transition-all">
              <i data-lucide="calendar" class="w-4 h-4"></i> Book Online 24/7
            </a>
          </div>
        </aside>

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
      <a href="blog.html" class="inline-flex items-center gap-1.5 text-sm text-slate-400 hover:text-sky-400 pt-2">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to all articles
      </a>
    </div>
  </section>

<?php require __DIR__ . '/includes/site-footer.php'; ?>
