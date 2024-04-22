<?php
require __DIR__ . '/vendor/autoload.php';

// Carrega as variáveis de ambiente
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Configurações de conexão com o banco de dados MySQL
$host = $_ENV['DB_HOST'];
$dbname = $_ENV['DB_NAME'];
$user = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];

try {
    // Conexão com o banco de dados MySQL
    $database = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    // Configura o PDO para lançar exceções em caso de erro
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // Em caso de erro na conexão, a execução é encerrada e a mensagem de erro é mostrada
    die("Connection error: " . $e->getMessage());
}
?>