<?php
session_start();
require_once __DIR__.'/../config/db.php';

function login($email,$password){
    global $pdo;
    $stmt=$pdo->prepare("SELECT * FROM users WHERE email=?");
    $stmt->execute([$email]);
    $u=$stmt->fetch(PDO::FETCH_ASSOC);
    if($u && password_verify($password,$u['password'])){
        $_SESSION['uid']=$u['id'];
        $_SESSION['role']=$u['role'];
        return true;
    }
    return false;
}

function logout(){ session_destroy(); }

function user(){ return $_SESSION['uid'] ?? null; }

function isAdmin(){ return ($_SESSION['role'] ?? '')==='admin'; }

function guard($admin=false){
    if(!user() || ($admin && !isAdmin())){
        header("Location: /login.php"); exit;
    }
}