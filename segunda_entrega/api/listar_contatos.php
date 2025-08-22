<?php
require_once '../includes/config.php';

// Verificar se o usuário está logado
verificar_login();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        // Buscar todas as mensagens de contato
        $stmt = $pdo->prepare("SELECT Codigo, Nome, Email, Telefone, Mensagem, Datahora FROM Contato ORDER BY Datahora DESC");
        $stmt->execute();
        $contatos = $stmt->fetchAll();
        
        echo json_encode([
            'success' => true,
            'contatos' => $contatos
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

