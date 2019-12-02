<?php 
session_start();
include('config/config.php');
include('lib/db.lib.php');
include('lib/lib.php');
include('../models/category.php');
$view = 'addCategory.phtml';
$error = '';

if(isLogged(RANK_AUTHOR) == true){
    if(array_key_exists('category', $_POST)){
        $category = $_POST['category'];

        if (ctype_alpha($category) == false){
            $error = 'Le nom de la catégorie contient des caractères invalide';
        }
        else if (strlen($category) > CATEGORY_MAX){
            $error = 'Le nom de la catégorie est trop longue (limite ' . CATEGORY_MAX . ' caractères)';
        }
        if($error == ''){
            addCategory($category);
            header('Location: listCategory.php');
            exit();
        }
    }
    include('tpl/layout.phtml');
}

