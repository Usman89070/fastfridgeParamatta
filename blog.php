<?php
require __DIR__ . '/admin/includes/db.php';
require __DIR__ . '/admin/includes/functions.php';

$posts = get_db()->query(
    "SELECT slug, title, excerpt, featured_image, read_time_minutes, published_at
     FROM blog_posts WHERE status = 'published' ORDER BY published_at DESC, id DESC"
)->fetchAll();

$pageTitle = 'Blog | Fridge Repair Parramatta';
$metaDescription = 'Fridge repair advice, maintenance tips and honest repair-vs-replace guidance from licensed refrigeration mechanics servicing Parramatta and Western Sydney.';
$canonicalUrl = 'https://fridgerepairparramatta.com.au/blog/';
$ogType = 'website';

require __DIR__ . '/includes/site-header.php';
?>

  <!-- PAGE BANNER -->
  <section class="bg-slate-900 text-white py-14 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-3">
      <p class="text-xs font-semibold text-slate-400">
        <a href="index.html" class="hover:text-sky-400">Home</a> <span class="mx-1">/</span> Blog
      </p>
      <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight">Fridge Repair Blog</h1>
      <p class="text-slate-300 text-base sm:text-lg max-w-2xl">
        Practical advice on faults, maintenance and honest repair-vs-replace decisions, from licensed refrigeration mechanics servicing Parramatta and Western Sydney.
      </p>
    </div>
  </section>

  <!-- BLOG POST GRID -->
  <section class="py-16 sm:py-20 bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <?php if (empty($posts)): ?>
        <p class="text-center text-slate-500 py-12">No articles published yet - check back soon.</p>
      <?php else: ?>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
          <?php foreach ($posts as $post): ?>
            <a href="blog-<?= e($post['slug']) ?>.html" class="reveal-child p-6 rounded-xl bg-slate-50 border border-slate-200 card-hover flex flex-col justify-between space-y-4">
              <div class="space-y-3">
                <?php if (!empty($post['featured_image'])): ?>
                  <img src="<?= e($post['featured_image']) ?>" alt="" class="w-full h-32 object-cover rounded-lg" loading="lazy" decoding="async">
                <?php else: ?>
                  <div class="w-10 h-10 rounded-lg bg-sky-100 text-sky-700 flex items-center justify-center">
                    <i data-lucide="file-text" class="w-5 h-5"></i>
                  </div>
                <?php endif; ?>
                <div class="flex items-center gap-2 text-xs text-slate-500">
                  <span><?= e(date('j F Y', strtotime($post['published_at'] ?? 'now'))) ?></span> <span>·</span> <span><?= (int)$post['read_time_minutes'] ?> min read</span>
                </div>
                <h2 class="text-lg font-bold text-slate-900"><?= e($post['title']) ?></h2>
                <p class="text-sm text-slate-600 leading-relaxed">
                  <?= e($post['excerpt']) ?>
                </p>
              </div>
              <span class="text-sm font-bold text-sky-700 flex items-center gap-1.5">
                Read Article <i data-lucide="arrow-right" class="w-4 h-4"></i>
              </span>
            </a>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </section>

<?php require __DIR__ . '/includes/site-footer.php'; ?>
