<?php
$dbh = connexion();

function addCategory($category){
    global $dbh;
    $stmt = $dbh->prepare('INSERT INTO categories (name)
                            VALUES (:category)');
    $stmt->bindValue('category', $category);
    $stmt->execute();
}

function listCategory(){
    global $dbh;
    $stmt = $dbh->prepare('SELECT id, name
                            FROM categories');
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $categories;
}
function deleteCategory($id){
    deleteContent('categoris', $id);
}