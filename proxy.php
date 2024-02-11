<?php
// Configurações básicas
$destino = 'https://gnomo.esy.es'; // URL de destino, passada como parâmetro na query string

// Validação da URL de destino (adicione mais verificações conforme necessário)
if (filter_var($destino, FILTER_VALIDATE_URL) === false) {
    http_response_code(400); // Bad Request
    exit('URL de destino inválida.');
}

// Inicia a solicitação cURL
$ch = curl_init($destino);

// Configuração de opções cURL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);

// Adiciona cabeçalhos extras conforme necessário (exemplo: proxy de usuário)
// curl_setopt($ch, CURLOPT_HTTPHEADER, ['User-Agent: MeuProxyPHP']);

// Executa a solicitação cURL
$resposta = curl_exec($ch);

// Verifica se houve algum erro na solicitação cURL
if (curl_errno($ch)) {
    http_response_code(500); // Internal Server Error
    exit('Erro ao processar a solicitação.');
}

// Obtém informações sobre a solicitação cURL (cabeçalhos, código de status, etc.)
$info = curl_getinfo($ch);

// Define os cabeçalhos da resposta com base nos cabeçalhos recebidos do servidor de destino
foreach ($info['request_header'] as $header) {
    header($header);
}

// Define o código de status da resposta com base no código de status recebido do servidor de destino
http_response_code($info['http_code']);

// Exibe o conteúdo da resposta
echo $resposta;

// Fecha a sessão cURL
curl_close($ch);
?>
