<?php 

include('config/config.php');
include('lib/db.lib.php');
include('lib/lib.php');

session_start();

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


if(isLogged(RANK_ADMIN) == true){
    if(array_key_exists('username', $_POST)){
        $username = $_POST['username'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $bio = $_POST['bio'];
        $avatar = $_POST['avatar'];
        $rank = $_POST['rank'];
        $dbh = connexion();
        $stmt = $dbh->prepare('SELECT username, email 
                                FROM users
                                WHERE username = :username OR email = :email');
        $stmt->bindValue('username', $username);
        $stmt->bindValue('email', $email);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        $error = checkFormData($username, $data, $email, $firstname, $lastname, $error);
        if ($error['error'] == ''){
            $date = new DateTime();
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $dbh->prepare('INSERT INTO users (avatar, bio, created_date, email, firstname, lastname, password, username, rank)
            VALUES (:avatar,:bio,:date,:email,:firstname,:lastname,:password,:username, :rank)');
            $stmt->bindValue('avatar',$avatar);
            $stmt->bindValue('bio', $bio);
            $stmt->bindValue('date',$date->format("Y-m-d h:i:s"));
            $stmt->bindValue('email', $email);
            $stmt->bindValue('firstname', $firstname);
            $stmt->bindValue('lastname', $lastname);
            $stmt->bindValue('password', $passwordHash);
            $stmt->bindValue('username', $username);
            $stmt->bindValue('rank', $rank);
            $stmt->execute();

            header('Location: listUser.php');
        }
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
