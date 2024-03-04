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

<!DOCTYPE html>
<html lang="pt">
<?php include('pages/head.php'); ?>
<body>
    <?php include('pages/navigator.php'); ?>

    <div class="header text-center mb-0">
        <img src="assets/img/BannerKW.png" alt="Banner principal da KW Martins destacando serviços de beleza" class="img-fluid">
    </div>

    <!-- Optimization: Added H1 tag for SEO -->
    <h1 class="visually-hidden">KW Martins - Sua Beleza, Nossa Paixão</h1>

    <div class="container my-5">
        <!-- Quem Somos -->
        <div class="container" id="quem-somos">
            <div class="m-2">
                <h5 >Quem Somos</h5>
                <div>
                    <p>Na KW Martins, empoderamos mulheres proporcionando-lhes maior autoestima através da beleza e do cuidado pessoal. Com uma equipe de especialistas altamente qualificados, utilizamos as mais recentes tecnologias e técnicas estéticas para garantir resultados excepcionais. Nosso espaço foi cuidadosamente projetado para oferecer conforto, privacidade e a melhor experiência possível aos nossos clientes.</p>
                </div>
            </div>
        </div>

        <!-- Missao -->
        <div class="container" id="missao">
            <div class="col-md-12">
                <h5 class="mb-4">Missão, Visão e Valores</h5>

                <div class="row d-flex align-items-stretch">
                    <div class="col-md-4 ">
                        <div class="card mb-4 shadow-sm card-custom">
                            <div class="card-header">
                                <strong>Confiança</strong>
                            </div>
                            <div class="card-body">
                                <p>Segurança e confiabilidade em todos os aspectos.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 ">
                        <div class="card mb-4 shadow-sm card-custom">
                            <div class="card-header">
                                <strong>Qualidade</strong>
                            </div>
                            <div class="card-body">
                                <p>Excelência em produtos e serviços.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 ">
                        <div class="card mb-4 shadow-sm card-custom">
                            <div class="card-header">
                                <strong>Inovação</strong>
                            </div>
                            <div class="card-body">
                                <p>Avanço contínuo para atender as expectativas.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 ">
                        <div class="card mb-4 shadow-sm card-custom">
                            <div class="card-header">
                                <strong>Respeito</strong>
                            </div>
                            <div class="card-body">
                                <p>Valorização e consideração por todos.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 ">
                        <div class="card mb-4 shadow-sm card-custom">
                            <div class="card-header">
                                <strong>Empatia</strong>
                            </div>
                            <div class="card-body">
                                <p>Entendimento profundo das necessidades dos clientes.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Serviços -->
        <div class="container" id="servicos">
            <div class="col-md-12">
                <h5 class="mb-4">Serviços</h5>
                <div class="filter-container mb-4">
                    <label for="serviceTypeFilter">Filtrar por Tipo:</label>
                    <select id="serviceTypeFilter" class="form-control">
                        <option value="all">Todos</option>
                        <!-- Opções serão adicionadas dinamicamente -->
                    </select>
                </div>
                <div class="row d-flex align-items-stretch" id="servicosContainer">
                    <!-- Cards de serviços serão adicionados dinamicamente -->
                </div> <!-- Container para os cards de serviços -->
            </div>
        </div>

        <!-- Galeria -->
        <div class="row" id="galeria">
            <div class="col-md-12">
                <h5 class="mb-4">Galeria</h5>
                <div class="row">
                    <div class="col-md-4 gallery-img frame-image"><img src="assets/img/galeria/kw-espaco%20(1).jpg" alt="Imagem 1 do espaço da KW Martins"></div>
                    <div class="col-md-4 gallery-img frame-image"><img src="assets/img/galeria/kw-espaco%20(2).jpg" alt="Imagem 2 do espaço da KW Martins"></div>
                    <div class="col-md-4 gallery-img frame-image"><img src="assets/img/galeria/kw-espaco%20(3).jpg" alt="Imagem 3 do espaço da KW Martins"></div>
                    <div class="col-md-4 gallery-img frame-image"><img src="assets/img/galeria/kw-espaco%20(4).jpg" alt="Imagem 4 do espaço da KW Martins"></div>
                    <div class="col-md-4 gallery-img frame-image"><img src="assets/img/galeria/kw-espaco%20(5).jpg" alt="Imagem 5 do espaço da KW Martins"></div>
                    <div class="col-md-4 gallery-img frame-image"><img src="assets/img/galeria/kw-espaco%20(6).jpg" alt="Imagem 6 do espaço da KW Martins"></div>
                    <div class="col-md-4 gallery-img frame-image"><img src="assets/img/galeria/kw-espaco%20(7).jpg" alt="Imagem 7 do espaço da KW Martins"></div>
                    <div class="col-md-4 gallery-img frame-image"><img src="assets/img/galeria/kw-espaco%20(8).jpg" alt="Imagem 8 do espaço da KW Martins"></div>
                </div>
            </div>
        </div>

        <!-- Depoimentos -->
        <div class="row" id="depoimentos">
            <div class="col-md-12">
                <h5 class="mb-4">Depoimentos</h5>
                <div class="testimonial">
                    <p>Nesta seção, você encontrará depoimentos de clientes satisfeitos com nossos serviços. A satisfação de nossos clientes é a nossa maior recompensa.</p>
                </div>
                <div class="testimonial">
                    <div class="col-md-4 gallery-img frame-depoimento"><img src="assets/img/depoimentos/kw-depoimento%20(1).jpg" alt="Depoimento 1 do cliente"></div>
                    <div class="col-md-4 gallery-img frame-depoimento"><img src="assets/img/depoimentos/kw-depoimento%20(2).jpg" alt="Depoimento 2 do cliente"></div>
                    <div class="col-md-4 gallery-img frame-depoimento"><img src="assets/img/depoimentos/kw-depoimento%20(3).jpg" alt="Depoimento 3 do cliente"></div>
                    <div class="col-md-4 gallery-img frame-depoimento"><img src="assets/img/depoimentos/kw-depoimento%20(4).jpg" alt="Depoimento 4 do cliente"></div>
                    <div class="col-md-4 gallery-img frame-depoimento"><img src="assets/img/depoimentos/kw-depoimento%20(5).jpg" alt="Depoimento 5 do cliente"></div>
                    <div class="col-md-4 gallery-img frame-depoimento"><img src="assets/img/depoimentos/kw-depoimento%20(6).jpg" alt="Depoimento 6 do cliente"></div>
                    <div class="col-md-4 gallery-img frame-depoimento"><img src="assets/img/depoimentos/kw-depoimento%20(7).jpg" alt="Depoimento 7 do cliente"></div>
                    <div class="col-md-4 gallery-img frame-depoimento"><img src="assets/img/depoimentos/kw-depoimento%20(8).jpg" alt="Depoimento 8 do cliente"></div>
                    <div class="col-md-4 gallery-img frame-depoimento"><img src="assets/img/depoimentos/kw-depoimento%20(9).jpg" alt="Depoimento 9 do cliente"></div>
                </div>
            </div>
        </div>

        <!-- FAQ -->
        <div class="row" id="faq">
            <div class="col-md-12">
                <h5 class="mb-4">FAQ - Perguntas Frequentes</h5>
                <div class="faq">
                    <p class="faq-question">Quais serviços vocês oferecem?</p>
                    <p>Oferecemos uma variedade de serviços estéticos, incluindo tratamentos faciais e corporais, depilação a laser, massagens terapêuticas, entre outros. Cada tratamento é personalizado para atender às necessidades específicas de nossos clientes.</p>
                </div>
                <div class="faq">
                    <p class="faq-question">Como posso agendar uma consulta?</p>
                    <p>Agendar uma consulta é fácil! Você pode nos contatar através do nosso site, por telefone ou visitar nosso espaço. Nossa equipe terá o prazer de ajudá-lo a encontrar o horário que melhor se adapta à sua agenda.</p>
                </div>
            </div>
        </div>

        <!-- Contato -->
        <div class="row" id="contato">
            <div class="col-md-12">
                <div class="card mb-4 shadow-sm card-custom">
                    <h5 class="card-header">Contato</h5>
                    <div class="card-body">
                        <p class="card-text">Estamos ansiosos para ajudá-la a realçar sua beleza. Entre em contato conosco hoje mesmo para descobrir como podemos atender às suas necessidades de estética e bem-estar.</p>
                        <p class="card-text">Endereço: R. António Carneiro 147, 4450-047 Matosinhos</p>
                        <p class="card-text">Telefone: 961 021 247</p>
                        <p class="card-text">Localização
                            <a href="https://www.google.com/maps/search/?api=1&query=41.178083,-8.675401" target="_blank">
                            <img src="assets/img/localizacao.png" alt="Google Maps - kw martins" style="width: 100%; height: 100%"/>
                        </a></p>
                    </div>
                        <p>Entre em contato conosco através do WhatsApp para agendar uma consulta ou tirar dúvidas.</p>
                        <a href="https://api.whatsapp.com/send?phone=351966296791&text=Gostaria%20de%20de%20uma%20tirar%20d%C3%BAvida"class="btn btn-custom" target="_blank">Contato via WhatsApp</a>
                    </div>
                </div>
            </div>
        </div>


    <div class="footer text-center py-3" style="position: fixed; bottom: 0; width: 100%;">
        &copy; 2024 KW Martins. Todos os direitos reservados.
    </div>
    <div id="hiddenData" data-id="<?php echo $id; ?>"></div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/js/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="assets/js/default.js"></script>
    <script>
        $(document).ready(function() {
            var resolucaoTela = window.innerWidth + 'x' + window.innerHeight;
            var tipoDispositivo = 'Desktop'; // Padrão para desktop
            if (window.innerWidth <= 768) {
                tipoDispositivo = 'Mobile';
            } else if (window.innerWidth <= 1024) {
                tipoDispositivo = 'Tablet';
            }
            var idiomaNavegador = navigator.language || navigator.userLanguage;
            var suporteCookies = navigator.cookieEnabled;
            var velocidadeConexao = navigator.connection ? navigator.connection.downlink + 'Mbps' : 'Desconhecido';

            // Tentativa de obter a localização geográfica do usuário
            var latitude = 'Desconhecido';
            var longitude = 'Desconhecido';

            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    latitude = position.coords.latitude;
                    longitude = position.coords.longitude;

                    // Atualiza as informações no banco de dados, incluindo a localização
                    console.error("Geolocalização obtida: ", latitude, longitude);
                    atualizarInformacoes(latitude, longitude);
                }, function(error) {
                    console.error("Erro ao obter localização geográfica: ", error);

                    // Atualiza as informações no banco de dados mesmo sem a localização
                    atualizarInformacoes(latitude, longitude);
                });
            } else {
                console.log("Geolocalização não é suportada neste navegador.");

                // Atualiza as informações no banco de dados mesmo sem a localização
                atualizarInformacoes(latitude, longitude);
            }

            function atualizarInformacoes(lat, lng) {
                var id = $('#hiddenData').data('id');
                console.log(resolucaoTela, tipoDispositivo, idiomaNavegador, suporteCookies, velocidadeConexao, lat, lng, id);
                $.ajax({
                    url: 'update.php',
                    method: 'POST',
                    data: {
                        id: id,
                        resolucaoTela: resolucaoTela,
                        tipoDispositivo: tipoDispositivo,
                        idiomaNavegador: idiomaNavegador,
                        suporteCookies: suporteCookies,
                        velocidadeConexao: velocidadeConexao,
                        latitude: lat,
                        longitude: lng
                    }
                });
            }
        });
    </script>
</body>
</html>
