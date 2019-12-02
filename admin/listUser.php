<?php
session_start();
include('config/config.php');
include('lib/db.lib.php');
include('lib/lib.php');

if (isLogged(RANK_ADMIN) == true){
    $view = 'listUser.phtml';
    try{
    $dbh = connexion();
    $stmt = $dbh->prepare('SELECT id, username, email, firstname, lastname, bio, created_date, last_login_date, rank, avatar
                            FROM users');
    $stmt->execute();
    $usersData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage() . "<br/>";
        die();
    }
    if(array_key_exists('id', $_GET)){
        $table = 'users';
        deleteContent($table);
        header('Location: listUser.php');
    }

    include('tpl/layout.phtml');
}
