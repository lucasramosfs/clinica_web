<?php
require_once '../includes/config.php';

// header('Content-Type: application/json');

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

// require_once '../includes/config.php';

// // header('Content-Type: application/json');

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     // Receber dados do formulário
//     $especialidade = sanitize_input($_POST['especialidade'] ?? '');
//     $codigo_medico = intval($_POST['codigo_medico'] ?? 0);
//     $datahora = sanitize_input($_POST['datahora'] ?? '');
//     $nome_paciente = sanitize_input($_POST['nome_paciente'] ?? '');
//     $sexo_paciente = sanitize_input($_POST['sexo_paciente'] ?? '');
//     $email_paciente = sanitize_input($_POST['email_paciente'] ?? '');
//     $telefone_paciente = sanitize_input($_POST['telefone_paciente'] ?? '');

//     // Validação básica
//     if (empty($especialidade) || $codigo_medico <= 0 || empty($datahora) ||
//         empty($nome_paciente) || empty($sexo_paciente) || empty($email_paciente) || empty($telefone_paciente)) {
//         http_response_code(400);
//         echo json_encode([
//             'success' => false,
//             'error' => 'Todos os campos obrigatórios devem ser preenchidos.'
//         ]);
//         exit;
//     }

//     if (!filter_var($email_paciente, FILTER_VALIDATE_EMAIL)) {
//         http_response_code(400);
//         echo json_encode([
//             'success' => false,
//             'error' => 'Email inválido.'
//         ]);
//         exit;
//     }

//     if (!in_array($sexo_paciente, ['M','F','O'])) {
//         http_response_code(400);
//         echo json_encode([
//             'success' => false,
//             'error' => 'Sexo inválido.'
//         ]);
//         exit;
//     }

//     // Validar formato da data e hora
//     $datetime = DateTime::createFromFormat('Y-m-d H:i:s', $datahora);
//     if (!$datetime || $datetime->format('Y-m-d H:i:s') !== $datahora) {
//         http_response_code(400);
//         echo json_encode([
//             'success' => false,
//             'error' => 'Formato de data e hora inválido.'
//         ]);
//         exit;
//     }

//     // Verificar se a data é no futuro
//     $agora = new DateTime();
//     if ($datetime <= $agora) {
//         http_response_code(400);
//         echo json_encode([
//             'success' => false,
//             'error' => 'A data e hora do agendamento devem ser no futuro.'
//         ]);
//         exit;
//     }

//     try {
//         $pdo->beginTransaction();

//         // VERIFICAÇÃO DE CONFLITO DE HORÁRIOS
//         // Verificar se já existe agendamento para este médico na mesma data e hora
//         $stmt = $pdo->prepare("
//             SELECT COUNT(*) as total 
//             FROM Agendamento 
//             WHERE CodigoMedico = ? AND Datahora = ?
//         ");
//         $stmt->execute([$codigo_medico, $datahora]);
//         $conflito = $stmt->fetch();

//         if ($conflito['total'] > 0) {
//             $pdo->rollBack();
//             http_response_code(409); // Conflict
//             echo json_encode([
//                 'success' => false,
//                 'error' => 'Já existe um agendamento para este médico neste horário. Por favor, escolha outro horário.'
//             ]);
//             exit;
//         }

//         // Verificar se o médico existe e tem a especialidade correta
//         $stmt = $pdo->prepare("
//             SELECT Nome, Especialidade 
//             FROM Medico 
//             WHERE Codigo = ? AND Especialidade = ?
//         ");
//         $stmt->execute([$codigo_medico, $especialidade]);
//         $medico = $stmt->fetch();

//         if (!$medico) {
//             $pdo->rollBack();
//             http_response_code(400);
//             echo json_encode([
//                 'success' => false,
//                 'error' => 'Médico não encontrado ou especialidade não confere.'
//             ]);
//             exit;
//         }

//         // Verifica se o paciente já existe
//         $stmt = $pdo->prepare("SELECT Codigo FROM Paciente WHERE Email = ?");
//         $stmt->execute([$email_paciente]);
//         $paciente_existente = $stmt->fetch();

//         if ($paciente_existente) {
//             $codigo_paciente = $paciente_existente['Codigo'];
            
//             // Atualizar dados do paciente existente
//             $stmt = $pdo->prepare("
//                 UPDATE Paciente 
//                 SET Nome = ?, Sexo = ?, Telefone = ? 
//                 WHERE Codigo = ?
//             ");
//             $stmt->execute([$nome_paciente, $sexo_paciente, $telefone_paciente, $codigo_paciente]);
//         } else {
//             // Inserir novo paciente
//             $stmt = $pdo->prepare("
//                 INSERT INTO Paciente (Nome, Sexo, Email, Telefone) 
//                 VALUES (?, ?, ?, ?)
//             ");
//             $stmt->execute([$nome_paciente, $sexo_paciente, $email_paciente, $telefone_paciente]);
//             $codigo_paciente = $pdo->lastInsertId();
//         }

//         // Verificar se o mesmo paciente já tem agendamento no mesmo horário (adicional)
//         $stmt = $pdo->prepare("
//             SELECT COUNT(*) as total 
//             FROM Agendamento 
//             WHERE CodigoPaciente = ? AND Datahora = ?
//         ");
//         $stmt->execute([$codigo_paciente, $datahora]);
//         $conflitoPaciente = $stmt->fetch();

//         if ($conflitoPaciente['total'] > 0) {
//             $pdo->rollBack();
//             http_response_code(409);
//             echo json_encode([
//                 'success' => false,
//                 'error' => 'Este paciente já possui um agendamento neste mesmo horário.'
//             ]);
//             exit;
//         }

//         // Inserir agendamento
//         $stmt = $pdo->prepare("
//             INSERT INTO Agendamento (Datahora, CodigoMedico, CodigoPaciente) 
//             VALUES (?, ?, ?)
//         ");
//         $stmt->execute([$datahora, $codigo_medico, $codigo_paciente]);

//         $agendamento_id = $pdo->lastInsertId();
        
//         $pdo->commit();

//         echo json_encode([
//             'success' => true,
//             'message' => "Agendamento realizado com sucesso! Dr(a). {$medico['Nome']} - {$datetime->format('d/m/Y')} às {$datetime->format('H:i')}",
//             'agendamento_id' => $agendamento_id,
//             'medico' => $medico['Nome'],
//             'data_formatada' => $datetime->format('d/m/Y H:i')
//         ]);

//     } catch (PDOException $e) {
//         $pdo->rollBack();
//         error_log("Erro ao agendar consulta: " . $e->getMessage());
//         http_response_code(500);
//         echo json_encode([
//             'success' => false,
//             'error' => 'Erro interno do servidor ao processar agendamento.'
//         ]);
//     }
// } else {
//     http_response_code(405);
//     echo json_encode([
//         'success' => false,
//         'error' => 'Método não permitido.'
//     ]);
// }
?>