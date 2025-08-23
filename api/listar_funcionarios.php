<?php


require_once '../includes/config.php';


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        // Teste de conexão
        if (!$pdo) {
            throw new Exception("Conexão com banco de dados não estabelecida");
        }

        // Verificar se a tabela existe
        $tablesCheck = $pdo->query("SHOW TABLES LIKE 'Funcionario'");
        if ($tablesCheck->rowCount() == 0) {
            throw new Exception("Tabela 'Funcionario' não encontrada");
        }

        // Buscar todos os funcionários (sem mostrar senhas)
        $stmt = $pdo->prepare("
            SELECT 
                Codigo, 
                COALESCE(Nome, 'Não informado') as Nome, 
                COALESCE(Email, 'Não informado') as Email, 
                COALESCE(EstadoCivil, 'Não informado') as EstadoCivil, 
                DataNascimento, 
                COALESCE(Funcao, 'Não informado') as Funcao,
                DATE_FORMAT(DataNascimento, '%d/%m/%Y') as DataNascimentoFormatada
            FROM Funcionario 
            ORDER BY Nome
        ");
        $stmt->execute();
        $funcionarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Log para debug
        
        echo json_encode([
            'success' => true,
            'funcionarios' => $funcionarios,
            'total' => count($funcionarios)
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