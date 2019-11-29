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

function checkFormData($username, $data, $email, $firstname, $lastname,$error){
    if(strlen($username) > USERNAME_MAX){
        $error['username'] = 'Le nom d\'utilisateur est trop long (maximum ' . USERNAME_MAX . ' caractères)';
        $error['error'] = 'true';
    }
    else if (strlen($username) < USERNAME_MIN){
        $error['username'] = 'Le nom d\'utilisateur est trop court (minimum ' . USERNAME_MIN . ' caractères)';
        $error['error'] = 'true';
    }
    else if (ctype_alnum($username) == false){
        $error['username'] = 'Le nom d\'utilisateur contient des caractères invalide';
        $error['error'] = 'true';
    }
    else if($username == $data['username']){
        $error['username'] = 'Le nom d\'utilisateur est déjà utilisé';
        $error['error'] = 'true';  
    }
    if($email == $data['email']){
        $error['email'] = 'L\'email est déjà utilisé';
        $error['error'] = 'true';
    }
    else if(filter_var($email, FILTER_VALIDATE_EMAIL) == false){
        $error['email'] = 'L\'email est invalide';
        $error['error'] = 'true';
    }
    if (ctype_alpha($firstname) == false || ctype_alpha($lastname) == false){
        $error['name'] = 'Le nom ou prénom contient des caractères invalide';
        $error['error'] = 'true';
    }
    if(strlen($_POST['password']) < PASSWORD_MIN){
        $error['password'] = 'Le mot de passe est trop faible (minimum ' . PASSWORD_MIN . ' caractères)';
        $error['error'] = 'true'; 
    } 
    if ($_POST['password'] != $_POST['confirmpass']){
        $error['password'] = 'Le mot de passe est différent entre les 2 champs';
        $error['error'] = 'true';
    }
    if($_POST['username'] == $_POST['password']){
        $error['password'] = 'Le mot de passe est similaire au nom d\'utilisateur';
        $error['error'] = 'true';
    
    }
    return $error;
} 