<?php
require_once '../includes/config.php';

// Verificar se o usuário está logado
verificar_login();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        // Buscar todos os agendamentos com informações do médico e paciente
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
            ORDER BY a.Datahora DESC
        ");
        $stmt->execute();
        $agendamentos = $stmt->fetchAll();
        
        echo json_encode([
            'success' => true,
            'agendamentos' => $agendamentos
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

