<?php 
session_start();
include('config/config.php');
include('lib/db.lib.php');

$view = 'index.phtml';
$error = '';



include('tpl/layout.phtml');