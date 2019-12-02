<?php 
session_start();
include('config/config.php');
include('lib/db.lib.php');
include('lib/lib.php');
include('../models/user.php');
$view = 'addUser.phtml';
$error = [];
$error['username'] = '';
$error['email'] = '';
$error['name'] = '';
$error['password'] = '';
$error['error'] = '';
$username = '';
$firstname = '';
$lastname = '';
$password = '';
$confirmpass = '';
$email = '';
$bio = '';

try{
    if(isLogged(RANK_ADMIN) == true){
        if(array_key_exists('username', $_POST)){
            $username = $_POST['username'];
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            $bio = $_POST['bio'];
            $avatar = addImage('../images/users/');
            $error['avatar'] = $avatar['error'];
            $error['error'] = $avatar['error'];
            $rank = $_POST['rank'];
            $data = checkDuplicateUser($username, $email);

            if(strlen($username) > USERNAME_MAX){
                $error['username'] = 'Le nom d\'utilisateur est trop long (maximum ' . USERNAME_MAX . ' caractères)';
                $error['error'] = 'true';
            }
            else if (strlen($username) < USERNAME_MIN){
                $error['username'] = 'Le nom d\'utilisateur est trop court (minimum ' . USERNAME_MIN . ' caractères)';
                $error['error'] = 'true';
            }
            else if (ctype_alnum($username) == false){
                $error['username'] = 'Le nom d\'utilisateur contient des caractères invalide';
                $error['error'] = 'true';
            }
            else if($username == $data['username']){
                $error['username'] = 'Le nom d\'utilisateur est déjà utilisé';
                $error['error'] = 'true';  
            }
            if($email == $data['email']){
                $error['email'] = 'L\'email est déjà utilisé';
                $error['error'] = 'true';
            }
            else if(filter_var($email, FILTER_VALIDATE_EMAIL) == false){
                $error['email'] = 'L\'email est invalide';
                $error['error'] = 'true';
            }
            if (ctype_alpha($firstname) == false || ctype_alpha($lastname) == false){
                $error['name'] = 'Le nom ou prénom contient des caractères invalide';
                $error['error'] = 'true';
            }
            if(strlen($_POST['password']) < PASSWORD_MIN){
                $error['password'] = 'Le mot de passe est trop faible (minimum ' . PASSWORD_MIN . ' caractères)';
                $error['error'] = 'true'; 
            } 
            if ($_POST['password'] != $_POST['confirmpass']){
                $error['password'] = 'Le mot de passe est différent entre les 2 champs';
                $error['error'] = 'true';
            }
            if($_POST['username'] == $_POST['password']){
                $error['password'] = 'Le mot de passe est similaire au nom d\'utilisateur';
                $error['error'] = 'true';
            }
            if ($error['error'] == ''){
                $date = new DateTime();
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                addUser($avatar['image'],$bio,$date->format('Y-m-d H:i:s'),$email,$firstname,$lastname,$passwordHash,$username,$rank);
                header('Location: listUser.php');
                exit();     
            }
        }
        include('tpl/layout.phtml');
    }
}
catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}