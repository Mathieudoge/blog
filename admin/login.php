<?php
session_start();
include('config/config.php');
include('lib/db.lib.php');

$view = 'login.phtml';
$email = '';
$error = '';

if(!isset($_SESSION['logged']) || $_SESSION['logged'] != true){
  if (array_key_exists('email', $_POST)){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $dbh = connexion();
    $stmt = $dbh->prepare('SELECT id, firstname, lastname, email, password, rank
                            FROM users
                            WHERE email = :email');
    $stmt->bindValue('email', $email);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    if($data == false){
        $error = 'Identifiants incorrect';
    }
    else {
        $passConfirm = password_verify($password, $data['password']);
        if($passConfirm == true){
            $_SESSION['logged'] = true;
            $_SESSION['user'] = ['id'=>$data['id'],'firstname'=>$data['firstname'],'lastname'=>$data['lastname'],'rank' =>$data['rank']];
            header('Location: index.php');
        }
        else{
            $error = 'Identifiants incorrect';
        }
    }
}  
}
else{
    header('Location: http://localhost/blog/admin/index.php');
}  



include('tpl/layout.phtml');