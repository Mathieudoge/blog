<?php
session_start();
include('admin/lib/db.lib.php');
include('admin/config/config.php');
include('models/article.php');
$view = 'index.phtml';

$articles = listArticle();


include('tpl/layout.phtml');