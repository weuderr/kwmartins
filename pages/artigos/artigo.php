<div id="blog">
    <div id="menu">
        <h3>Artigos</h3>
        <?php
            require BASE_PATH  . '/pages/db_connect.php'; // Garante que a conexão com o banco de dados está estabelecida

            $result = $database->query("SELECT * FROM articles");
            foreach ($result as $row) {
                echo "<a href='?id=" . $row['id'] . "'>" . $row['name'] . "</a><br>";
            }
        ?>
    </div>
    <div id="article">
        <?php
            require BASE_PATH  . '/pages/db_connect.php'; // Garante que a conexão com o banco de dados está estabelecida
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