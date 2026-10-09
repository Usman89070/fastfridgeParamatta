<?php
require __DIR__ . '/includes/db.php';
require __DIR__ . '/includes/auth.php';
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/layout.php';

require_login();

$post = [
    'id' => null,
    'slug' => '',
    'title' => '',
    'meta_description' => '',
    'excerpt' => '',
    'content' => '',
    'read_time_minutes' => 5,
    'status' => 'draft',
    'published_at' => date('Y-m-d'),
];

$isEdit = false;
if (isset($_GET['id'])) {
    $stmt = get_db()->prepare('SELECT * FROM blog_posts WHERE id = ?');
    $stmt->execute([(int)$_GET['id']]);
    $found = $stmt->fetch();
    if (!$found) {
        header('Location: index.php');
        exit;
    }
    $post = $found;
    $isEdit = true;
}

render_admin_header($isEdit ? 'Edit Post' : 'New Post');
render_flash_messages();
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.snow.min.css">
<style>
  /* Match the Quill toolbar/editor to the rest of the admin form fields. */
  #quill-editor-wrap .ql-toolbar { border: none; border-bottom: 1px solid #cbd5e1; background: #f8fafc; }
  #quill-editor-wrap .ql-container { border: none; font-size: 0.95rem; }
  #quill-editor .ql-editor { min-height: 420px; }
  #quill-editor .ql-editor h2 { font-size: 1.4rem; font-weight: 800; margin-top: 0.5em; }
  #quill-editor .ql-editor h3 { font-size: 1.15rem; font-weight: 700; margin-top: 0.5em; }
</style>

<div class="mb-6">
  <a href="index.php" class="text-sm text-slate-500 hover:text-sky-600 font-semibold">&larr; Back to Posts</a>
</div>

<h1 class="text-2xl font-extrabold text-slate-900 mb-6"><?= $isEdit ? 'Edit Post' : 'New Post' ?></h1>

<form method="post" action="post-save.php" enctype="multipart/form-data" class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-6">
  <?= csrf_field() ?>
  <?php if ($isEdit): ?>
    <input type="hidden" name="id" value="<?= (int)$post['id'] ?>">
  <?php endif; ?>

  <div>
    <label class="admin-label" for="title">Title *</label>
    <input class="admin-input" type="text" id="title" name="title" value="<?= e($post['title']) ?>" required>
  </div>

  <div>
    <label class="admin-label" for="slug">URL Slug</label>
    <input class="admin-input" type="text" id="slug" name="slug" value="<?= e($post['slug']) ?>" placeholder="auto-generated from title if left blank">
    <p class="admin-hint">The post will be published at <code>/blog-<span id="slug-preview"><?= e($post['slug'] ?: 'your-slug') ?></span></code>. Only lowercase letters, numbers and dashes.</p>
  </div>

  <div class="grid sm:grid-cols-2 gap-6">
    <div>
      <label class="admin-label" for="published_at">Publish Date</label>
      <input class="admin-input" type="date" id="published_at" name="published_at" value="<?= e($post['published_at'] ?? date('Y-m-d')) ?>">
    </div>
    <div>
      <label class="admin-label" for="read_time_minutes">Read Time (minutes)</label>
      <input class="admin-input" type="number" id="read_time_minutes" name="read_time_minutes" min="1" max="60" value="<?= e((string)$post['read_time_minutes']) ?>">
    </div>
  </div>

  <div>
    <label class="admin-label" for="excerpt">Card Excerpt</label>
    <textarea class="admin-textarea" id="excerpt" name="excerpt" rows="2" maxlength="500"><?= e($post['excerpt']) ?></textarea>
    <p class="admin-hint">One or two sentences shown on the blog listing card and the homepage teaser.</p>
  </div>

  <div>
    <label class="admin-label" for="meta_description">SEO Meta Description</label>
    <textarea class="admin-textarea" id="meta_description" name="meta_description" rows="2" maxlength="300"><?= e($post['meta_description']) ?></textarea>
    <p class="admin-hint">Shown in Google search results. Keep it under ~155 characters.</p>
  </div>

  <div>
    <label class="admin-label" for="featured_image">Featured Image</label>
    <?php if (!empty($post['featured_image'])): ?>
      <img src="../<?= e($post['featured_image']) ?>" alt="" class="w-40 h-28 object-cover rounded-lg border border-slate-200 mb-2">
    <?php endif; ?>
    <input class="admin-input" type="file" id="featured_image" name="featured_image" accept="image/jpeg,image/png,image/webp">
    <p class="admin-hint">Optional. JPG, PNG or WEBP, up to 5MB. Leave blank to keep the current image when editing.</p>
  </div>

  <div>
    <div class="flex items-center justify-between gap-4">
      <label class="admin-label" for="content">Post Content *</label>
      <button type="button" id="toggle-html-view" class="text-xs font-bold text-sky-700 hover:underline">View/Edit raw HTML</button>
    </div>
    <div id="quill-editor-wrap" class="bg-white border border-slate-300 rounded-lg overflow-hidden">
      <div id="quill-editor" style="min-height: 420px;"></div>
    </div>
    <textarea class="admin-textarea hidden" id="content" name="content" rows="20" required><?= e($post['content']) ?></textarea>
    <p class="admin-hint">
      Write and format normally (headings, bold, lists, links) with the toolbar above - it saves as clean HTML
      automatically. Pasting from Word or Google Docs is fine; use the "Clean" (eraser) button to strip leftover
      formatting first. For an advanced element the toolbar doesn't cover, such as a highlighted
      <code>&lt;div class="callout"&gt;</code> tip box, click "View/Edit raw HTML" above and type the tag directly.
      Anything outside the allowed tags is stripped out for safety when you save.
    </p>
  </div>

  <div>
    <label class="admin-label" for="status">Status</label>
    <select class="admin-select" id="status" name="status" style="max-width: 240px;">
      <option value="draft" <?= $post['status'] === 'draft' ? 'selected' : '' ?>>Draft (not visible on the site)</option>
      <option value="published" <?= $post['status'] === 'published' ? 'selected' : '' ?>>Published</option>
    </select>
  </div>

  <div class="flex items-center gap-3 pt-2 border-t border-slate-200">
    <button type="submit" class="admin-btn-primary"><?= $isEdit ? 'Save Changes' : 'Create Post' ?></button>
    <a href="index.php" class="admin-btn-secondary">Cancel</a>
  </div>
