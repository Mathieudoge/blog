<?php
session_start();
include('config/config.php');
include('lib/db.lib.php');
include('lib/lib.php');
include('../models/user.php');

try{
    if (isLogged(RANK_ADMIN) == true){
        $view = 'listUser.phtml';
        $usersData = listUser();
        include('tpl/layout.phtml');
    }
}
catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}