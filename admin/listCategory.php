<?php
session_start();
include('config/config.php');
include('lib/db.lib.php');
include('lib/lib.php');
include('../models/category.php');

try{
    if (isLogged(RANK_AUTHOR) == true){
        $view = 'listCategory.phtml';
        $categories = listCategory();
    }
    include('tpl/layout.phtml'); 
}
catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}