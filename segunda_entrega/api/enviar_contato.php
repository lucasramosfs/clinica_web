<?php
require_once '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Receber dados do formulário
    $nome = sanitize_input($_POST['nome'] ?? '');
    $email = sanitize_input($_POST['email'] ?? '');
    $telefone = sanitize_input($_POST['telefone'] ?? '');
    $mensagem = sanitize_input($_POST['mensagem'] ?? '');
    
    // Validar dados de entrada
    if (empty($nome) || empty($email) || empty($telefone) || empty($mensagem)) {
        http_response_code(400);
        echo json_encode(['error' => 'Todos os campos são obrigatórios.']);
        exit;
    }
    
    // Validar formato de email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(['error' => 'Email inválido.']);
        exit;
    }
    
    try {
        // Inserir mensagem de contato
        $stmt = $pdo->prepare("INSERT INTO Contato (Nome, Email, Telefone, Mensagem) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nome, $email, $telefone, $mensagem]);
        
        echo json_encode([
            'success' => true,
            'message' => 'Mensagem enviada com sucesso.',
            'contato_id' => $pdo->lastInsertId()
        ]);
        
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Erro interno do servidor.']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido.']);
}
?>

