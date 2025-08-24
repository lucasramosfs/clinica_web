<?php
require_once '../includes/config.php';




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Ler dados JSON do corpo da requisição
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        // Log para debug
        error_log("Dados recebidos para exclusão: " . json_encode($data));

        // Validar se os dados foram recebidos corretamente
        if (!$data) {
            http_response_code(400);
            echo json_encode([
                'success' => false, 
                'error' => 'Dados JSON inválidos.'
            ]);
            exit;
        }

        // Validar se o código foi fornecido
        if (!isset($data['codigo']) || empty($data['codigo'])) {
            http_response_code(400);
            echo json_encode([
                'success' => false, 
                'error' => 'Código do médico é obrigatório.'
            ]);
            exit;
        }

        $codigo = intval($data['codigo']);

        // Verificar se o médico existe
        $stmt = $pdo->prepare("SELECT Codigo, Nome FROM Medico WHERE Codigo = ?");
        $stmt->execute([$codigo]);
        $medico = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$medico) {
            http_response_code(404);
            echo json_encode([
                'success' => false, 
                'error' => 'Médico não encontrado.'
            ]);
            exit;
        }

        // Verificar se existem agendamentos para este médico
        $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM Agendamento WHERE CodigoMedico = ?");
        $stmt->execute([$codigo]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result['total'] > 0) {
            http_response_code(400);
            echo json_encode([
                'success' => false, 
                'error' => 'Não é possível excluir o médico pois existem agendamentos associados.'
            ]);
            exit;
        }

        // Excluir médico do banco de dados
        $stmt = $pdo->prepare("DELETE FROM Medico WHERE Codigo = ?");
        $result = $stmt->execute([$codigo]);
        
        if ($result && $stmt->rowCount() > 0) {
            echo json_encode([
                'success' => true,
                'message' => 'Médico excluído com sucesso!'
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'success' => false, 
                'error' => 'Erro ao excluir médico do banco de dados.'
            ]);
        }
        
    } catch (PDOException $e) {
        error_log("Erro ao excluir médico: " . $e->getMessage());
        
        // Verificar se é erro de constraint (chave estrangeira)
        if ($e->getCode() == '23000') {
            http_response_code(400);
            echo json_encode([
                'success' => false, 
                'error' => 'Não é possível excluir o médico pois existem registros relacionados.'
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'success' => false, 
                'error' => 'Erro interno do servidor.'
            ]);
        }
    }
} else {
    http_response_code(405);
    echo json_encode([
        'success' => false, 
        'error' => 'Método não permitido.'
    ]);
}
?>