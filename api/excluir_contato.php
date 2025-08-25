<?php

require_once '../includes/config.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Teste de conexão
        if (!$pdo) {
            throw new Exception("Conexão com banco de dados não estabelecida");
        }

        // Obter dados JSON do corpo da requisição
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Dados JSON inválidos");
        }

        if (!isset($data['codigo']) || empty($data['codigo'])) {
            throw new Exception("Código do contato não fornecido");
        }

        $codigo = intval($data['codigo']);
        
        if ($codigo <= 0) {
            throw new Exception("Código do contato inválido");
        }

        // Verificar se o contato existe antes de excluir
        $stmtCheck = $pdo->prepare("SELECT Codigo FROM Contato WHERE Codigo = :codigo");
        $stmtCheck->bindParam(':codigo', $codigo, PDO::PARAM_INT);
        $stmtCheck->execute();
        
        if ($stmtCheck->rowCount() == 0) {
            throw new Exception("Contato não encontrado");
        }

        // Excluir o contato
        $stmt = $pdo->prepare("DELETE FROM Contato WHERE Codigo = :codigo");
        $stmt->bindParam(':codigo', $codigo, PDO::PARAM_INT);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            
            echo json_encode([
                'success' => true,
                'message' => 'Contato excluído com sucesso.'
            ], JSON_UNESCAPED_UNICODE);
        } else {
            throw new Exception("Nenhum registro foi excluído");
        }
        
    } catch (PDOException $e) {
        // Log do erro específico do banco
        
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => 'Erro ao excluir do banco de dados.',
            'debug' => $e->getMessage() // Remover em produção
        ], JSON_UNESCAPED_UNICODE);
        
    } catch (Exception $e) {
        // Log de outros erros
        
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ], JSON_UNESCAPED_UNICODE);
    }
} else {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'error' => 'Método não permitido. Use POST.'
    ], JSON_UNESCAPED_UNICODE);
}
?>