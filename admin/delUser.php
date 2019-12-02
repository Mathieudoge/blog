<?php 
session_start();
include('config/config.php');
include('lib/db.lib.php');
include('lib/lib.php');
include('../models/user.php');

try{
    if (isLogged(RANK_ADMIN) == true && array_key_exists('id', $_GET)){
        $id = $_GET['id'];  
        deleteUser($id);
        header('Location: listUser.php');
        exit();
    }    
}
catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}