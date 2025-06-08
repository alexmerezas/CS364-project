<?php
include '../../includes/admin_guard.php';

$rows = $pdo->query('SELECT id,title,price FROM books LIMIT 200')->fetchAll();
$title = 'Admin – Products';
include '../../includes/header.php';
?>
<h1>Products</h1>
<a class="btn btn-success mb-3" href="product_edit.php">Add new</a>
<table class="table table-striped">
 <?php foreach($rows as $r): ?>
 <tr>
   <td><?= $r['id'] ?></td>
   <td><?= htmlspecialchars($r['title']) ?></td>
   <td>€<?= number_format($r['price'],2) ?></td>
   <td>
     <a href="product_edit.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
     <a href="product_delete.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-danger"
        onclick="return confirm('Delete?')">Del</a>
   </td>
 </tr>
 <?php endforeach; ?>
</table>
<?php include '../../includes/footer.php'; ?>