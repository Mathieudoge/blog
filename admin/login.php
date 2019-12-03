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
    try{
        $dbh = connexion();
        $stmt = $dbh->prepare('SELECT id, firstname, lastname, email, password, rank
                                FROM users
                                WHERE email = :email');
        $stmt->bindValue('email', $email);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        $id = $data['id'];
    }
    catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage() . "<br/>";
        die();
    }
    if($data == false){
        $error = 'Identifiants incorrect';
    }
    else {
        $passConfirm = password_verify($password, $data['password']);
        if($passConfirm == true){
            try{
            $date = new DateTime();
            $stmt = $dbh->prepare('UPDATE users
                                    SET last_login_date = :date
                                    WHERE id = :id ');
            $stmt->bindValue('id', $id);
            $stmt->bindValue('date', $date->format("Y-m-d H:i:s"));
            $stmt->execute();
            $_SESSION['logged'] = true;
            $_SESSION['user'] = ['id'=>$data['id'],'firstname'=>$data['firstname'],'lastname'=>$data['lastname'],'rank' =>$data['rank']];
            header('Location: index.php');
            }
            catch (PDOException $e) {
                print "Erreur !: " . $e->getMessage() . "<br/>";
                die();
            }
        }
        else{
            $error = 'Identifiants incorrect';
        }
        }

}  
include('tpl/layout.phtml');
}
else{
    header('Location: index.php');
}  



