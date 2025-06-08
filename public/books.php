<?php
require_once '../config/db.php';
$q   = $_GET['q']   ?? '';
$cat = $_GET['cat'] ?? '';

if ($q) {
    $sql = "SELECT b.id, b.title, b.price, b.image, b.author, b.pub_year, g.name AS genre
            FROM books b
            JOIN genres g ON b.genre_id = g.id
            WHERE b.title LIKE ?
               OR b.description LIKE ?
               OR b.author LIKE ?
               OR b.publisher LIKE ?
               OR b.isbn LIKE ?";
    $stmt = $pdo->prepare($sql);
    $like = "%$q%";
    $stmt->execute([$like, $like, $like, $like, $like]);
} else {
    $sql = $cat
        ? "SELECT b.id, b.title, b.price, b.image, b.author, b.pub_year, g.name AS genre
           FROM books b
           JOIN genres g ON b.genre_id = g.id
           WHERE b.genre_id = ?"
        : "SELECT b.id, b.title, b.price, b.image, b.author, b.pub_year, g.name AS genre
           FROM books b
           JOIN genres g ON b.genre_id = g.id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($cat ? [$cat] : []);
}
$rows = $stmt->fetchAll();

$title='Books';
include '../includes/header.php';
?>
<form class="mb-4" method="get">
  <div class="input-group">
    <input class="form-control" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Search">
    <button class="btn btn-outline-secondary">Search</button>
  </div>
</form>

<div class="row">
<?php foreach($rows as $p): ?>
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
        <a class="btn btn-sm btn-outline-primary"
           href="book_details.php?id=<?= $p['id'] ?>">View</a>
      </div>
    </div>
  </div>
<?php endforeach; ?>
</div>
<?php include '../includes/footer.php'; ?>