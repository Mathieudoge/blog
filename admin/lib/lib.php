<?php
function isLogged($accessPower){
    if(!isset($_SESSION['logged']) || $_SESSION['logged'] != true || rankPower() < $accessPower){
        header('Location: index.php');
        $error = 'Vous ne pouvez pas accédez a cette page car vous n\'êtes pas connecté ou vous ne disposez pas des droits suffisants';
        return false;
    }
    else{
        return true;
    }
}

function rankPower(){

    switch($_SESSION['user']['rank']){
        case 'ROLE_USER':
            $rank = RANK_USER;
            break;
        case 'ROLE_AUTHOR':
            $rank = RANK_AUTHOR;
            break;
        case 'ROLE_ADMIN':
            $rank = RANK_ADMIN;
    }
    return $rank;
}

function deleteContent($table,$id){
    $dbh = connexion();
    $stmt = $dbh->prepare('DELETE FROM ' . $table . ' 
                            WHERE id = :id');
    $stmt->bindValue('id', $id);
    $stmt->execute(); 
}

function addImage($dir){
    $image = [];
    $image['error'] = '';
    $image['image'] = uniqid().''.basename($_FILES["image"]["name"]);
    $target_file = $dir.$image['image'];

    if (file_exists($target_file)){
        $image['error'] = 'Erreur dans la base de données,réessayer plus tard';
    }
    if ($_FILES["image"]["size"] > IMAGE_SIZE_MAX){
        $image['error'] = 'Image trop volumineuse (max ' . IMAGE_SIZE_MAX . ' octets)';
    }

    if ($image['error'] == ''){
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file); 
    }
    return $image;
}

function displayImage($image){
    
}