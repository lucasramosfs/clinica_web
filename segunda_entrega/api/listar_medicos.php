<?php
require_once '../includes/config.php';

// Verificar se o usuário está logado
verificar_login();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        // Buscar todos os médicos
        $stmt = $pdo->prepare("SELECT Codigo, Nome, Especialidade, CRM FROM Medico ORDER BY Nome");
        $stmt->execute();
        $medicos = $stmt->fetchAll();
        
        echo json_encode([
            'success' => true,
            'medicos' => $medicos
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

