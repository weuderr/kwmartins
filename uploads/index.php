<?php
// Verifica se um arquivo foi solicitado via query string
if (isset($_GET['file'])) {
    $filename = basename($_GET['file']);
    $filepath = __DIR__ . '/' . $filename;

    // Verifica se o arquivo existe
    if (file_exists($filepath)) {
        // Define os headers apropriados para o tipo de arquivo
        $fileinfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($fileinfo, $filepath);
        finfo_close($fileinfo);

        header('Content-Type: ' . $mime_type);
        header('Content-Length: ' . filesize($filepath));

        // Lê o arquivo e envia seu conteúdo ao navegador
        readfile($filepath);
        exit;
    } else {
        http_response_code(404);
        echo 'Arquivo não encontrado.';
        exit;
    }
} else {
    http_response_code(400);
    echo 'Nenhum arquivo especificado.';
    exit;
}
