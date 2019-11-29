<?php 

include('config/config.php');
include('lib/db.lib.php');
include('lib/lib.php');

$view = 'addCategory.phtml';
$error = '';
session_start();
if(isLogged(RANK_ADMIN) == true){
    if(array_key_exists('category', $_POST)){

        $category = $_POST['category'];

        if (ctype_alpha($category) == false){
            $error = 'Le nom de la catégorie contient des caractères invalide';
        }
        else if (strlen($category) > CATEGORY_MAX){
            $error = 'Le nom de la catégorie est trop longue (limite ' . CATEGORY_MAX . ' caractères)';
        }
        if($error == ''){
            $dbh = connexion();
            $stmt = $dbh->prepare('INSERT INTO categories (name)
                                    VALUES (:category)');
            $stmt->bindValue('category', $category);
            $stmt->execute();
        }
    }
    
}

include('tpl/layout.phtml');