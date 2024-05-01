<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    // Definindo o cabeçalho para o retorno em JSON
    header('Content-Type: application/json');

    // Verifica se a requisição é do tipo GET
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        define('BASE_PATH', realpath(dirname(__FILE__)));
        require BASE_PATH . '/pages/db_connect.php';

        $categoriesRaw = $database->query("SELECT * FROM categories ORDER BY name");
        $categories = $categoriesRaw->fetchAll(PDO::FETCH_ASSOC);

        foreach ($categories as $key => $category) {
            // Aplicar utf8_encode se houver problemas de codificação
            $categories[$key]['name'] = $category['name'];
            $categories[$key]['description'] = $category['description'];
            $categories[$key]['image'] = $category['image'];
        }

        // Retornando JSON com a codificação UTF-8
        echo json_encode(array('status' => 'success', 'categories' => $categories));
    }
?>