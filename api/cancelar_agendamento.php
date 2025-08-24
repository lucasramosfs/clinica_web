<?php
require_once '../includes/config.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ler o JSON enviado
    $data = json_decode(file_get_contents("php://input"), true);
    $codigo = intval($data['codigo'] ?? 0);

    if ($codigo <= 0) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Código inválido.']);
        exit;
    }

    try {
        // Atualiza o status do agendamento para "cancelado"
        $stmt = $pdo->prepare("DELETE FROM Agendamento WHERE codigo = ?");
        $stmt->execute([$codigo]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Agendamento não encontrado ou já cancelado.']);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Erro no banco de dados: ' . $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Método não permitido.']);
}
