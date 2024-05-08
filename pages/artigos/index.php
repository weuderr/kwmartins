<?php include('pages/colect-info.php'); ?>

<!DOCTYPE html>
<html lang="pt">
<?php include('../head.php'); ?>
<body>
    <?php include('../navigator.php'); ?>
    <?php include('artigo.php'); ?>
    <?php include('../footer.php'); ?>

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
