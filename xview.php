<?php

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    // Conecta ao banco de dados
    $database = new PDO('sqlite:/home/u685667027/domains/kwmartins.pt/public_html/visitantes.db');

    // Consulta para acessos únicos por usuário (exemplo, agrupando por IP) ultimas 24 horas
    $date24 = date('Y-m-d H:i:s', strtotime('-24 hours'));

    // Consulta para acessos únicos por usuário (exemplo, agrupando por IP)
    $acessosUnicosQuery = $database->query("SELECT ip, COUNT(ip) AS acessos FROM access GROUP BY ip");
    $acessosUnicos = $acessosUnicosQuery->fetchAll(PDO::FETCH_ASSOC);

    // Consulta para acessos totais por usuário (exemplo, agrupando por IP) ultimas 24 horas
    $acessosTotalQuery = $database->query("SELECT COUNT(ip) AS acessos FROM access WHERE data_hora > '$date24'");
    $acessosTotal = $acessosTotalQuery->fetchAll(PDO::FETCH_ASSOC);

    // Consulta para gerar dados para o mapa de calor
    $dadosMapaCalorQuery = $database->query("SELECT latitude AS lat, longitude AS lng FROM access");
    $dadosMapaCalor = $dadosMapaCalorQuery->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitantes</title>
    <!-- Inclua os estilos do Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <!-- Estilos adicionais -->
    <style>
        #map {
            height: 400px;
            width: 100%;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Lista de Visitantes</h1>

    <!-- Tabela simplificada -->

    <p>Total de visitantes únicos: <?php echo count($acessosUnicos); ?></p>
    <p>Total de visitantes: <?php echo $acessosTotal[0]['acessos']; ?></p>

    <div id="map"></div>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.heat/dist/leaflet-heat.js"></script>
    <script>
        var dadosMapaCalor = <?php echo json_encode($dadosMapaCalor); ?>;

        // Calcula o centro geométrico
        var latTotal = 0, lngTotal = 0, count = 0;
//         dadosMapaCalor.forEach(function(ponto) {
//             latTotal += parseFloat(ponto.lat);
//             lngTotal += parseFloat(ponto.lng);
//             count++;
//         });

        var centroLat = dadosMapaCalor[0].lat;
        var centroLng = dadosMapaCalor[0].lng;

//         centroLng = centroLng - 14.0;

        // Ajusta o zoom para um nível apropriado para visualização de cidade
        var zoomCidade = 13; // Este valor é um bom ponto de partida para áreas urbanas

        var map = L.map('map').setView([centroLat, centroLng], zoomCidade);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; Contribuidores do OpenStreetMap'
        }).addTo(map);

        var pontosMapaCalor = dadosMapaCalor.map(function(ponto) {
            return [ponto.lat, ponto.lng];
        });

        L.heatLayer(pontosMapaCalor, {radius: 25}).addTo(map);
    </script>
</body>
</html>
