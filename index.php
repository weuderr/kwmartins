<?php
// Define a constante BASE_PATH
define('BASE_PATH', realpath(dirname(__FILE__)));

$currentPage = basename($_SERVER['PHP_SELF']);
include('pages/colect-info.php');

$requestedUri = $_SERVER['REQUEST_URI'];

function loadPageContent($uri) {
    switch ($uri) {
        case '/quem-somos':
            include('pages/sections/quem-somos.php');
            break;
        case '/missao':
            include('pages/sections/missao.php');
            break;
        case '/servicos':
            include('pages/sections/servicos.php');
            break;
        case '/contato':
            include('pages/sections/contato.php');
            break;
        case '/galeria':
            include('pages/sections/galeria.php');
            break;
        case '/depoimentos':
            include('pages/sections/depoimentos.php');
            break;
        case '/faq':
            include('pages/sections/faq.php');
            break;
        case '/politica-de-privacidade':
            include('pages/sections/politica-de-privacidade.php');
            break;
        case '/termos-de-uso':
            include('pages/sections/termos-de-uso.php');
            break;
        default:
            include('pages/sections/servicos.php');
            break;
    }
}
?>
<?php include('pages/colect-info.php'); ?>
<!DOCTYPE html>
<html lang="pt">
<?php include('pages/head.php'); ?>
<body>
    <?php include('pages/navigator.php'); ?>
    <div class="header text-center mb-0">
        <img src="assets/img/BannerKW.png" alt="Banner principal da KW Martins destacando serviços de beleza" class="img-fluid">
    </div>

    <div class="container">

        <!-- Optimization: Added H1 tag for SEO -->
        <h1 class="visually-hidden">KW Martins - Sua Beleza, Nossa Paixão</h1>

        <div class="conteudo mt-5" >
            <?php
                loadPageContent($requestedUri);
            ?>
        </div>
    </div>

    <?php include('pages/footer.php'); ?>
    <?php include('pages/modalAppointment.php'); ?>

    <div id="gdpr-consent-container" class="gdpr-consent-container">
        <div class="gdpr-consent-content">
            <p>Este site usa cookies para garantir que você obtenha a melhor experiência em nosso site. <a href="/politica-de-privacidade">Saiba mais</a></p>
            <button id="accept-gdpr">Aceitar</button>
        </div>
    </div>
    <div id="hiddenData" data-id="<?php echo $id; ?>"></div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/js/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="/assets/js/default.js"></script>
    <script src="/assets/js/update-infos.js"></script>
    <script>
        document.getElementById('accept-gdpr').addEventListener('click', function() {
            localStorage.setItem('gdpr-consent', 'true');
            document.getElementById('gdpr-consent-container').style.display = 'none';
        });

        if (localStorage.getItem('gdpr-consent') === 'true') {
            document.getElementById('gdpr-consent-container').style.display = 'none';
        }
    </script>
</body>
</html>