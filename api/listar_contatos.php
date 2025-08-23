<?php

require_once '../includes/config.php';

// verificar_login();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        // Teste de conexão
        if (!$pdo) {
            throw new Exception("Conexão com banco de dados não estabelecida");
        }

        // Verificar se a tabela existe
        $tablesCheck = $pdo->query("SHOW TABLES LIKE 'Contato'");
        if ($tablesCheck->rowCount() == 0) {
            throw new Exception("Tabela 'Contato' não encontrada");
        }

        // Query para buscar todos os contatos
        $stmt = $pdo->prepare("
            SELECT 
                Codigo,
                Nome,
                Email,
                Telefone,
                Mensagem,
                Datahora,
                DATE_FORMAT(Datahora, '%Y-%m-%d %H:%i:%s') as DatahoraFormatada
            FROM Contato 
            ORDER BY Datahora DESC
        ");
        
        $stmt->execute();
        $contatos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Log para debug
        
        echo json_encode([
            'success' => true,
            'contatos' => $contatos,
            'total' => count($contatos)
        ], JSON_UNESCAPED_UNICODE);
        
    } catch (PDOException $e) {
        // Log do erro específico do banco
        
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => 'Erro ao consultar banco de dados.',
            'debug' => $e->getMessage() // Remover em produção
        ], JSON_UNESCAPED_UNICODE);
        
    } catch (Exception $e) {
        // Log de outros erros
        
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ], JSON_UNESCAPED_UNICODE);
    }
} else {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'error' => 'Método não permitido. Use GET.'
    ], JSON_UNESCAPED_UNICODE);
}
?>