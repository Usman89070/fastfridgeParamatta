<?php
require __DIR__ . '/includes/db.php';
require __DIR__ . '/includes/auth.php';
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/layout.php';

require_login();

$posts = get_db()->query(
    'SELECT id, slug, title, status, published_at, updated_at FROM blog_posts ORDER BY COALESCE(published_at, "0000-00-00") DESC, updated_at DESC'
)->fetchAll();

render_admin_header('Posts', 'dashboard');
render_flash_messages();
?>

<div class="flex items-center justify-between gap-4 mb-6">
  <h1 class="text-2xl font-extrabold text-slate-900">Blog Posts</h1>
  <a href="post-form.php" class="admin-btn-primary">+ New Post</a>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
  <?php if (empty($posts)): ?>
    <p class="p-8 text-center text-slate-500">No posts yet. Click "+ New Post" to write your first one.</p>
  <?php else: ?>
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead>
          <tr class="bg-slate-50 border-b border-slate-200 text-left text-xs font-bold text-slate-500 uppercase tracking-wide">
            <th class="px-5 py-3">Title</th>
            <th class="px-5 py-3">Status</th>
            <th class="px-5 py-3">Published</th>
            <th class="px-5 py-3">Last Updated</th>
            <th class="px-5 py-3 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          <?php foreach ($posts as $post): ?>
            <tr>
              <td class="px-5 py-3.5">
                <div class="font-semibold text-slate-900"><?= e($post['title']) ?></div>
                <div class="text-xs text-slate-400">/blog-<?= e($post['slug']) ?></div>
              </td>
              <td class="px-5 py-3.5">
                <span class="<?= $post['status'] === 'published' ? 'admin-badge-published' : 'admin-badge-draft' ?>">
                  <?= e(ucfirst($post['status'])) ?>
                </span>
              </td>
              <td class="px-5 py-3.5 text-slate-600"><?= e($post['published_at'] ?? '—') ?></td>
              <td class="px-5 py-3.5 text-slate-600"><?= e($post['updated_at']) ?></td>
              <td class="px-5 py-3.5 text-right whitespace-nowrap">
                <a href="post-form.php?id=<?= (int)$post['id'] ?>" class="admin-btn-secondary" style="padding:0.4rem 0.9rem;font-size:0.8125rem;">Edit</a>
                <form method="post" action="post-delete.php" class="inline" onsubmit="return confirm('Delete &quot;<?= e($post['title']) ?>&quot;? This cannot be undone.');">
                  <?= csrf_field() ?>
                  <input type="hidden" name="id" value="<?= (int)$post['id'] ?>">
                  <button type="submit" class="admin-btn-danger">Delete</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<?php render_admin_footer(); ?>
