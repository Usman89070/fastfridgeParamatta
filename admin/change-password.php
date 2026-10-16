<?php
require __DIR__ . '/includes/db.php';
require __DIR__ . '/includes/auth.php';
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/layout.php';

require_login();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $current = (string)($_POST['current_password'] ?? '');
    $new = (string)($_POST['new_password'] ?? '');
    $confirm = (string)($_POST['confirm_password'] ?? '');

    $db = get_db();
    $stmt = $db->prepare('SELECT password_hash FROM admin_users WHERE id = ?');
    $stmt->execute([$_SESSION['admin_id']]);
    $admin = $stmt->fetch();

    if (!$admin || !password_verify($current, $admin['password_hash'])) {
        $error = 'Your current password is incorrect.';
    } elseif (strlen($new) < 10) {
        $error = 'New password must be at least 10 characters.';
    } elseif ($new !== $confirm) {
        $error = 'New password and confirmation do not match.';
    } else {
        $hash = password_hash($new, PASSWORD_BCRYPT);
        $stmt = $db->prepare('UPDATE admin_users SET password_hash = ? WHERE id = ?');
        $stmt->execute([$hash, $_SESSION['admin_id']]);
        $_SESSION['flash_success'] = 'Password changed.';
        header('Location: index.php');
        exit;
    }
}

render_admin_header('Change Password', 'password');
?>

<div class="max-w-md">
  <h1 class="text-2xl font-extrabold text-slate-900 mb-6">Change Password</h1>

  <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
    <?php if ($error): ?>
      <div class="mb-5 px-4 py-3 rounded-lg bg-red-50 border border-red-200 text-red-800 text-sm font-semibold"><?= e($error) ?></div>
    <?php endif; ?>

    <form method="post" class="space-y-4">
      <?= csrf_field() ?>
      <div>
        <label class="admin-label" for="current_password">Current Password</label>
        <input class="admin-input" type="password" id="current_password" name="current_password" autocomplete="current-password" required>
      </div>
      <div>
        <label class="admin-label" for="new_password">New Password</label>
        <input class="admin-input" type="password" id="new_password" name="new_password" autocomplete="new-password" minlength="10" required>
        <p class="admin-hint">At least 10 characters.</p>
      </div>
      <div>
        <label class="admin-label" for="confirm_password">Confirm New Password</label>
        <input class="admin-input" type="password" id="confirm_password" name="confirm_password" autocomplete="new-password" minlength="10" required>
      </div>
      <button type="submit" class="admin-btn-primary">Update Password</button>
    </form>
  </div>
</div>

<?php render_admin_footer(); ?>
