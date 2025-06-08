<?php
require_once '../config/db.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $pass  = $_POST['password'];

    $stmt = $pdo->prepare("SELECT id,password,role FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user && password_verify($pass, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role']    = $user['role'];
        header('Location: index.php');
        exit;
    }
    $error = 'Wrong credentials';
}
$title='Login';
include '../includes/header.php';
?>
<h1>Login</h1>
<?php if(isset($_GET['registered'])) echo "<p class='text-success'>Account created, please sign in.</p>"; ?>
<?php if(isset($error)) echo "<p class='text-danger'>$error</p>"; ?>
<form method="post">
  <div class="mb-3"><input type="email" name="email" class="form-control" placeholder="Email" required></div>
  <div class="mb-3"><input type="password" name="password" class="form-control" placeholder="Password" required></div>
  <button class="btn btn-primary">Login</button>
</form>
<?php include '../includes/footer.php'; ?>