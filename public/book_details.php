<?php
require_once '../config/db.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare(
  "SELECT b.*, g.name AS genre 
   FROM books b 
   JOIN genres g ON b.genre_id = g.id 
   WHERE b.id = ?"
);
$stmt->execute([$id]);
$book = $stmt->fetch();
if (!$book) { http_response_code(404); exit('Not found'); }

session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
    header("Location: book_details.php?id=$id&added=1");
    exit;
}

$title = $book['title'];
include '../includes/header.php';
?>

<div class="container mt-4">
  <div class="row">
    <div class="col-md-4">
      <img src="/images/<?= htmlspecialchars($book['image']) ?>" class="img-fluid rounded shadow" alt="Cover image">
    </div>
    <div class="col-md-8">
      <h2><?= htmlspecialchars($book['title']) ?> (<?= $book['pub_year'] ?>)</h2>
      <p class="text-muted"><strong>by <?= htmlspecialchars($book['author']) ?></strong></p>
      <p><strong>Genre:</strong> <?= htmlspecialchars($book['genre']) ?></p>
      <p><strong>Publisher:</strong> <?= htmlspecialchars($book['publisher']) ?></p>
      <p><strong>ISBN:</strong> <?= htmlspecialchars($book['isbn']) ?></p>
      <p><strong>Price:</strong> &euro;<?= number_format($book['price'], 2) ?></p>
      <?php if (isset($_GET['added'])): ?>
        <p class="text-success">Added to cart.</p>
      <?php endif; ?>
      <form method="post">
        <button class="btn btn-primary">Add to cart</button>
      </form>
    </div>
  </div>

  <hr class="my-4">

  <div>
    <h5>Description</h5>
    <p><?= nl2br(htmlspecialchars($book['description'])) ?></p>
  </div>
</div>

<?php include '../includes/footer.php'; ?>