<?php
$title = 'Home';
require_once '../config/db.php';
include '../includes/header.php';

$recent = $pdo->query(
  "SELECT id,title,price,image FROM books ORDER BY created_at DESC LIMIT 6"
)->fetchAll();

$firstCat = $pdo->query("SELECT id FROM genres LIMIT 1")->fetchColumn();
$catStmt  = $pdo->prepare(
  "SELECT id,title,price,image FROM books WHERE genre_id = ? LIMIT 6"
);
$catStmt->execute([$firstCat]);
$featured = $catStmt->fetchAll();
?>

<div class="p-5 mb-4 bg-light rounded-3">
  <h1 class="display-5 fw-bold">Book Shop Demo</h1>
  <p class="lead">Semester project for CS364.</p>
  <a href="books.php" class="btn btn-primary btn-lg">Browse All</a>
</div>

<h2 class="mb-3">Recent Books</h2>
<div class="row">
  <?php foreach($recent as $p): ?>
    <div class="col-6 col-md-4 col-lg-2 mb-4">
      <div class="card h-100">
        <img src="<?= $p['image'] ?>" class="card-img-top" alt="">
        <div class="card-body text-center">
          <h6><?= htmlspecialchars($p['title']) ?></h6>
          <p>&euro;<?= $p['price'] ?></p>
          <a href="book_details.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-primary">View</a>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<h2 class="mb-3">Genre Highlights</h2>
<div class="row">
  <?php foreach($featured as $p): ?>
    <div class="col-6 col-md-4 col-lg-2 mb-4">
      <div class="card h-100">
        <img src="<?= $p['image'] ?>" class="card-img-top" alt="">
        <div class="card-body text-center">
          <h6><?= htmlspecialchars($p['title']) ?></h6>
          <p>&euro;<?= $p['price'] ?></p>
          <a href="book_details.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-primary">View</a>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<?php include '../includes/footer.php'; ?>