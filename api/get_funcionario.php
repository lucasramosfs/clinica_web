<?php

require_once '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        // Verificar se foi fornecido o código
        if (!isset($_GET['codigo']) || empty($_GET['codigo'])) {
            throw new Exception("Código do funcionário não fornecido");
        }

        $codigo = intval($_GET['codigo']);
        
        if ($codigo <= 0) {
            throw new Exception("Código do funcionário inválido");
        }

        // Teste de conexão
        if (!$pdo) {
            throw new Exception("Conexão com banco de dados não estabelecida");
        }

        // Buscar o funcionário específico (sem mostrar senha)
        $stmt = $pdo->prepare("
            SELECT 
                Codigo,
                Nome,
                Email,
                EstadoCivil,
                DataNascimento,
                Funcao,
                DATE_FORMAT(DataNascimento, '%Y-%m-%d') as DataNascimentoInput,
                DATE_FORMAT(DataNascimento, '%d/%m/%Y') as DataNascimentoFormatada
            FROM Funcionario 
            WHERE Codigo = :codigo
        ");
        
        $stmt->bindParam(':codigo', $codigo, PDO::PARAM_INT);
        $stmt->execute();
        $funcionario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($funcionario) {
            echo json_encode([
                'success' => true,
                'funcionario' => $funcionario
            ], JSON_UNESCAPED_UNICODE);
        } else {
            throw new Exception("Funcionário não encontrado");
        }
        
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
        'error' => 'Método não permitido. Use GET.'
    ], JSON_UNESCAPED_UNICODE);
}
?>