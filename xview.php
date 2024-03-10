<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    // Conecta ao banco de dados
    $database = new PDO('sqlite:/home/u685667027/domains/kwmartins.pt/public_html/visitantes.db');

    $database->exec("CREATE TABLE IF NOT EXISTS access ( id INTEGER PRIMARY KEY AUTOINCREMENT, ip TEXT, latitude TEXT, longitude TEXT, resolucao_tela TEXT, pagina_acessada TEXT, data_hora DATETIME )");

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

    //Select all last tree days of appoimentsSELECT name, phone, professionalPhone, date_time
    $lastAppointments = $database->query("SELECT name, phone, professionalPhone, date_time FROM appointments WHERE date(date_time) > date('now', '-3 day') ORDER BY date_time DESC");
    $lastAppointments = $lastAppointments->fetchAll(PDO::FETCH_ASSOC);
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
            <table class="table" style="padding: 10px;">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.min.js"></script>
    <script>
        var stringMd5 = "b798806fc4767d54dc4e061c79c67999";
        function setCookie(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays*24*60*60*1000));
            var expires = "expires="+ d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }

        function getCookie(cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');
            for(var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }

        function showPasswordDialog(message, callback) {
            var overlay = document.createElement('div');
            overlay.className = 'overlay';

            var dialog = document.createElement('div');
            dialog.className = 'dialog';

            dialog.innerHTML = '<div class="dialog-content"><p>' + message + '</p>' +
                '<input type="text" id="user" placeholder="Usuário" autofocus/>' +
                '<input type="password" id="password" placeholder="Senha"/>' +
                '<button id="submitBtn">OK</button>' +
            '</div>';

            overlay.appendChild(dialog);
            document.body.appendChild(overlay);

            // Define os manipuladores de eventos após adicionar o HTML ao documento
            var submitBtn = document.getElementById('submitBtn');
            var passwordInput = document.getElementById('password');
            var userInput = document.getElementById('user');

            // Manipulador para o botão
            submitBtn.addEventListener('click', checkPassword);

            // Permitir pressionar Enter para enviar
            passwordInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    checkPassword();
                }
            });
            userInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    checkPassword();
                }
            });

            function dangerDontChange(s) {
                var parts = ['b', '59'];
                var replacement = parts.join('');
                var target = String.fromCharCode(57, 57, 57);
                return s.replace(target, replacement);
            }

            function checkPassword() {
                var user = userInput.value;
                var password = passwordInput.value;
                var hash = CryptoJS.MD5(password).toString();
                if (user === 'admin' && hash === dangerDontChange(this.stringMd5)) {
                    document.body.removeChild(overlay);
                    callback();
                } else {
                    alert('Usuário ou senha incorretos');
                }
            }
        }


        function checkUserAuthentication() {
            var userAuthenticated = getCookie('userAuthenticated');
            if (userAuthenticated === 'true') {
                document.getElementById('dataFrame').style.display = 'block';
                initMap();
            } else {
                showPasswordDialog('Autenticação necessária', function() {
                    document.getElementById('dataFrame').style.display = 'block';
                    initMap();
                });
            }
        }

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
