<?php
// Definição de autoloader (exemplo usando Composer)
require 'vendor/autoload.php';

define('BASE_PATH', realpath(dirname(__FILE__)));
$currentPage = basename($_SERVER['PHP_SELF']);
$requestedUri = explode('?', $_SERVER['REQUEST_URI'])[0];

function loadPageContent($uri) {
    $pages = [
        '/home' => 'home.php',
        '/quem-somos' => 'quem-somos.php',
        '/missao' => 'missao.php',
        '/servicos' => 'servicos.php',
        '/contato' => 'contato.php',
        '/galeria' => 'galeria.php',
        '/localizacao' => 'contato.php', // Notar que 'localizacao' e 'contato' usam o mesmo arquivo
        '/faq' => 'faq.php',
        '/politica-de-privacidade' => 'politica-de-privacidade.php',
        '/termos-de-uso' => 'termos-de-uso.php',
        '/parceria' => 'parcerias.php'
    ];

    $page = $pages[$uri] ?? 'home.php';
    include('pages/sections/' . $page);
}

include('pages/colect-info.php');
?>
<!DOCTYPE html>
<html lang="pt">
<?php include('pages/head.php'); ?>
<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MV8PF47M"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <div id="main-content" style="display: none;">
        <?php include('pages/navigator.php'); ?>
        <div class="header text-center mb-0">
            <img src="assets/img/BannerKWFull.png" alt="Banner principal da KW Martins destacando serviços de beleza" class="img-fluid img-banner">
        </div>

        <div class="container">
            <h1 class="visually-hidden">KW Martins - Sua Beleza, Nossa Paixão</h1>
            <div class="conteudo mt-5">
                <?php loadPageContent($requestedUri); ?>
            </div>
        </div>

        <?php include('pages/footer.php'); ?>

        <div id="gdpr-consent-container" class="gdpr-consent-container">
            <div class="gdpr-consent-content p-2">
                <p>Este site usa cookies para garantir que você obtenha a melhor experiência em nosso site. <a href="/politica-de-privacidade">Saiba mais</a></p>
                <button id="accept-gdpr">Aceitar</button>
            </div>
        </div>

        <div id="hiddenData" data-id="<?php echo $id; ?>"></div>
    </div>
    <div id="loading-icon" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width=100px">
        <img id="spinner-splash" src="assets/img/icon-logo.png" alt="Carregando..." class="img-fluid">
    </div>

    <script src="/assets/js/start.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/js/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="/assets/js/default.js"></script>
    <script src="/assets/js/update-infos.js"></script>
</body>
</html>