<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    define('BASE_PATH', realpath(dirname(__FILE__)));
    require BASE_PATH . '/pages/db_connect.php';

    function normalizePhoneNumber($phone) {
        // Remove todos os caracteres não numéricos
        return preg_replace('/\D/', '', $phone);
    }

    $name = $_POST['name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $message = $_POST['message'] ?? '';
    $serviceId = $_POST['service_id'] ?? null;
    $date = $_POST['date'] ?? '';
    $currentDateTime = date('Y-m-d H:i:s');
    $status = 'pending';

    // Normalizar o número de telefone
    $normalizedPhone = normalizePhoneNumber($phone);

    try {
        // Iniciar transação
        $database->beginTransaction();

        // Verificar se o cliente já existe com o telefone normalizado
        $checkClient = $database->prepare("SELECT id FROM clients WHERE REPLACE(REPLACE(REPLACE(phone, ' ', ''), '(', ''), ')', '') = :phone LIMIT 1");
        $checkClient->bindParam(':phone', $normalizedPhone);
        $checkClient->execute();
        $existingClient = $checkClient->fetch(PDO::FETCH_ASSOC);

        if ($existingClient) {
            $client_id = $existingClient['id'];
        } else {
            // Inserir o novo cliente se ele não existir
            $queryClient = $database->prepare('INSERT INTO clients (name, phone, created_at) VALUES (:name, :phone, :created_at)');
            $queryClient->bindParam(':name', $name);
            $queryClient->bindParam(':phone', $phone); // Use the original phone here to store in the database
            $queryClient->bindParam(':created_at', $currentDateTime);
            $queryClient->execute();
            $client_id = $database->lastInsertId();
        }

        // Inserir o agendamento
        $queryAppointment = $database->prepare('INSERT INTO appointments (notes, client_id, status, created_at, appointment_date) VALUES (:notes, :client_id, :status, :created_at, :appointment_date)');
        $queryAppointment->bindParam(':notes', $message);
        $queryAppointment->bindParam(':client_id', $client_id);
        $queryAppointment->bindParam(':status', $status);
        $queryAppointment->bindParam(':created_at', $currentDateTime);
        $queryAppointment->bindParam(':appointment_date', $date);
        $queryAppointment->execute();
        $appointment_id = $database->lastInsertId();

        // Inserir o serviço do agendamento
        $queryService = $database->prepare('INSERT INTO appointment_services (service_id, appointment_id, created_at) VALUES (:service_id, :appointment_id, :created_at)');
        $queryService->bindParam(':service_id', $serviceId);
        $queryService->bindParam(':appointment_id', $appointment_id);
        $queryService->bindParam(':created_at', $currentDateTime);
        $queryService->execute();

        // Confirmar transação
        $database->commit();

        echo json_encode(array('status' => 'success', 'message' => 'Appointment saved successfully!'));
    } catch (Exception $e) {
        // Reverter transação em caso de erro
        $database->rollBack();
        echo json_encode(array('status' => 'error', 'message' => 'Failed to save appointment. ' . $e->getMessage()));
    }
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request method.'));
}
?>
