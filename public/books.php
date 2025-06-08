<?php
require_once '../config/db.php';
$q   = $_GET['q']   ?? '';
$cat = $_GET['cat'] ?? '';

if($q){
    $sql = "SELECT id,title,price,image FROM books
            WHERE title LIKE ? OR description LIKE ?";
    $stmt= $pdo->prepare($sql);
    $stmt->execute(["%$q%","%$q%"]);
} else {
    $sql = $cat ? "SELECT id,title,price,image FROM books WHERE genre_id = ?" :
                  "SELECT id,title,price,image FROM books";
    $stmt= $pdo->prepare($sql);
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
      <img src="<?= $p['image'] ?>" class="card-img-top">
      <div class="card-body text-center">
        <h6><?= htmlspecialchars($p['title']) ?></h6>
        <p>&euro;<?= $p['price'] ?></p>
        <a class="btn btn-sm btn-outline-primary"
           href="book_details.php?id=<?= $p['id'] ?>">View</a>
      </div>
    </div>
  </div>
<?php endforeach; ?>
</div>
<?php include '../includes/footer.php'; ?>