<?php
include '../../includes/admin_guard.php';

require_once '../../config/db.php';
$userCnt = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$prodCnt = $pdo->query("SELECT COUNT(*) FROM books")->fetchColumn();
$orderCnt= $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();

$title='Admin';
include '../../includes/header.php';
?>
<h1>Admin dashboard</h1>
<ul>
  <li>Users: <?= $userCnt ?></li>
  <li>Books: <?= $prodCnt ?></li>
  <li>Orders: <?= $orderCnt ?></li>
</ul>
<?php include '../../includes/footer.php'; ?>