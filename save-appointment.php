<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    // Verifica se a requisição é do tipo POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Define o caminho do arquivo de banco de dados SQLite
        $database = new PDO('sqlite:/home/u685667027/domains/kwmartins.pt/public_html/visitantes.db');

        $database->exec('CREATE TABLE IF NOT EXISTS appointments (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT, phone TEXT, message TEXT, professionalPhone TEXT, date TEXT)');

        // Prepara os dados recebidos do AJAX
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $message = $_POST['message'];
        $professionalPhone = $_POST['professionalPhone'];
        $data = $_POST['date'];

        // Prepara a query de inserção
        $query = $database->prepare('INSERT INTO appointments (name, phone, message, professionalPhone) VALUES (:name, :phone, :message, :professionalPhone)');
        $query->bindParam(':name', $name);
        $query->bindParam(':phone', $phone);
        $query->bindParam(':message', $message);
        $query->bindParam(':professionalPhone', $professionalPhone);

        // Executa a query
        $query->execute();

        // Retorna a resposta para o AJAX
        echo json_encode(array('status' => 'success', 'message' => 'Appointment saved successfully!'));
    }

?>