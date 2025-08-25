<?php
require_once '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        // Buscar todos os médicos
        $stmt = $pdo->prepare("
            SELECT Codigo, Nome, CRM, Especialidade
            FROM Medico
            ORDER BY Nome
        ");
        $stmt->execute();
        $medicos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode([
            'success' => true,
            'medicos' => $medicos
        ]);
        
    } catch (PDOException $e) {
        error_log("Erro ao listar médicos: " . $e->getMessage());
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