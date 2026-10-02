<?php
/**
 * Shared HTML chrome for logged-in admin pages. Reuses the Tailwind CDN
 * and colour palette from the public site for visual consistency.
 */

function render_admin_header(string $title, string $active = ''): void {
    $navItems = [
        'dashboard' => ['label' => 'Posts', 'href' => 'index.php'],
    ];
    ?>
<!DOCTYPE html>
<html lang="en-AU">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex, nofollow">
  <title><?= e($title) ?> | Admin | Fridge Repair Parramatta</title>
  <link rel="icon" type="image/webp" href="../image/FFp-logo.webp">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="assets/admin.css">
</head>
<body class="bg-slate-100 text-slate-900 antialiased">

  <header class="bg-slate-900 text-white border-b border-slate-800">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-3 flex items-center justify-between gap-4">
      <div class="flex items-center gap-3">
        <img src="../image/FFp-logo.webp" alt="Fridge Repair Parramatta" class="w-9 h-9 rounded-md border border-sky-500/40 object-cover">
        <div class="leading-tight">
          <div class="font-extrabold text-sm sm:text-base">Fridge Repair Parramatta</div>
          <div class="text-xs text-sky-400 font-semibold">Blog Admin Panel</div>
        </div>
      </div>
      <nav class="flex items-center gap-4 text-sm font-semibold">
        <a href="index.php" class="<?= $active === 'dashboard' ? 'text-sky-400' : 'text-slate-300 hover:text-sky-400' ?> transition-colors">Posts</a>
        <a href="../blog" target="_blank" rel="noopener" class="text-slate-300 hover:text-sky-400 transition-colors">View Site</a>
        <a href="change-password.php" class="<?= $active === 'password' ? 'text-sky-400' : 'text-slate-300 hover:text-sky-400' ?> transition-colors">Change Password</a>
        <span class="hidden sm:inline text-slate-500">|</span>
        <span class="hidden sm:inline text-slate-400 font-normal"><?= e(current_admin_username() ?? '') ?></span>
        <a href="logout.php" class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 transition-colors">Log Out</a>
      </nav>
    </div>
  </header>

  <main class="max-w-6xl mx-auto px-4 sm:px-6 py-8">
<?php
}

function render_admin_footer(): void {
    ?>
  </main>
</body>
</html>
<?php
}

function render_flash_messages(): void {
    if (!empty($_SESSION['flash_success'])) {
        echo '<div class="mb-6 px-4 py-3 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold">' . e($_SESSION['flash_success']) . '</div>';
        unset($_SESSION['flash_success']);
    }
    if (!empty($_SESSION['flash_error'])) {
        echo '<div class="mb-6 px-4 py-3 rounded-lg bg-red-50 border border-red-200 text-red-800 text-sm font-semibold">' . e($_SESSION['flash_error']) . '</div>';
        unset($_SESSION['flash_error']);
    }
}
