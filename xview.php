<?php

    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    session_start();
    define('BASE_PATH', realpath(dirname(__FILE__)));
    require BASE_PATH . '/pages/db_connect.php';

//     $database->exec("CREATE TABLE IF NOT EXISTS access ( id INTEGER PRIMARY KEY AUTOINCREMENT, ip TEXT, latitude TEXT, longitude TEXT, resolucao_tela TEXT, pagina_acessada TEXT, data_hora DATETIME )");

    // Conecta ao banco de dados
    // O código de conexão está agora no arquivo db_connect.php

    // Define o formato de data compatível com MySQL
    $date24 = date('Y-m-d H:i:s', strtotime('-24 hours'));

    // Consulta para acessos únicos por usuário (exemplo, agrupando por IP) que não são 'Desconhecido'
    /** @var TYPE_NAME $database */
    $acessosUnicosQuery = $database->prepare("SELECT ip, pagina_acessada, data_acesso, COUNT(ip) AS acessos FROM access WHERE resolucao_tela <> 'Desconhecido' GROUP BY ip");
    $acessosUnicosQuery->execute();
    $acessosUnicos = $acessosUnicosQuery->fetchAll(PDO::FETCH_ASSOC);

    // Consulta para acessos totais por usuário (exemplo, agrupando por IP) nas últimas 24 horas
    $acessosTotalQuery = $database->prepare("SELECT COUNT(ip) AS acessos FROM access WHERE data_hora > ? AND resolucao_tela <> 'Desconhecido'");
    $acessosTotalQuery->execute([$date24]);
    $acessosTotal = $acessosTotalQuery->fetchAll(PDO::FETCH_ASSOC);

    // Consulta para gerar dados para o mapa de calor
    $dadosMapaCalorQuery = $database->prepare("SELECT latitude AS lat, longitude AS lng FROM access WHERE latitude <> 'Desconhecido' AND longitude <> 'Desconhecido' AND resolucao_tela <> 'Desconhecido'");
    $dadosMapaCalorQuery->execute();
    $dadosMapaCalor = $dadosMapaCalorQuery->fetchAll(PDO::FETCH_ASSOC);

    // Consulta para selecionar os últimos três dias de agendamentos
    $lastAppointmentsQuery = $database->prepare("SELECT name, phone, professionalPhone, date_time FROM appointments WHERE date_time > DATE_SUB(NOW(), INTERVAL 30 DAY) ORDER BY date_time DESC");
    $lastAppointmentsQuery->execute();
    $lastAppointments = $lastAppointmentsQuery->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitantes</title>
    <!-- Inclua os estilos do Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://kwmartins.pt/assets/css/default.css">
    <!-- Estilos adicionais -->
    <style>
        #map {
            height: 400px;
            width: 100%;
            margin-top: 20px;
        }
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .dialog {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .user-dialog {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .dialog .dialog-content {
            display: flex;
            flex-direction: column;
        }

        .dialog p {
            margin-top: 0;
        }

        .dialog input[type="password"] {
            margin: 10px 0;
            padding: 10px;
        }

        .dialog input[type="text"] {
            margin: 10px 0;
            padding: 10px;
        }

        .dialog button {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .dialog button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body onload="checkUserAuthentication()">
    <div id="dataFrame" style="display: none;">
        <h1>Lista de Visitantes</h1>

        <!-- Tabela simplificada -->

        <p>Total de visitantes únicos: <?php echo count($acessosUnicos); ?></p>
        <p>Total de visitantes: <?php echo $acessosTotal[0]['acessos']; ?></p>

        <h2>Últimos 3 dias de marcações</h2>
        <table class="table" id="appointments" style="padding: 10px;">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>Profissional</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lastAppointments as $appointment): ?>
                    <tr>
                        <td><?php echo $appointment['name']; ?></td>
                        <td><?php echo $appointment['phone']; ?></td>
                        <td><?php echo $appointment['professionalPhone']; ?></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($appointment['date_time'])); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div id="map"></div>
        <div id="lista-visitantes">
            <h2>Lista de visitantes</h2>
            <table class="table" style="padding: 10px; width: 100%">
                <thead>
                    <tr>
                        <th style="width: 150px">IP</th>
                        <th style="width: 150px">Data</th>
                        <th>Meio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($acessosUnicos as $acesso): ?>
                        <tr>
                            <td><?php echo $acesso['ip']; ?></td>
                            <td><?php echo $acesso['data_acesso']; ?></td>
                            <td><?php echo $acesso['pagina_acessada'].substr(0, 50); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.heat/dist/leaflet-heat.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.min.js"></script>
    <script src="assets/js/auth.js"></script>
    <script>
        function initMap() {
            var dadosMapaCalor = <?php echo json_encode($dadosMapaCalor); ?>;

            var centroLat = dadosMapaCalor[0].lat;
            var centroLng = dadosMapaCalor[0].lng;

            var zoomCidade = 10;

            var map = L.map('map').setView([centroLat, centroLng], zoomCidade);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; Contribuidores do OpenStreetMap'
            }).addTo(map);

            var pontosMapaCalor = dadosMapaCalor.map(function(ponto) {
                return [ponto.lat, ponto.lng];
            });

            L.heatLayer(pontosMapaCalor, {radius: 25}).addTo(map);
        }
    </script>
</body>
</html>
