<?php
require __DIR__ . '/includes/db.php';
require __DIR__ . '/includes/auth.php';
require __DIR__ . '/includes/functions.php';

if (is_logged_in()) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $username = trim($_POST['username'] ?? '');
    $password = (string)($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $error = 'Enter both a username and password.';
    } else {
        $stmt = get_db()->prepare('SELECT id, username, password_hash FROM admin_users WHERE username = ?');
        $stmt->execute([$username]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password_hash'])) {
            login_admin((int)$admin['id'], $admin['username']);
            header('Location: index.php');
            exit;
        }
        $error = 'Incorrect username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en-AU">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex, nofollow">
  <title>Admin Login | Fridge Repair Parramatta</title>
  <link rel="icon" type="image/webp" href="../image/FFp-logo.webp">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="assets/admin.css">
</head>
<body class="bg-slate-900 text-slate-900 antialiased min-h-screen flex items-center justify-center p-4">

  <div class="w-full max-w-sm">
    <div class="text-center mb-6">
      <img src="../image/FFp-logo.webp" alt="Fridge Repair Parramatta" class="w-16 h-16 rounded-xl border border-sky-500/40 object-cover mx-auto mb-3 shadow-lg">
      <h1 class="text-white font-extrabold text-lg">Fridge Repair Parramatta</h1>
      <p class="text-sky-400 text-sm font-semibold">Blog Admin Panel</p>
    </div>

    <div class="bg-white rounded-2xl shadow-xl border border-slate-200 p-7">
      <?php if ($error): ?>
        <div class="mb-5 px-4 py-3 rounded-lg bg-red-50 border border-red-200 text-red-800 text-sm font-semibold"><?= e($error) ?></div>
      <?php endif; ?>

      <form method="post" class="space-y-4">
        <?= csrf_field() ?>
        <div>
          <label class="admin-label" for="username">Username</label>
          <input class="admin-input" type="text" id="username" name="username" autocomplete="username" required autofocus>
        </div>
        <div>
          <label class="admin-label" for="password">Password</label>
          <input class="admin-input" type="password" id="password" name="password" autocomplete="current-password" required>
        </div>
        <button type="submit" class="admin-btn-primary w-full">Log In</button>
      </form>
    </div>

    <p class="text-center text-slate-500 text-xs mt-5">
      <a href="../" class="hover:text-sky-400">&larr; Back to the main site</a>
    </p>
  </div>

</body>
</html>
