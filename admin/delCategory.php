<?php 
session_start();
include('config/config.php');
include('lib/db.lib.php');
include('lib/lib.php');
include('../models/category.php');

try{
    if (isLogged(RANK_AUTHOR) == true && array_key_exists('id', $_GET)){
        $id = $_GET['id'];  
        deleteCategory($id);
        header('Location: listCategory.php');
        exit();
    }    
}
catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}