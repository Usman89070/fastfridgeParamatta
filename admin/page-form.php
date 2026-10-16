<?php
require __DIR__ . '/includes/db.php';
require __DIR__ . '/includes/auth.php';
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/layout.php';

require_login();

$slug = trim($_GET['slug'] ?? '');
if ($slug === '') {
    header('Location: pages.php');
    exit;
}

$page = null;
try {
    $stmt = get_db()->prepare('SELECT * FROM pages WHERE slug = ?');
    $stmt->execute([$slug]);
    $page = $stmt->fetch() ?: null;
} catch (Throwable $e) {
    // Table not migrated in yet - pages.php already explains this; just
    // bounce back rather than showing a half-broken form.
    header('Location: pages.php');
    exit;
}

if (!$page) {
    header('Location: pages.php');
    exit;
}

// Pretty-print the stored schema JSON for editing; fall back to the raw
// value if it's somehow not valid JSON, so nothing is ever silently lost.
$schemaForEditing = $page['schema_json'] ?? '';
if ($schemaForEditing !== '') {
    $decoded = json_decode($schemaForEditing, true);
    if (json_last_error() === JSON_ERROR_NONE) {
        $schemaForEditing = json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}

render_admin_header('Edit Page: ' . $page['label'], 'pages');
render_flash_messages();
?>

<div class="mb-6">
  <a href="pages.php" class="text-sm text-slate-500 hover:text-sky-600 font-semibold">&larr; Back to Pages</a>
</div>

<h1 class="text-2xl font-extrabold text-slate-900 mb-1"><?= e($page['label'] ?: $page['slug']) ?></h1>
<p class="text-sm text-slate-500 mb-6">Live at <code>/<?= e($page['slug']) ?></code></p>

<form method="post" action="page-save.php" class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-6">
  <?= csrf_field() ?>
  <input type="hidden" name="slug" value="<?= e($page['slug']) ?>">

  <div>
    <label class="admin-label" for="title">Meta Title *</label>
    <input class="admin-input" type="text" id="title" name="title" value="<?= e($page['title']) ?>" maxlength="255" required>
    <p class="admin-hint">Shows in the browser tab and as the blue link in Google results. Aim for under ~60 characters.</p>
  </div>

  <div>
    <label class="admin-label" for="h1">Page Heading (H1)</label>
    <input class="admin-input" type="text" id="h1" name="h1" value="<?= e($page['h1']) ?>" maxlength="255">
    <p class="admin-hint">The large heading visitors see at the top of the page. Can differ from the meta title.</p>
  </div>

  <div>
    <label class="admin-label" for="meta_description">Meta Description</label>
    <textarea class="admin-textarea" id="meta_description" name="meta_description" rows="2" maxlength="300"><?= e($page['meta_description']) ?></textarea>
    <p class="admin-hint">Shown under the title in Google search results. Keep it under ~155 characters.</p>
  </div>

  <div class="grid sm:grid-cols-2 gap-6">
    <div>
      <label class="admin-label" for="og_title">Social Share Title (OG)</label>
      <input class="admin-input" type="text" id="og_title" name="og_title" value="<?= e($page['og_title']) ?>" maxlength="255">
    </div>
    <div>
      <label class="admin-label" for="robots_meta">Robots</label>
      <select class="admin-select" id="robots_meta" name="robots_meta">
        <?php foreach (['index,follow' => 'Index & Follow (normal, default)', 'noindex,follow' => 'No-index, Follow', 'noindex,nofollow' => 'No-index, No-follow'] as $value => $label): ?>
          <option value="<?= e($value) ?>" <?= $page['robots_meta'] === $value ? 'selected' : '' ?>><?= e($label) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>

  <div>
    <label class="admin-label" for="og_description">Social Share Description (OG)</label>
    <textarea class="admin-textarea" id="og_description" name="og_description" rows="2" maxlength="300"><?= e($page['og_description']) ?></textarea>
  </div>

  <div>
    <label class="admin-label" for="canonical_url">Canonical URL</label>
    <input class="admin-input" type="text" id="canonical_url" name="canonical_url" value="<?= e($page['canonical_url']) ?>" maxlength="255">
    <p class="admin-hint">The URL search engines should treat as the "real" one for this page. Almost always just this page's own address.</p>
  </div>

  <div class="grid sm:grid-cols-2 gap-6">
    <div>
      <label class="admin-label" for="primary_keyword">Primary Keyword</label>
      <input class="admin-input" type="text" id="primary_keyword" name="primary_keyword" value="<?= e($page['primary_keyword']) ?>" maxlength="150">
    </div>
    <div>
      <label class="admin-label" for="secondary_keywords">Secondary Keywords</label>
      <input class="admin-input" type="text" id="secondary_keywords" name="secondary_keywords" value="<?= e($page['secondary_keywords']) ?>" maxlength="500" placeholder="comma, separated, list">
    </div>
  </div>
  <p class="admin-hint -mt-4">For your own planning/reference only - Google ignores a keywords meta tag, so these aren't output on the page.</p>

  <div>
    <label class="admin-label" for="schema_json">JSON-LD Schema</label>
    <textarea class="admin-textarea font-mono text-xs" id="schema_json" name="schema_json" rows="14"><?= e($schemaForEditing) ?></textarea>
    <p class="admin-hint">
      Raw JSON-LD, exactly as it should appear in the page's <code>&lt;script type="application/ld+json"&gt;</code> tag.
      Must be valid JSON - the save will reject it otherwise and tell you what's wrong.
      Leave blank to keep the page's original hardcoded schema.
    </p>
  </div>

  <div class="flex items-center gap-3 pt-2 border-t border-slate-200">
    <button type="submit" class="admin-btn-primary">Save Changes</button>
    <a href="pages.php" class="admin-btn-secondary">Cancel</a>
  </div>
</form>

<?php render_admin_footer(); ?>
