<?php
$title = 'Promitheas Press';
require_once '../config/db.php';
include '../includes/header.php';

$recent = $pdo->query(
  "SELECT b.id, b.title, b.price, b.image, b.author, b.pub_year, g.name AS genre
   FROM books b
   JOIN genres g ON b.genre_id = g.id
   ORDER BY b.created_at DESC
   LIMIT 6"
)->fetchAll();

$firstCat = $pdo->query("SELECT id FROM genres LIMIT 1")->fetchColumn();
$catStmt = $pdo->prepare(
  "SELECT b.id, b.title, b.price, b.image, b.author, b.pub_year, g.name AS genre
   FROM books b
   JOIN genres g ON b.genre_id = g.id
   WHERE b.genre_id = ?
   LIMIT 6"
);
$catStmt->execute([$firstCat]);
$featured = $catStmt->fetchAll();
?>

<div class="p-5 mb-4 bg-light rounded-3">
  <h1 class="display-5 fw-bold">Promitheas Press</h1>
  <p class="lead">Books from Cypriot and Greek culture</p>
  <a href="books.php" class="btn btn-primary btn-lg">Browse All Books</a>
</div>

<h2 class="mb-3">Recently Added Books</h2>
<div class="row">
  <?php foreach ($recent as $p): ?>
    <div class="col-6 col-md-4 col-lg-2 mb-4">
      <div class="card h-100">
        <img src="/images/<?= htmlspecialchars($p['image']) ?>" class="card-img-top" alt="">
        <div class="card-body text-center">
          <h6 class="mb-1">
            <?= htmlspecialchars($p['title']) ?> 
            (<?= htmlspecialchars($p['pub_year']) ?>)
          </h6>
          <p class="text-muted mb-1">by <?= htmlspecialchars($p['author']) ?></p>
          <p class="text-muted small mb-2">(<?= htmlspecialchars($p['genre']) ?>)</p>
          <p class="fw-bold mb-2">&euro;<?= number_format($p['price'], 2) ?></p>
          <a href="book_details.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-primary">View</a>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<h2 class="mb-3">Genre Highlights</h2>
<div class="row">
  <?php foreach ($featured as $p): ?>
    <div class="col-6 col-md-4 col-lg-2 mb-4">
      <div class="card h-100">
        <img src="/images/<?= htmlspecialchars($p['image']) ?>" class="card-img-top" alt="">
        <div class="card-body text-center">
          <h6 class="mb-1">
            <?= htmlspecialchars($p['title']) ?> 
            (<?= htmlspecialchars($p['pub_year']) ?>)
          </h6>
          <p class="text-muted mb-1">by <?= htmlspecialchars($p['author']) ?></p>
          <p class="text-muted small mb-2">(<?= htmlspecialchars($p['genre']) ?>)</p>
          <p class="fw-bold mb-2">&euro;<?= number_format($p['price'], 2) ?></p>
          <a href="book_details.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-primary">View</a>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<?php include '../includes/footer.php'; ?>