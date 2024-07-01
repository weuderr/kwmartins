<?php
if ($_FILES['image']['name']) {
    $filename = $_FILES['image']['name'];

    // Diretório base do projeto
    $base_dir = dirname(dirname(dirname(__DIR__)));
    $unique_name = uniqid('', true) . '-' . basename($filename);
    $location = $base_dir . '/uploads/' . $unique_name;

    // Certifique-se de que a pasta 'uploads' existe
    if (!file_exists($base_dir . '/uploads')) {
        mkdir($base_dir . '/uploads', 0777, true);
    }

    if (move_uploaded_file($_FILES['image']['tmp_name'], $location)) {
        $url = '/uploads/' . $unique_name; // Caminho relativo para uso no navegador
        echo json_encode(['url' => $url]);
    } else {
        echo json_encode(['error' => 'Erro ao mover a imagem para o destino.']);
    }
} else {
    echo json_encode(['error' => 'Erro ao carregar a imagem.']);
}
?>
