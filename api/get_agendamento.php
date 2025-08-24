<?php

require_once '../includes/config.php';

// Verificar se o usuário está logado
// verificar_login();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Verifica se o código foi informado
    if (!isset($_GET['codigo']) || empty($_GET['codigo'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Código do agendamento não informado.']);
        exit;
    }

    $codigo = intval($_GET['codigo']);

    try {
        $stmt = $pdo->prepare("
            SELECT 
                a.Codigo,
                a.Datahora,
                m.Nome as NomeMedico,
                m.Especialidade,
                p.Nome as NomePaciente,
                p.Email as EmailPaciente,
                p.Telefone as TelefonePaciente
            FROM Agendamento a
            INNER JOIN Medico m ON a.CodigoMedico = m.Codigo
            INNER JOIN Paciente p ON a.CodigoPaciente = p.Codigo
            WHERE a.Codigo = :codigo
            LIMIT 1
        ");
        $stmt->execute([':codigo' => $codigo]);
        $agendamento = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($agendamento) {
            echo json_encode([
                'success' => true,
                'agendamento' => $agendamento
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'error' => 'Agendamento não encontrado.'
            ]);
        }

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Erro interno do servidor.']);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Método não permitido.']);
}
