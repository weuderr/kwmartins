<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$base_dir = dirname(dirname(__DIR__));
require $base_dir  . '/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    if ($id) {
        // Update existing article
        $stmt = $database->prepare("UPDATE articles SET name = :name, title = :title, content = :content WHERE id = :id");
        $stmt->execute([':name' => $name, ':title' => $title, ':content' => $content, ':id' => $id]);
    } else {
        // Create new article
        $stmt = $database->prepare("INSERT INTO articles (name, title, content) VALUES (:name, :title, :content)");
        $stmt->execute([':name' => $name, ':title' => $title, ':content' => $content]);
    }

    header('Location: index.php');
    exit();
}
?>