</form>

<script>
  // Live-update the slug preview under the URL field as the admin types.
  const titleInput = document.getElementById('title');
  const slugInput = document.getElementById('slug');
  const slugPreview = document.getElementById('slug-preview');

  function slugifyClientSide(text) {
    return text
      .toLowerCase()
      .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
      .replace(/[^a-z0-9]+/g, '-')
      .replace(/^-+|-+$/g, '') || 'your-slug';
  }

  function updatePreview() {
    const manual = slugInput.value.trim();
    slugPreview.textContent = manual ? slugifyClientSide(manual) : slugifyClientSide(titleInput.value || 'your-slug');
  }

  titleInput.addEventListener('input', updatePreview);
  slugInput.addEventListener('input', updatePreview);
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.min.js"></script>
<script>
  const quill = new Quill('#quill-editor', {
    theme: 'snow',
    modules: {
      toolbar: [
        [{ header: [2, 3, false] }],
        ['bold', 'italic'],
        [{ list: 'ordered' }, { list: 'bullet' }],
        ['blockquote', 'link'],
        ['clean'],
      ],
    },
  });

  const contentField = document.getElementById('content');
  const quillWrap = document.getElementById('quill-editor-wrap');
  const toggleBtn = document.getElementById('toggle-html-view');

  // Seed the editor from whatever's already in the hidden textarea (existing
  // post content when editing, empty for a new post).
  quill.root.innerHTML = contentField.value;

  // Keep the hidden textarea in sync on every edit, since that's the field
  // that actually gets posted to post-save.php.
  quill.on('text-change', () => {
    contentField.value = quill.root.innerHTML;
  });

  let showingRawHtml = false;
  toggleBtn.addEventListener('click', () => {
    if (!showingRawHtml) {
      // Switching TO raw HTML: make sure the textarea has the latest content,
      // then show it instead of the visual editor.
      contentField.value = quill.root.innerHTML;
      quillWrap.classList.add('hidden');
      contentField.classList.remove('hidden');
      toggleBtn.textContent = 'Back to Visual Editor';
    } else {
      // Switching back TO the visual editor: load whatever was hand-typed in
      // the raw textarea back into Quill.
      quill.root.innerHTML = contentField.value;
      contentField.classList.add('hidden');
      quillWrap.classList.remove('hidden');
      toggleBtn.textContent = 'View/Edit raw HTML';
    }
    showingRawHtml = !showingRawHtml;
  });

  // Belt-and-braces: whichever view is visible when the form submits wins,
  // so make sure the textarea reflects the visual editor's content right
  // before submit too (covers a stray edit that didn't fire text-change).
  document.querySelector('form[action="post-save.php"]').addEventListener('submit', () => {
    if (!showingRawHtml) {
      contentField.value = quill.root.innerHTML;
    }
  });
</script>

<?php render_admin_footer(); ?>
