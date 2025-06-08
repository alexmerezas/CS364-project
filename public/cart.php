<?php
session_start();
require_once '../config/db.php';

$cart = $_SESSION['cart'] ?? [];
$ids = array_keys($cart);

$books = [];
if($ids){
    $in = implode(',', array_fill(0,count($ids),'?'));
    $stmt = $pdo->prepare("SELECT id,title,price,image FROM books WHERE id IN ($in)");
    $stmt->execute($ids);
    $books = $stmt->fetchAll(PDO::FETCH_UNIQUE);
}

$total = 0;
$title='Your cart';
include '../includes/header.php';
?>
<h1>Cart</h1>
<?php if(!$cart): ?>
  <p>Cart is empty.</p>
<?php else: ?>
<table class="table">
<tr><th>Book</th><th>Qty</th><th>Price</th><th>Subtotal</th></tr>
<?php foreach($cart as $id=>$qty):
      $p = $books[$id];
      $sub = $qty*$p['price'];
      $total += $sub; ?>
<tr>
 <td><?= htmlspecialchars($p['title']) ?></td>
 <td><?= $qty ?></td>
 <td>&euro;<?= $p['price'] ?></td>
 <td>&euro;<?= number_format($sub,2) ?></td>
</tr>
<?php endforeach; ?>
<tr><th colspan="3" class="text-end">Total</th><th>&euro;<?= number_format($total,2) ?></th></tr>
</table>
<a class="btn btn-success" href="checkout.php">Checkout</a>
<?php endif; ?>
<?php include '../includes/footer.php'; ?>