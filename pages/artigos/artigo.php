
<div id="blog">
    <button id="menu-toggle" aria-label="Toggle menu">☰</button> <!-- Ícone do menu -->
    <div id="menu">
        <h3>Artigos</h3>
        <?php
            ini_set('display_errors', 1);
            error_reporting(E_ALL);

            define('BASE_PATH_PAGES', dirname(dirname(__FILE__)));
            require BASE_PATH_PAGES  . '/db_connect.php';

            $result = $database->query("SELECT * FROM articles");

            foreach ($result as $row) {
                echo "<a class='menu-link' href='?id=" . $row['id'] . "'>" . $row['name'] . "</a><br>";
            }
        ?>
    </div>
    <div id="article">
        <?php
            ini_set('display_errors', 1);
            error_reporting(E_ALL);

            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $stmt = $database->prepare("SELECT * FROM articles WHERE id = :id");
                $stmt->execute([':id' => $id]);
                $article = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($article) {
                    echo "<h2>" . $article['title'] . "</h2>";
                    echo $article['content'];
                } else {
                    echo "Artigo não encontrado.";
                }
            } else {
                echo "<div id='welcome'>Bem-vindo aos artigos da KW Martins. Escolha um artigo no menu à esquerda.</div>";
            }
        ?>
    </div>
</div>