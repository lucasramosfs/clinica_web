<?php
require_once '../includes/config.php';

// header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        // Receber parâmetros
        $codigo_medico = intval($_GET['medico'] ?? 0);
        $data = sanitize_input($_GET['data'] ?? '');

        // Validações básicas
        if ($codigo_medico <= 0) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => 'Código do médico é obrigatório.'
            ]);
            exit;
        }

        if (empty($data)) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => 'Data é obrigatória.'
            ]);
            exit;
        }

        // Validar formato da data
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data)) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => 'Formato de data inválido. Use YYYY-MM-DD.'
            ]);
            exit;
        }

        // Buscar horários já agendados para este médico na data especificada
        $stmt = $pdo->prepare("
            SELECT TIME_FORMAT(TIME(Datahora), '%H:%i') as hora_ocupada
            FROM Agendamento 
            WHERE CodigoMedico = ? AND DATE(Datahora) = ?
            ORDER BY Datahora
        ");
        
        $stmt->execute([$codigo_medico, $data]);
        $agendamentos = $stmt->fetchAll(PDO::FETCH_COLUMN);

        echo json_encode([
            'success' => true,
            'horarios_ocupados' => $agendamentos,
            'data' => $data,
            'codigo_medico' => $codigo_medico
        ]);

    } catch (PDOException $e) {
        error_log("Erro ao buscar horários ocupados: " . $e->getMessage());
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