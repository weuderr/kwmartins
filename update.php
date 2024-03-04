<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    // Verifica se a requisição é do tipo POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Define o caminho do arquivo de banco de dados SQLite
        $database = new PDO('sqlite:/home/u685667027/domains/kwmartins.pt/public_html/visitantes.db');

        // Prepara os dados recebidos do AJAX
        $id = $_POST['id'];
        $resolucao_tela = $_POST['resolucaoTela'];
        $tipo_dispositivo = $_POST['tipoDispositivo'];
        $idioma_navegador = $_POST['idiomaNavegador'];
        $suporte_cookies = $_POST['suporteCookies'] ? 1 : 0; // Convertendo para valor booleano armazenável
        $velocidade_conexao = $_POST['velocidadeConexao'];
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];

        // Atualiza a entrada no banco de dados com as novas informações
        $sql = "UPDATE access
                SET resolucao_tela = :resolucao_tela,
                    tipo_dispositivo = :tipo_dispositivo,
                    idioma_navegador = :idioma_navegador,
                    suporte_cookies = :suporte_cookies,
                    velocidade_conexao = :velocidade_conexao,
                    latitude = :latitude,
                    longitude = :longitude
                WHERE id = :id";

        $stmt = $database->prepare($sql);

        // Vincula os parâmetros
        $stmt->bindParam(':resolucao_tela', $resolucao_tela, PDO::PARAM_STR);
        $stmt->bindParam(':tipo_dispositivo', $tipo_dispositivo, PDO::PARAM_STR);
        $stmt->bindParam(':idioma_navegador', $idioma_navegador, PDO::PARAM_STR);
        $stmt->bindParam(':suporte_cookies', $suporte_cookies, PDO::PARAM_INT);
        $stmt->bindParam(':velocidade_conexao', $velocidade_conexao, PDO::PARAM_STR);
        $stmt->bindParam(':latitude', $latitude, PDO::PARAM_STR);
        $stmt->bindParam(':longitude', $longitude, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Executa a consulta
        $stmt->execute();

        // Fecha o cursor e a conexão
        $stmt->closeCursor();
        $stmt = null;
        $database = null;
    }

?>