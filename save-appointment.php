<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        define('BASE_PATH', realpath(dirname(__FILE__)));
        require BASE_PATH . '/pages/db_connect.php';

        $name = $_POST['name'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $message = $_POST['message'] ?? '';
        $serviceId = $_POST['service_id'] ?? null;
        $date = $_POST['date'] ?? '';

        // Verificar se o cliente já existe
        $checkClient = $database->prepare("SELECT id FROM clients WHERE phone = :phone LIMIT 1");
        $checkClient->bindParam(':phone', $phone);
        $checkClient->execute();
        $existingClient = $checkClient->fetch(PDO::FETCH_ASSOC);

        if ($existingClient) {
            $client_id = $existingClient['id'];
        } else {
            // Inserir o novo cliente se ele não existir
            $queryClient = $database->prepare('INSERT INTO clients (name, phone, created_at) VALUES (:name, :phone, :created_at) RETURNING id');
            $queryClient->bindParam(':name', $name);
            $queryClient->bindParam(':phone', $phone);
            $queryClient->bindParam(':created_at', date('Y-m-d H:i:s'));
            $queryClient->execute();
            $client_id = $queryClient->fetchColumn();
        }

        // Inserir o agendamento
        $queryAppointment = $database->prepare('INSERT INTO appointments (notes, client_id, created_at) VALUES (:notes, :client_id, :created_at) RETURNING id');
        $queryAppointment->bindParam(':notes', $message);
        $queryAppointment->bindParam(':client_id', $client_id);
        $queryAppointment->bindParam(':created_at', date('Y-m-d H:i:s'));
        $queryAppointment->execute();
        $appointment_id = $queryAppointment->fetchColumn();

        // Inserir o serviço do agendamento
        $queryService = $database->prepare('INSERT INTO appointment_services (service_id, appointment_id, appointment_date, created_at) VALUES (:service_id, :appointment_id, :appointment_date, :created_at)');
        $queryService->bindParam(':service_id', $serviceId);
        $queryService->bindParam(':appointment_id', $appointment_id);
        $queryService->bindParam(':appointment_date', $date);
        $queryService->bindParam(':created_at', date('Y-m-d H:i:s'));
        $queryService->execute();

        echo json_encode(array('status' => 'success', 'message' => 'Appointment saved successfully!'));
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Invalid request method.'));
    }
?>
