<?php
    ini_set('dispaly_errors', 1);
    error_reporting(E_ALL);

    session_start();

    require_once '../config/database.php';
    require_once '../classes/User.php';

    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        die ('wrong method');
    }

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if(empty($password) || empty($email)) {
        die('required all field');
    }

    $db = new Database();
    $pdo = $db->connect();

    $user = User::findByEmail($email, $pdo);

    if(!$user) {
        die ('Ivalide email');
    }

    if(!$user->verifyPassword($password)){
        die ('Invalid password');
    }

    if($user->getStatus() !== 'active') {
        die('account disabled');
    }

    $_SESSION['user_id'] = $user->getId();
    $_SESSION['user_name'] = $user->getName();
    $_SESSION['user_role'] = $user->getRole();

    echo "done succesfully";
?>