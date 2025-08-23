<?php
require_once '../includes/config.php';

// Definir o tipo de conteúdo como JSON
// header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Ler dados JSON do corpo da requisição
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        // Validar se os dados foram recebidos corretamente
        if (!$data) {
            http_response_code(400);
            echo json_encode([
                'success' => false, 
                'error' => 'Dados JSON inválidos.'
            ]);
            exit;
        }

        // Validar campos obrigatórios
        $required_fields = ['codigo', 'nome', 'crm', 'especialidade'];
        foreach ($required_fields as $field) {
            if (!isset($data[$field]) || empty(trim($data[$field]))) {
                http_response_code(400);
                echo json_encode([
                    'success' => false, 
                    'error' => "Campo '$field' é obrigatório."
                ]);
                exit;
            }
        }

        $codigo = intval($data['codigo']);
        $nome = trim($data['nome']);
        $crm = trim($data['crm']);
        $especialidade = trim($data['especialidade']);

        // Validar formato do CRM
        if (!preg_match('/^[A-Z]{2,3}\d{4,6}$/', $crm)) {
            http_response_code(400);
            echo json_encode([
                'success' => false, 
                'error' => 'CRM deve seguir o formato: UF + números (ex: CRM12345)'
            ]);
            exit;
        }

        // Verificar se o médico existe
        $stmt = $pdo->prepare("SELECT Codigo FROM Medico WHERE Codigo = ?");
        $stmt->execute([$codigo]);
        if (!$stmt->fetch()) {
            http_response_code(404);
            echo json_encode([
                'success' => false, 
                'error' => 'Médico não encontrado.'
            ]);
            exit;
        }

        // Verificar se CRM já existe para outro médico
        $stmt = $pdo->prepare("SELECT Codigo FROM Medico WHERE CRM = ? AND Codigo != ?");
        $stmt->execute([$crm, $codigo]);
        if ($stmt->fetch()) {
            http_response_code(400);
            echo json_encode([
                'success' => false, 
                'error' => 'CRM já está cadastrado para outro médico.'
            ]);
            exit;
        }

        // Atualizar médico no banco de dados
        $stmt = $pdo->prepare("
            UPDATE Medico 
            SET Nome = ?, CRM = ?, Especialidade = ?
            WHERE Codigo = ?
        ");
        
        $result = $stmt->execute([$nome, $crm, $especialidade, $codigo]);
        
        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Médico atualizado com sucesso!'
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'success' => false, 
                'error' => 'Erro ao atualizar médico no banco de dados.'
            ]);
        }
        
    } catch (PDOException $e) {
        error_log("Erro ao atualizar médico: " . $e->getMessage());
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