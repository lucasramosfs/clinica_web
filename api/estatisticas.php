<?php
require_once '../includes/config.php';

// Verificar se o usuário está logado
// verificar_login();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        // Buscar estatísticas gerais da clínica
        $stats = [];
        
        // Total de funcionários
        $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM Funcionario");
        $stmt->execute();
        $stats['total_funcionarios'] = $stmt->fetch()['total'];
        
        // Total de médicos
        $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM Medico");
        $stmt->execute();
        $stats['total_medicos'] = $stmt->fetch()['total'];
        
        // Total de agendamentos
        $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM Agendamento");
        $stmt->execute();
        $stats['total_agendamentos'] = $stmt->fetch()['total'];
        
        // Total de mensagens de contato
        $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM Contato");
        $stmt->execute();
        $stats['total_contatos'] = $stmt->fetch()['total'];
        
        // Agendamentos do dia atual
        $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM Agendamento WHERE DATE(Datahora) = CURDATE()");
        $stmt->execute();
        $stats['agendamentos_hoje'] = $stmt->fetch()['total'];

        // Especialidades
        $stmt = $pdo->prepare("
            SELECT COUNT(DISTINCT Especialidade) AS total
            FROM Medico
        ");
        $stmt->execute();
        $stats['especialidades'] = $stmt->fetch()['total'];
        
        // Especialidades mais procuradas
        $stmt = $pdo->prepare("
            SELECT m.Especialidade, COUNT(a.Codigo) as total_agendamentos
            FROM Agendamento a
            INNER JOIN Medico m ON a.CodigoMedico = m.Codigo
            GROUP BY m.Especialidade
            ORDER BY total_agendamentos DESC
            LIMIT 5
        ");
        $stmt->execute();
        $stats['especialidades_populares'] = $stmt->fetchAll();
        
        echo json_encode([
            'success' => true,
            'estatisticas' => $stats
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

