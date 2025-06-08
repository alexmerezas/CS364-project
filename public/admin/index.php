<?php
require_once '../../includes/auth.php';
if(!isAdmin()){ http_response_code(403); exit('Forbidden'); }

require_once '../../config/db.php';
$userCnt = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$prodCnt = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$orderCnt= $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();

$title='Admin';
include '../../includes/header.php';
?>
<h1>Admin dashboard</h1>
<ul>
  <li>Users: <?= $userCnt ?></li>
  <li>Products: <?= $prodCnt ?></li>
  <li>Orders: <?= $orderCnt ?></li>
</ul>
<?php include '../../includes/footer.php'; ?>