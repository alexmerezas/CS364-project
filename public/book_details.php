<?php
require_once '../config/db.php';
$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM books WHERE id=?");
$stmt->execute([$id]);
$books = $stmt->fetch();
if(!$book) { http_response_code(404); exit('Not found'); }

session_start();
if($_SERVER['REQUEST_METHOD']==='POST'){
    $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
    header("Location: book_details.php?id=$id&added=1");
    exit;
}

$title = $book['title'];
include '../includes/header.php';
?>
<h1><?= htmlspecialchars($book['title']) ?></h1>
<img src="<?= $book['image'] ?>" class="img-fluid" style="max-width:250px">
<p class="mt-3"><?= nl2br(htmlspecialchars($book['description'])) ?></p>
<p class="h4">&euro;<?= $book['price'] ?></p>
<?php if(isset($_GET['added'])) echo "<p class='text-success'>Added to cart.</p>"; ?>
<form method="post">
    <button class="btn btn-primary">Add to cart</button>
</form>
<?php include '../includes/footer.php'; ?>