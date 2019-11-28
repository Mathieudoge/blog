<?php
include('config/config.php');
include('lib/db.lib.php');

if(!isset($_SESSION['logged']) || $_SESSION['logged'] != true || $_SESSION['user']['rank'] != 'admin'){
    $error = 'Vous ne pouvez pas accédez a cette page car vous n\'êtes pas connecté ou vous ne disposez pas des droits suffisants';
    header('Location: index.php');
}
else{
    $view = 'listUser.phtml';





    include('tpl/layout.phtml');
}
