<?php
require_once '../includes/config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Receber dados do formulário
    $especialidade = sanitize_input($_POST['especialidade'] ?? '');
    $codigo_medico = intval($_POST['codigo_medico'] ?? 0);
    $datahora = sanitize_input($_POST['datahora'] ?? '');
    $nome_paciente = sanitize_input($_POST['nome_paciente'] ?? '');
    $sexo_paciente = sanitize_input($_POST['sexo_paciente'] ?? '');
    $email_paciente = sanitize_input($_POST['email_paciente'] ?? '');
    $telefone_paciente = sanitize_input($_POST['telefone_paciente'] ?? '');

    // Validação básica
    if (empty($especialidade) || $codigo_medico <= 0 || empty($datahora) ||
        empty($nome_paciente) || empty($sexo_paciente) || empty($email_paciente) || empty($telefone_paciente)) {
        http_response_code(400);
        echo json_encode(['error' => 'Todos os campos obrigatórios devem ser preenchidos.']);
        exit;
    }

    if (!filter_var($email_paciente, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(['error' => 'Email inválido.']);
        exit;
    }

    if (!in_array($sexo_paciente, ['M','F','O'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Sexo inválido.']);
        exit;
    }

    try {
        $pdo->beginTransaction();

        // Verifica se o paciente já existe
        $stmt = $pdo->prepare("SELECT Codigo FROM Paciente WHERE Email = ?");
        $stmt->execute([$email_paciente]);
        $paciente_existente = $stmt->fetch();

        if ($paciente_existente) {
            $codigo_paciente = $paciente_existente['Codigo'];
            $stmt = $pdo->prepare("UPDATE Paciente SET Nome = ?, Sexo = ?, Telefone = ? WHERE Codigo = ?");
            $stmt->execute([$nome_paciente, $sexo_paciente, $telefone_paciente, $codigo_paciente]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO Paciente (Nome, Sexo, Email, Telefone) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nome_paciente, $sexo_paciente, $email_paciente, $telefone_paciente]);
            $codigo_paciente = $pdo->lastInsertId();
        }

        // Inserir agendamento
        $stmt = $pdo->prepare("INSERT INTO Agendamento (Datahora, CodigoMedico, CodigoPaciente) VALUES (?, ?, ?)");
        $stmt->execute([$datahora, $codigo_medico, $codigo_paciente]);

        $pdo->commit();

        echo json_encode([
            'success' => true,
            'message' => 'Agendamento realizado com sucesso!',
            'agendamento_id' => $pdo->lastInsertId()
        ]);

    } catch (PDOException $e) {
        $pdo->rollBack();
        http_response_code(500);
        echo json_encode(['error' => 'Erro ao agendar: '.$e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido.']);
}
