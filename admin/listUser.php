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
    if(array_key_exists('toDelete', $_POST)){
        $usersDataId = $_POST['toDelete'];
    }

    include('tpl/layout.phtml');

    // DELETE FROM `users` WHERE `users`.`id` = 22
}
