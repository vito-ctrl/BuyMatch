<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once __DIR__ . "/../config/database.php";
    require_once "../classes/User.php";

    if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
        die("invalide request");
    }

    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'buyer';
    

    if (empty($name) || empty($email) || empty($password) || empty($role)) {
        die('All fields are required');
    }

    $db = new Database();
    $pdo = $db->connect();

    if(User::findByEmail($email, $pdo)) {
        die ("email already registered");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('Invalid email');
    }
    
    $user = User::creat($name, $email, $password, $role, $pdo);

    session_start();
    $_SESSION['user_id'] = $user->getId();
    $_SESSION['user_name'] = $user->getName();
    $_SESSION['user_role'] = $user->getRole();

    header("Location: ../pages/register.php");
    exit;

?>