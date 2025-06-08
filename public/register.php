<?php
require_once '../config/db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name']);
    $email = trim($_POST['email']);
    $pass  = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (name,email,password) VALUES (?,?,?)");
    try {
        $stmt->execute([$name,$email,$pass]);
        header('Location: login.php?registered=1');
        exit;
    } catch (PDOException $e) {
        $error = 'Email already in use';
    }
}
$title = 'Register';
include '../includes/header.php';
?>
<h1>Register</h1>
<?php if(isset($error)) echo "<p class='text-danger'>$error</p>"; ?>
<form method="post">
  <div class="mb-3"><input name="name" class="form-control" placeholder="Name" required></div>
  <div class="mb-3"><input type="email" name="email" class="form-control" placeholder="Email" required></div>
  <div class="mb-3"><input type="password" name="password" class="form-control" placeholder="Password" required></div>
  <button class="btn btn-primary">Sign up</button>
</form>
<?php include '../includes/footer.php'; ?>
