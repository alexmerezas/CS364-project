<?php
if (session_status() === PHP_SESSION_NONE) session_start();
function isAdmin() { return ($_SESSION['role'] ?? '') === 'admin'; }
?>
<!doctype html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title><?= $title ?? 'Book Shop' ?></title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   <link href="/assets/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand navbar-dark bg-dark">    <!-- no -lg -->
  <div class="container-fluid">
    <a class="navbar-brand" href="/index.php">Book Shop</a>
    <ul class="navbar-nav ms-auto">                       <!-- no collapse -->
      <li class="nav-item"><a class="nav-link" href="/index.php">Home</a></li>
      <li class="nav-item"><a class="nav-link" href="/cart.php">Cart</a></li>
      <?php if(isset($_SESSION['user_id'])): ?>
        <?php if(isAdmin()): ?>
          <li class="nav-item"><a class="nav-link" href="/admin/index.php">Admin</a></li>
        <?php endif; ?>
        <li class="nav-item"><a class="nav-link" href="/logout.php">Logout</a></li>
      <?php else: ?>
        <li class="nav-item"><a class="nav-link" href="/login.php">Login</a></li>
        <li class="nav-item"><a class="nav-link" href="/register.php">Register</a></li>
      <?php endif; ?>
    </ul>
  </div>
</nav>
<div class="container mt-4">