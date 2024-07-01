<?php
session_start();

include('pages/colect-info.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
    if ($_POST['password'] === '123456kw') {
        $_SESSION['authenticated'] = true;
        $_SESSION['auth_time'] = time();
    } else {
        echo "<script>alert('Senha incorreta!');</script>";
    }
}

// Verifica se a sessão está autenticada e se não expirou
if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
    $currentTime = time();
    $sessionDuration = 6 * 60 * 60; // 6 horas em segundos

    if ($currentTime - $_SESSION['auth_time'] > $sessionDuration) {
        // Sessão expirada
        session_unset();
        session_destroy();
    } else {
        $showManagement = true;
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<?php include('../../head.php'); ?>
<body>
    <?php include('../../navigator.php'); ?>

    <?php if (isset($showManagement) && $showManagement): ?>
        <?php include('management.php'); ?>
    <?php else: ?>
        <div style="text-align:center; margin-top: 50px;">
            <form method="post">
                <label for="password">Insira a senha para acessar a gestão:</label><br>
                <input type="password" id="password" name="password" required>
                <button type="submit">Entrar</button>
            </form>
        </div>
    <?php endif; ?>

    <?php include('../../footer.php'); ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/js/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.getElementById('menu-toggle').addEventListener('click', function() {
            var menu = document.getElementById('menu');
            if (menu.classList.contains('open')) {
                menu.classList.remove('open'); // Fecha o menu
            } else {
                menu.classList.add('open'); // Abre o menu
            }
        });
    </script>
</body>
</html>
