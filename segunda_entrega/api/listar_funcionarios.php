<?php
require_once '../includes/config.php';

// Verificar se o usuário está logado
verificar_login();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        // Buscar todos os funcionários (sem mostrar senhas)
        $stmt = $pdo->prepare("SELECT Codigo, Nome, Email, EstadoCivil, DataNascimento, Funcao FROM Funcionario ORDER BY Nome");
        $stmt->execute();
        $funcionarios = $stmt->fetchAll();
        
        echo json_encode([
            'success' => true,
            'funcionarios' => $funcionarios
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

