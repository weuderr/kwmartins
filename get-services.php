<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    // Definindo o cabeçalho para o retorno em JSON
    header('Content-Type: application/json');

    // Verifica se a requisição é do tipo GET
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        define('BASE_PATH', realpath(dirname(__FILE__)));
        require BASE_PATH . '/pages/db_connect.php';

        $services = $database->query("SELECT * FROM services WHERE is_active = 1 AND deleted_at IS NULL ORDER BY category_id, name");
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
    }else if($_SERVER['REQUEST_METHOD'] === 'POST') {
          $data = json_decode(file_get_contents('php://input'), true);

          if (isset($_POST['categoria'])) {
              $categoria = $_POST['categoria'];

              define('BASE_PATH', realpath(dirname(__FILE__)));
              require BASE_PATH . '/pages/db_connect.php';

              $categorias = $database->prepare("SELECT services.* FROM services JOIN categories ON services.category_id = categories.id WHERE categories.name = :categoria AND services.is_active = 1 ORDER BY services.name");
              $categorias->execute([':categoria' => $categoria]);
              $resultados = $categorias->fetchAll(PDO::FETCH_ASSOC);

              if ($resultados) {
                  echo json_encode(array('status' => 'success', 'services' => $resultados));
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