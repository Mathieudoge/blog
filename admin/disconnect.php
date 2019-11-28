<?php
session_start();
if(array_key_exists('disconnect', $_POST)){
    $_SESSION['logged'] = false;
    unset($_SESSION['user']);
    header('Location: index.php');
}