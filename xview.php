<?php

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    // Conecta ao banco de dados
    $database = new PDO('sqlite:/home/u685667027/domains/kwmartins.pt/public_html/visitantes.db');

    // Consulta para acessos únicos por usuário (exemplo, agrupando por IP) ultimas 24 horas
    $date24 = date('Y-m-d H:i:s', strtotime('-24 hours'));

    // Consulta para acessos únicos por usuário (exemplo, agrupando por IP)
    $acessosUnicosQuery = $database->query("SELECT ip, pagina_acessada, COUNT(ip) AS acessos FROM access WHERE resolucao_tela IS NOT 'Desconhecido' GROUP BY ip");
    $acessosUnicos = $acessosUnicosQuery->fetchAll(PDO::FETCH_ASSOC);

    // Consulta para acessos totais por usuário (exemplo, agrupando por IP) ultimas 24 horas
    $acessosTotalQuery = $database->query("SELECT COUNT(ip) AS acessos FROM access WHERE data_hora > '$date24' AND resolucao_tela IS NOT 'Desconhecido'");
    $acessosTotal = $acessosTotalQuery->fetchAll(PDO::FETCH_ASSOC);

    // Consulta para gerar dados para o mapa de calor
    $dadosMapaCalorQuery = $database->query("SELECT latitude AS lat, longitude AS lng FROM access WHERE latitude IS NOT 'Desconhecido' AND longitude IS NOT 'Desconhecido' AND resolucao_tela IS NOT 'Desconhecido'");
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
    <div id="dataFrame" style="display: none;">
        <h1>Lista de Visitantes</h1>

        <!-- Tabela simplificada -->

        <p>Total de visitantes únicos: <?php echo count($acessosUnicos); ?></p>
        <p>Total de visitantes: <?php echo $acessosTotal[0]['acessos']; ?></p>

        <div id="map"></div>
        <div id="lista-visitantes">
            <h2>Lista de visitantes</h2>
            <table>
                <thead>
                    <tr>
                        <th>IP</th>
                        <th>Meio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($acessosUnicos as $acesso): ?>
                        <tr>
                            <td><?php echo $acesso['ip']; ?></td>
                            <td><?php echo $acesso['pagina_acessada']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.heat/dist/leaflet-heat.js"></script>
    <script>
//     show dialog with the message and input password to show information key 123
        function showPasswordDialog(message, callback) {
            var dialog = document.createElement('div');
            dialog.className = 'password-dialog';
            dialog.innerHTML = '<p>' + message + '</p><input type="password" id="password" /><button>OK</button>';
            document.body.appendChild(dialog);
            dialog.querySelector('button').addEventListener('click', function() {
                var password = dialog.querySelector('#password').value;
                if (password === '154263') {
                    document.body.removeChild(dialog);
                    callback(password);
                    initMap();
                } else {
                    alert('Senha incorreta');
                }
            });
        }
        showPasswordDialog('Digite a senha para ver a localização dos visitantes', function() {
            document.getElementById('dataFrame').style.display = 'block';
        });

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
