<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    // Definindo o cabeçalho para o retorno em JSON
    header('Content-Type: application/json');

    // Verifica se a requisição é do tipo GET
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        define('BASE_PATH', realpath(dirname(__FILE__)));
        require BASE_PATH . '/pages/db_connect.php';

        $services = $database->query("SELECT * FROM services WHERE is_active = 1 ORDER BY category_id, name");
        $services = $services->fetchAll(PDO::FETCH_ASSOC);

        foreach ($services as $key => $service) {
            // Aplicar utf8_encode se houver problemas de codificação
            $services[$key]['name'] = $service['name'];
            $services[$key]['description'] = $service['description'];
            $services[$key]['duration'] = $service['duration'];
            $services[$key]['category_id'] = $service['category_id'];
            $services[$key]['price'] = number_format($service['price'], 2, ',', '.');
        }

        // Retornando JSON com a codificação UTF-8
        echo json_encode(array('status' => 'success', 'services' => $services));
    }
?>