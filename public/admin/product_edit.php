<?php
include '../../includes/admin_guard.php';
$id   = (int)($_GET['id'] ?? 0);
$book = [];
if ($id) {
    $stmt = $pdo->prepare('SELECT * FROM books WHERE id = ?');
    $stmt->execute([$id]);
    $book = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
}

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $data = [
      $_POST['title'], $_POST['price'], $_POST['author'],
      $_POST['pub_year'], $_POST['genre_id'], $id
    ];
    if ($id) {
        $pdo->prepare("UPDATE books SET title=?,price=?,author=?,pub_year=?,genre_id=? WHERE id=?")
            ->execute($data);
    } else {
        array_pop($data);      // no id for INSERT
        $pdo->prepare("INSERT INTO books (title,price,author,pub_year,genre_id) VALUES (?,?,?,?,?)")
            ->execute($data);
    }
    header('Location: products.php'); exit;
}

include '../../includes/header.php';
?>
<h1><?= $id ? 'Edit' : 'Add' ?> product</h1>

<form method="post" class="row g-3">
  <div class="col-md-6">
    <label class="form-label">Title</label>
    <input name="title" class="form-control" required
           value="<?= htmlspecialchars($book['title'] ?? '') ?>">
  </div>
  <div class="col-md-3">
    <label class="form-label">Price (€)</label>
    <input name="price" type="number" step="0.01" class="form-control" required
           value="<?= $book['price'] ?? '' ?>">
  </div>
  <div class="col-md-6">
    <label class="form-label">Author</label>
    <input name="author" class="form-control"
           value="<?= htmlspecialchars($book['author'] ?? '') ?>">
  </div>
  <div class="col-md-3">
    <label class="form-label">Publication year</label>
    <input name="pub_year" type="number" class="form-control"
           value="<?= $book['pub_year'] ?? '' ?>">
  </div>
  <div class="col-md-4">
    <label class="form-label">Genre id</label>
    <input name="genre_id" type="number" class="form-control"
           value="<?= $book['genre_id'] ?? '' ?>">
  </div>
  <div class="col-12">
    <button class="btn btn-primary">Save</button>
    <a href="products.php" class="btn btn-secondary">Cancel</a>
  </div>
</form>
<?php
include '../../includes/footer.php';