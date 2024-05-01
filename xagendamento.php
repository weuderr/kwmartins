<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    session_start();
    define('BASE_PATH', realpath(dirname(__FILE__)));
    require BASE_PATH . '/pages/db_connect.php';

    // Verifica se o formulário foi enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $funcionario = $_POST['funcionario'];
        $cliente = $_POST['cliente'];
        $procedimento = $_POST['procedimento'];
        $horario = $_POST['horario'];

        // Inserir novo agendamento no banco de dados
        $insertQuery = $database->prepare("INSERT INTO appointments (employee, client, procedure, appointment_time) VALUES (?, ?, ?, ?)");
        $insertQuery->execute([$funcionario, $cliente, $procedimento, $horario]);
    }

    // Buscar horários já marcados
    $appointmentsQuery = $database->prepare("SELECT appointment_time FROM appointments WHERE employee = ?");
    $appointmentsQuery->execute([$funcionario]);
    $bookedTimes = $appointmentsQuery->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Agendar Serviço</title>
    <link rel="stylesheet" href="https://kwmartins.pt/assets/css/default.css">
    <style>
        input, select {
            width: 200px;
            margin: 10px 0;
            padding: 8px;
        }
        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Agendar Novo Serviço</h1>
    <form method="post">
        <label for="funcionario">Funcionário:</label>
        <select id="funcionario" name="funcionario" required>
            <!-- Insira aqui as opções de funcionários -->
        </select>
        <label for="cliente">Cliente:</label>
        <input type="text" id="cliente" name="cliente" required>
        <label for="procedimento">Procedimento:</label>
        <select id="procedimento" name="procedimento" required>
            <!-- Insira aqui as opções de procedimentos -->
        </select>
        <label for="horario">Horário:</label>
        <select id="horario" name="horario" required>
            <!-- Gerar opções de horários excluindo horários já marcados -->
            <?php
                $startTime = strtotime("08:00");
                $endTime = strtotime("18:00");
                $current = $startTime;
                while ($current <= $endTime) {
                    $timeSlot = date('H:i', $current);
                    if (!in_array(['appointment_time' => $timeSlot], $bookedTimes)) {
                        echo "<option value='$timeSlot'>$timeSlot</option>";
                    }
                    $current = strtotime('+15 minutes', $current);
                }
            ?>
        </select>
        <button type="submit">Agendar</button>
    </form>
</body>
</html>
