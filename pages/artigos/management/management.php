<?php
session_start();

include('pages/colect-info.php');
?>

<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artigos - KW Martins</title>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <style>
        #blog {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        #menu {
            width: 80%;
            background-color: #f4f4f4;
            padding: 10px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        form input, form textarea {
            margin-bottom: 10px;
            padding: 5px;
        }
        #editor-container {
            height: 400px;
            margin-bottom: 10px;
            height: 98%;
            min-height: 300px;
        }
        /* Estilo para a modal maior */
        .modal-xl {
            max-width: 90%;
            width: 90%;
        }
        .modal-body {
            max-height: calc(100vh - 200px);
            overflow-y: auto;
        }
    </style>
</head>
<body>

<div id="blog">
    <button id="menu-toggle" aria-label="Toggle menu" class="btn btn-primary">☰</button> <!-- Ícone do menu -->
    <div id="menu">
        <h3>Artigos</h3>
        <button class="btn btn-success" data-toggle="modal" data-target="#articleModal">Novo Artigo</button>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Título</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    ini_set('display_errors', 1);
                    error_reporting(E_ALL);

                    define('BASE_PATH_ARTICLES', dirname(dirname(dirname(__FILE__))));
                    require BASE_PATH_ARTICLES  . '/db_connect.php';

                    $result = $database->query("SELECT * FROM articles");

                    foreach ($result as $row) {
                        echo "<tr>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['title'] . "</td>";
                        echo "<td class='actions'>";
                        echo "<button class='btn btn-warning' data-toggle='modal' data-target='#articleModal' data-id='" . $row['id'] . "' data-name='" . $row['name'] . "' data-title='" . $row['title'] . "' data-content='" . htmlspecialchars($row['content']) . "'>Editar</button>";
                        echo "<a class='btn btn-danger' href='?action=delete&id=" . $row['id'] . "' onclick='return confirm(\"Tem certeza que deseja deletar este artigo?\");'>Deletar</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
    <div class="container" id="article" style="width: 90%">
        <?php
            ini_set('display_errors', 1);
            error_reporting(E_ALL);

            if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
                $id = $_GET['id'];
                $stmt = $database->prepare("DELETE FROM articles WHERE id = :id");
                $stmt->execute([':id' => $id]);
                echo "Artigo deletado com sucesso.";
            } else {
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
                    echo "<div id='welcome'>Bem-vindo aos artigos da KW Martins. Escolha um artigo na tabela acima ou crie um novo artigo.</div>";
                }
            }
        ?>
    </div>
</div>

<!-- Modal para formulário de artigo -->
<div class="modal fade" id="articleModal" tabindex="-1" role="dialog" aria-labelledby="articleModalLabel" aria-hidden="true" style="z-index: 99999">
    <div class="modal-dialog modal-xl" role="document"> <!-- Alteração aqui -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="articleModalLabel">Artigo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="save_article.php" method="post" onsubmit="submitForm()">
                    <input type="hidden" name="id" id="article-id">
                    <label for="name">Nome:</label>
                    <input type="text" name="name" id="article-name" required>
                    <label for="title">Título:</label>
                    <input type="text" name="title" id="article-title" required>
                    <label for="content">Conteúdo:</label>
                    <div id="editor-container"></div>
                    <input type="hidden" name="content" id="content-hidden">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('../../footer.php'); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/js/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    document.getElementById('menu-toggle').addEventListener('click', function() {
        var menu = document.getElementById('menu');
        if (menu.style.display === 'block') {
            menu.style.display = 'none';
        } else {
            menu.style.display = 'block';
        }
    });

    var quill;
    $(document).ready(function() {
        var toolbarOptions = [
            ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
            ['blockquote', 'code-block'],

            [{ 'header': 1 }, { 'header': 2 }],               // custom button values
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
            [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
            [{ 'direction': 'rtl' }],                         // text direction

            [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

            [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
            [{ 'font': [] }],
            [{ 'align': [] }],

            ['clean'],                                         // remove formatting button

            ['link', 'image', 'video']                        // link and image, video
        ];

        quill = new Quill('#editor-container', {
            theme: 'snow',
            modules: {
                toolbar: {
                    container: toolbarOptions,
                    handlers: {
                        image: function() {
                            selectLocalImage();
                        }
                    }
                }
            }
        });

        function selectLocalImage() {
            const input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.click();

            input.onchange = () => {
                const file = input.files[0];
                if (/^image\//.test(file.type)) {
                    saveToServer(file);
                } else {
                    console.warn('Você deve selecionar um arquivo de imagem.');
                }
            };
        }

        function saveToServer(file) {
            const fd = new FormData();
            fd.append('image', file);

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'upload_image.php', true);
            xhr.onload = () => {
                if (xhr.status === 200) {
                    const url = JSON.parse(xhr.responseText).url;
                    insertToEditor(url);
                }
            };
            xhr.send(fd);
        }

        function insertToEditor(url) {
            const range = quill.getSelection();
            quill.insertEmbed(range.index, 'image', url);
        }

        $('#articleModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id') || '';
            var name = button.data('name') || '';
            var title = button.data('title') || '';
            var content = button.data('content') || '';

            var modal = $(this);
            modal.find('#article-id').val(id);
            modal.find('#article-name').val(name);
            modal.find('#article-title').val(title);
            quill.clipboard.dangerouslyPasteHTML(content);
        });

        $('#articleModal').on('hidden.bs.modal', function () {
            quill.root.innerHTML = '';
        });
    });

    function submitForm() {
        var content = document.querySelector('#editor-container .ql-editor').innerHTML;
        document.querySelector('#content-hidden').value = content;
    }
</script>
</body>
</html>
