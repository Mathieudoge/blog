<?php 
session_start();
include('config/config.php');
include('lib/db.lib.php');
include('lib/lib.php');

$view = 'index.phtml';
$error = '';
if (isLogged(RANK_AUTHOR) == true){

   include('tpl/layout.phtml'); 
}



