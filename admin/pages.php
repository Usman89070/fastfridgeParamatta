<?php
require __DIR__ . '/includes/db.php';
require __DIR__ . '/includes/auth.php';
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/layout.php';

require_login();

$pages = [];
$migrationMissing = false;
try {
    $pages = get_db()->query(
        'SELECT id, slug, label, title, meta_description, updated_at FROM pages ORDER BY label ASC'
    )->fetchAll();
} catch (Throwable $e) {
    $migrationMissing = true;
}

render_admin_header('Pages', 'pages');
render_flash_messages();
?>

<div class="flex items-center justify-between gap-4 mb-6">
  <h1 class="text-2xl font-extrabold text-slate-900">Page SEO</h1>
</div>

<?php if ($migrationMissing): ?>
  <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8 text-center space-y-3">
    <p class="text-slate-700 font-semibold">The <code>pages</code> table hasn't been set up yet.</p>
    <p class="text-slate-500 text-sm">Import <code>database/migration_seo_pages.sql</code> via phpMyAdmin on your
      database (same one <code>blog_posts</code> lives in), then reload this page.</p>
  </div>
<?php elseif (empty($pages)): ?>
  <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8 text-center">
    <p class="text-slate-500">No pages registered yet.</p>
  </div>
<?php else: ?>
  <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead>
          <tr class="bg-slate-50 border-b border-slate-200 text-left text-xs font-bold text-slate-500 uppercase tracking-wide">
            <th class="px-5 py-3">Page</th>
            <th class="px-5 py-3">Title</th>
            <th class="px-5 py-3">Meta Description</th>
            <th class="px-5 py-3">Last Updated</th>
            <th class="px-5 py-3 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          <?php foreach ($pages as $page): ?>
            <tr>
              <td class="px-5 py-3.5">
                <div class="font-semibold text-slate-900"><?= e($page['label'] ?: $page['slug']) ?></div>
                <div class="text-xs text-slate-400">/<?= e($page['slug']) ?></div>
              </td>
              <td class="px-5 py-3.5 text-slate-600 max-w-xs truncate"><?= e($page['title']) ?></td>
              <td class="px-5 py-3.5 text-slate-500 text-xs max-w-sm truncate"><?= e($page['meta_description']) ?></td>
              <td class="px-5 py-3.5 text-slate-600"><?= e($page['updated_at']) ?></td>
              <td class="px-5 py-3.5 text-right whitespace-nowrap">
                <a href="page-form.php?slug=<?= urlencode($page['slug']) ?>" class="admin-btn-secondary" style="padding:0.4rem 0.9rem;font-size:0.8125rem;">Edit</a>
                <a href="../<?= e($page['slug']) ?>" target="_blank" rel="noopener" class="admin-btn-secondary" style="padding:0.4rem 0.9rem;font-size:0.8125rem;">View</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
  <p class="text-xs text-slate-400 mt-4">
    Only pages converted to pull from this panel appear here. Pages still on static HTML keep their SEO tags
    hardcoded in the file until they're converted too.
  </p>
<?php endif; ?>

<?php render_admin_footer(); ?>
