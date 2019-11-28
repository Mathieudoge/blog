<?php 

include('config/config.php');
include('lib/db.lib.php');

$view = 'addUser.phtml';
$error = '';
$username = '';
$firstname = '';
$lastname = '';
$password = '';
$confirmpass = '';
$email = '';
$bio = '';
$nameInvalid = false;
$usernameInvalid = false;
$emailInvalid = false;
$passwordInvalid = false;



if(array_key_exists('username', $_POST)){
    $username = $_POST['username'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $bio = $_POST['bio'];
    $avatar = $_POST['avatar'];
    $dbh = connexion();
    $stmt = $dbh->prepare('SELECT username, email 
                            FROM users
                            WHERE username = :username OR email = :email');
    $stmt->bindValue('username', $username);
    $stmt->bindValue('email', $email);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    var_dump($data);

    if(strlen($username) > USERNAME_MAX){
        $usernameInvalid = true;
        $error = 'Le nom d\'utilisateur est trop long (maximum ' . USERNAME_MAX . ' caractères)';
    }
    else if (strlen($username) < USERNAME_MIN){
        $usernameInvalid = true;
        $error = 'Le nom d\'utilisateur est trop court (minimum ' . USERNAME_MIN . ' caractères)';
    }
    else if (ctype_alnum($username) == false){
        $usernameInvalid = true;
        $error = 'Le nom d\'utilisateur contient des caractères invalide';
    }
    if($username == $data['username']){
        $usernameInvalid = true;
        $error = 'Le nom d\'utilisateur est déjà utilisé';  
    }
    else if($email == $data['email']){
        $emailInvalid = true;
        $error = 'L\'email est déjà utilisé';
    }
    if (ctype_alpha($firstname) == false || ctype_alpha($lastname) == false){
        $nameInvalid = true;
        $error = 'Le nom ou prénom contient des caractères invalide';
    }
    if(strlen($_POST['password']) < PASSWORD_MIN){
        $passwordInvalid = true;
        $error = 'Le mot de passe est trop faible (minimum ' . PASSWORD_MIN . ' caractères)'; 
    } 
    if ($_POST['password'] != $_POST['confirmpass']){
        $passwordInvalid = true;
        $error = 'Le mot de passe est différent entre les 2 champs';
    }
    if($_POST['username'] == $_POST['password']){
        $passwordInvalid = true;
        $error = 'Le mot de passe est similaire au nom d\'utilisateur';
       
    }
    if ($error == ''){
        $date = new DateTime();
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $dbh->prepare('INSERT INTO users (avatar, bio, created_date, email, firstname, lastname, password, username)
       VALUES (:avatar,:bio,:date,:email,:firstname,:lastname,:password,:username)');
        $stmt->bindValue('avatar',$avatar);
        $stmt->bindValue('bio', $bio);
        $stmt->bindValue('date',$date->format("Y-m-d h:i:s"));
        $stmt->bindValue('email', $email);
        $stmt->bindValue('firstname', $firstname);
        $stmt->bindValue('lastname', $lastname);
        $stmt->bindValue('password', $passwordHash);
        $stmt->bindValue('username', $username);
        $stmt->execute();
    }
}
// function refill(){
//     var_dump($_POST);
//     $username = $_POST['username'];
//     $email = $_POST['email'];
//     $bio = $_POST['bio'];
// }


// INSERT INTO users (avatar, bio, created_date, email, firstname, lastname, password, username)
// VALUES ('coucou', 'je suis le grand méchant loup', CURRENT_TIMESTAMP, 'coucou@gmail.com', 'Patrick', 'Sébastien', 'superpatrick', 'Patricia2003')
include('tpl/layout.phtml');
