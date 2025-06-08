<?php
session_start();
require_once '../includes/auth.php';
require_once '../config/db.php';

$cart = $_SESSION['cart'] ?? [];
if(!$cart){ header('Location: cart.php'); exit; }

$ids = array_keys($cart);
$in  = implode(',', array_fill(0,count($ids),'?'));
$stmt= $pdo->prepare("SELECT id,price FROM books WHERE id IN ($in)");
$stmt->execute($ids);
$prices = $stmt->fetchAll(PDO::FETCH_UNIQUE);

$total = 0;
foreach($cart as $id=>$q) $total += $prices[$id]['price']*$q;

$pdo->beginTransaction();
try{
    $orderStmt = $pdo->prepare("INSERT INTO orders (user_id,total) VALUES (?,?)");
    $orderStmt->execute([$_SESSION['user_id'],$total]);
    $orderId = $pdo->lastInsertId();

    $itemStmt = $pdo->prepare(
        "INSERT INTO order_items (order_id,book_id,quantity,price) VALUES (?,?,?,?)"
    );
    foreach($cart as $id=>$q){
        $itemStmt->execute([$orderId,$id,$q,$prices[$id]['price']]);
    }
    $pdo->commit();
    unset($_SESSION['cart']);
    $msg = 'Order placed!';
} catch(Exception $e){
    $pdo->rollBack();
    $msg = 'Checkout failed: '.$e->getMessage();
}

$title='Checkout';
include '../includes/header.php';
echo "<h1>$msg</h1>";
include '../includes/footer.php';