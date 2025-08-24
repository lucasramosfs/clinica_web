<?php
// Configurações do banco de dados
$host = 'sql108.infinityfree.com';
$dbname = 'if0_39664915_PPIDB';
$username = 'if0_39664915';
$password = 'wiB7wYJTX80pH6n';

try {
    // Criação da conexão PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    
    // Configuração de atributos PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}

// Função para sanitizar dados de entrada (prevenção XSS)
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// // Função para verificar se o usuário está logado
// function verificar_login() {
//     session_start();
//     if (!isset($_SESSION['funcionario_id'])) {
//         http_response_code(401);
//         echo json_encode(['error' => 'Acesso negado. Faça login primeiro.']);
//         exit;
//     }
// }

// Configuração de CORS e JSON apenas para endpoints de API
if (strpos($_SERVER['SCRIPT_NAME'], '/api/') !== false) {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    header('Content-Type: application/json; charset=utf-8');

    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit;
    }
}
// Responder a requisições OPTIONS (preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}
?>


