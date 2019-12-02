<?php
$dbh = connexion();

function addUser($avatar,$bio,$date,$email,$firstname,$lastname,$passwordHash,$username,$rank){
    global $dbh;
    $stmt = $dbh->prepare('INSERT INTO users (avatar, bio, created_date, email, firstname, lastname, password, username, rank)
                            VALUES (:avatar,:bio,:date,:email,:firstname,:lastname,:password,:username, :rank)');
    $stmt->bindValue('avatar',$avatar);
    $stmt->bindValue('bio', $bio);
    $stmt->bindValue('date',$date);
    $stmt->bindValue('email', $email);
    $stmt->bindValue('firstname', $firstname);
    $stmt->bindValue('lastname', $lastname);
    $stmt->bindValue('password', $passwordHash);
    $stmt->bindValue('username', $username);
    $stmt->bindValue('rank', $rank);
    $stmt->execute();
}
function checkDuplicateUser($username, $email){
    global $dbh;
    $stmt = $dbh->prepare('SELECT username, email 
                            FROM users
                            WHERE username = :username OR email = :email');
    $stmt->bindValue('username', $username);
    $stmt->bindValue('email', $email);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    return $data;

}
function listUser(){
    global $dbh;
    $stmt = $dbh->prepare('SELECT id, username, email, firstname, lastname, bio, created_date, last_login_date, rank, avatar
                                FROM users');
    $stmt->execute();
    $usersData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $usersData;
}
function deleteUser($id){
    deleteContent('users',$id);
}