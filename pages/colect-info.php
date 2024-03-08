<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    // Define o caminho do arquivo de banco de dados SQLite
    $database = new PDO('sqlite:/home/u685667027/domains/kwmartins.pt/public_html/visitantes.db');

    // Cria a tabela se ela não existir
    $database->exec("CREATE TABLE IF NOT EXISTS access (
        id INTEGER PRIMARY KEY,
        ip VARCHAR(100),
        navegador TEXT,
        sistema_operacional TEXT,
        idioma_navegador TEXT,
        resolucao_tela TEXT,
        tipo_dispositivo TEXT,
        data_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
        pagina_acessada TEXT,
        origem_visita TEXT,
        name_location TEXT,
        latitude TEXT,
        longitude TEXT,
        data_acesso TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
        e_recorrente INTEGER,  -- Usado INTEGER para representar booleano
        suporte_cookies INTEGER, -- Novo campo para suporte de cookies
        velocidade_conexao TEXT -- Novo campo para velocidade de conexão
    )");


    // Captura os dados do visitante
    $ipVisitante = $_SERVER['REMOTE_ADDR'];
    $navegador = $_SERVER['HTTP_USER_AGENT'];
    $sistemaOperacional = 'Desconhecido'; // Considere usar uma biblioteca para parsear o user agent
    $idiomaNavegador = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2); // Idioma preferido do navegador
    $dataHora = date('Y-m-d H:i:s');
    $paginaAcessada = $_SERVER['REQUEST_URI'];
    $origemVisita = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'Direta';

    // Informações de geolocalização
    $geoJson = file_get_contents("http://www.geoplugin.net/json.gp?ip=$ipVisitante");
    $geoArray = json_decode($geoJson, true);
    $location = $geoArray['geoplugin_countryName'] . ', ' . $geoArray['geoplugin_regionName'] . ', ' . $geoArray['geoplugin_city'];
    $latitude = $geoArray['geoplugin_latitude'];
    $longitude = $geoArray['geoplugin_longitude'];

    // Informações sobre a campanha
    $utmSource = isset($_GET['utm_source']) ? $_GET['utm_source'] : 'desconhecido';
    $utmMedium = isset($_GET['utm_medium']) ? $_GET['utm_medium'] : 'desconhecido';
    $utmCampaign = isset($_GET['utm_campaign']) ? $_GET['utm_campaign'] : 'desconhecido';
    if ($origemVisita === 'Direta') {
        $origemVisita = "Campanha: $utmSource, Meio: $utmMedium, Campanha: $utmCampaign";
    }

    // Você precisará adaptar este trecho para coletar e enviar a resolução de tela e o tipo de dispositivo do cliente via JavaScript
    $resolucaoTela = 'Desconhecido';
    $tipoDispositivo = 'Desconhecido';

    // Verifica se o visitante é recorrente
    $eRecorrente = false;
    $query = $database->prepare("SELECT * FROM access WHERE ip = :ip");
    $query->bindParam(':ip', $ipVisitante);
    $query->execute();
    $result = $query->fetchAll();
    if (count($result) > 0) {
        $eRecorrente = true;
    }

    // Inserir dados no banco
    $query = $database->prepare("INSERT INTO access (ip, navegador, sistema_operacional, idioma_navegador, resolucao_tela, tipo_dispositivo, data_hora, pagina_acessada, origem_visita, name_location, latitude, longitude, e_recorrente)
    VALUES (:ip, :navegador, :sistema_operacional, :idioma_navegador, :resolucao_tela, :tipo_dispositivo, :data_hora, :pagina_acessada, :origem_visita, :name_location, :latitude, :longitude, :e_recorrente)");

    $query->bindParam(':ip', $ipVisitante);
    $query->bindParam(':navegador', $navegador);
    $query->bindParam(':sistema_operacional', $sistemaOperacional);
    $query->bindParam(':idioma_navegador', $idiomaNavegador);
    //     Adicione bindParam para os novos campos aqui, por exemplo:
    $query->bindParam(':resolucao_tela', $resolucaoTela);
    $query->bindParam(':tipo_dispositivo', $tipoDispositivo);
    $query->bindParam(':data_hora', $dataHora);
    $query->bindParam(':pagina_acessada', $paginaAcessada);
    $query->bindParam(':origem_visita', $origemVisita);
    $query->bindParam(':name_location', $location);
    $query->bindParam(':latitude', $latitude);
    $query->bindParam(':longitude', $longitude);
    // Para e_recorrente, você precisaria definir uma lógica para verificar se o usuário já visitou antes
    $query->bindParam(':e_recorrente', $eRecorrente);

    $query->execute();
    $id = $database->lastInsertId();

?>