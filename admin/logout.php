<?php
require __DIR__ . '/includes/db.php';
require __DIR__ . '/includes/auth.php';

logout_admin();
header('Location: login.php');
exit;
