include '../../includes/admin_guard.php';
$pdo->prepare('DELETE FROM books WHERE id=?')->execute([(int)$_GET['id']]);
header('Location: products.php');
exit;