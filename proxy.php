<?php
// URL do servidor de destino
$targetUrl = 'http://seu_servidor_destino.com';

// Obtém a solicitação do cliente
$requestHeaders = getallheaders();
$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];
$requestBody = file_get_contents('php://input');

// Cria a solicitação para o servidor de destino
$context = stream_context_create([
    'http' => [
        'method' => $requestMethod,
        'header' => implode("\r\n", array_map(function ($key, $value) {
            return "$key: $value";
        }, array_keys($requestHeaders), $requestHeaders)),
        'content' => $requestBody,
    ],
]);

$targetResponse = file_get_contents("$targetUrl$requestUri", false, $context);

// Obtém informações sobre a resposta do servidor de destino
$targetResponseHeaders = $http_response_header;
$targetResponseBody = $targetResponse;

// Envia os cabeçalhos da resposta para o cliente
foreach ($targetResponseHeaders as $header) {
    header($header);
}

// Envia o corpo da resposta para o cliente
echo $targetResponseBody;
