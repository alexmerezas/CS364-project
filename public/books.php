<?php
require_once '../config/db.php';

//----------------------------------------------
// INPUT
//----------------------------------------------
$q   = trim($_GET['q']   ?? ''); // full‑text search term
$cat =      $_GET['cat'] ?? '';  // genre id (string; empty means "all")

//----------------------------------------------
// SUPPORTING DATA (all genres)
//----------------------------------------------
$genres = $pdo->query('SELECT id, name FROM genres ORDER BY name')
              ->fetchAll(PDO::FETCH_ASSOC);

//----------------------------------------------
// MAIN DATA SET
//----------------------------------------------
if ($q !== '') {
    // Re‑use positional placeholders to avoid HY093 (duplicate named params)
    $sql = "SELECT b.id, b.title, b.price, b.image, b.author, b.pub_year, g.name AS genre
            FROM books b
            JOIN genres g ON b.genre_id = g.id
            WHERE b.title       LIKE ?
               OR b.description LIKE ?
               OR b.author      LIKE ?
               OR b.publisher   LIKE ?
               OR b.isbn        LIKE ?";
    $params = array_fill(0, 5, "%$q%");
    $stmt   = $pdo->prepare($sql);
    $stmt->execute($params);
} else {
    $sql = "SELECT b.id, b.title, b.price, b.image, b.author, b.pub_year, g.name AS genre
            FROM books b
            JOIN genres g ON b.genre_id = g.id";
    $params = [];
    if ($cat !== '') {
        $sql   .= " WHERE b.genre_id = ?";
        $params = [$cat];
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
}
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

//----------------------------------------------
// PAGE META & HEADER
//----------------------------------------------
$title = $q ? 'Search – ' . htmlspecialchars($q) : 'Browse by Category';
include '../includes/header.php';
?>

<h1 class="mb-4">Browse by Category</h1>

<!-- Category (genre) pills + "All Books" option -->
<ul class="nav nav-pills flex-wrap mb-4">
  <li class="nav-item me-2 mb-2">
    <a class="nav-link <?= $cat === '' ? 'active' : '' ?>" href="books.php">All Books</a>
  </li>
  <?php foreach ($genres as $g): ?>
    <li class="nav-item me-2 mb-2">
      <a class="nav-link <?= $cat == $g['id'] ? 'active' : '' ?>"
         href="books.php?cat=<?= $g['id'] ?>">
        <?= htmlspecialchars($g['name']) ?>
      </a>
    </li>
  <?php endforeach; ?>
</ul>

<!-- Search bar (keeps cat hidden so you can search inside a category) -->
<form class="mb-4" method="get" action="books.php">
  <div class="input-group">
    <input type="text" class="form-control" name="q"
           value="<?= htmlspecialchars($q) ?>" placeholder="Search">
    <?php if ($cat !== '' && $q === ''): ?>
      <input type="hidden" name="cat" value="<?= htmlspecialchars($cat) ?>">
    <?php endif; ?>
    <button class="btn btn-outline-secondary">Search</button>
  </div>
</form>

<?php if (!$rows): ?>
  <p class="text-muted">No books found.</p>
<?php else: ?>
  <div class="row">
    <?php foreach ($rows as $p): ?>
      <div class="col-6 col-md-4 mb-4"><!-- 2 × 3 layout per spec -->
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
<?php endif; ?>

<?php include '../includes/footer.php'; ?>