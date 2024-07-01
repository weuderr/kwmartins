<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    // Definindo o cabeçalho para o retorno em JSON
    header('Content-Type: application/json');

    // Verifica se a requisição é do tipo GET
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        define('BASE_PATH', realpath(dirname(__FILE__)));
        require BASE_PATH . '/pages/db_connect.php';

        $categoriesRaw = $database->query("SELECT * FROM categories WHERE deleted_at IS NULL ORDER BY name");
        $categories = $categoriesRaw->fetchAll(PDO::FETCH_ASSOC);

        foreach ($categories as $key => $category) {
            // Aplicar utf8_encode se houver problemas de codificação
            $categories[$key]['name'] = $category['name'];
            $categories[$key]['description'] = $category['description'];
            $categories[$key]['image'] = $category['image'];
        }

        // Retornando JSON com a codificação UTF-8
        echo json_encode(array('status' => 'success', 'categories' => $categories));
    } else if($_SERVER['REQUEST_METHOD'] === 'POST') {
         $data = json_decode(file_get_contents('php://input'), true);

         if (isset($_POST['categoria'])) {
             $categoria = $_POST['categoria'];

             define('BASE_PATH', realpath(dirname(__FILE__)));
             require BASE_PATH . '/pages/db_connect.php';

             $categorias = $database->prepare("SELECT * FROM categories WHERE name = :categoria AND deleted_at IS NULL");
             $categorias->execute([':categoria' => $categoria]);
             $categorias = $categorias->fetch(PDO::FETCH_ASSOC);

             if ($categorias) {
                 echo json_encode(array('status' => 'success', 'categorias' => $categorias));
             } else {
                 echo json_encode(array('status' => 'error', 'message' => 'Serviço não encontrado'));
             }
         } else {
             echo json_encode(array('status' => 'error', 'message' => 'Parâmetros inválidos'));
         }
     } else {
         echo json_encode(array('status' => 'error', 'message' => 'Método não permitido'));
     }
?>