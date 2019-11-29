<?php
session_start();
include('config/config.php');
include('lib/db.lib.php');
include('lib/lib.php');

if (isLogged(RANK_ADMIN) == true){
    $view = 'listUser.phtml';

    $dbh = connexion();
    $stmt = $dbh->prepare('SELECT id, username, email, firstname, lastname, bio, created_date, last_login_date, rank, avatar
                            FROM users');
    $stmt->execute();
    $usersData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    include('tpl/layout.phtml');

    // DELETE FROM `users` WHERE `users`.`id` = 22
}
