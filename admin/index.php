<?php 
session_start();
include('config/config.php');
include('lib/db.lib.php');

$view = 'index.phtml';
$error = '';
var_dump($_SESSION);



include('tpl/layout.phtml');