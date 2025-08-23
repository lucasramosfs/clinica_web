<?php
require_once '../includes/config.php';

// Definir o tipo de conteúdo como JSON
// header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        // Verificar se o código foi fornecido
        if (!isset($_GET['codigo']) || empty($_GET['codigo'])) {
            http_response_code(400);
            echo json_encode([
                'success' => false, 
                'error' => 'Código do médico é obrigatório.'
            ]);
            exit;
        }

        $codigo = intval($_GET['codigo']);

        // Buscar médico específico
        $stmt = $pdo->prepare("
            SELECT Codigo, Nome, CRM, Especialidade
            FROM Medico
            WHERE Codigo = ?
        ");
        $stmt->execute([$codigo]);
        $medico = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($medico) {
            echo json_encode([
                'success' => true,
                'medico' => $medico
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                'success' => false, 
                'error' => 'Médico não encontrado.'
            ]);
        }
        
    } catch (PDOException $e) {
        error_log("Erro ao buscar médico: " . $e->getMessage());
        http_response_code(500);
        echo json_encode([
            'success' => false, 
            'error' => 'Erro interno do servidor.'
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode([
        'success' => false, 
        'error' => 'Método não permitido.'
    ]);
}
?>