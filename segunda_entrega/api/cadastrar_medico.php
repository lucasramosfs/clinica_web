<?php
// require_once '../includes/config.php';

// Verificar se o usuário está logado
// verificar_login();

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     // Receber dados do formulário
//     $nome = sanitize_input($_POST['nome'] ?? '');
//     $especialidade = sanitize_input($_POST['especialidade'] ?? '');
//     $crm = sanitize_input($_POST['crm'] ?? '');
//     $cpf = sanitize_input($_POST['cpf'] ?? '');
//     $email = sanitize_input($_POST['email'] ?? '');
//     $senha = sanitize_input($_POST['senha'] ?? '');
//     $telefone = sanitize_input($_POST['telefone'] ?? '');
    
//     // Validar dados de entrada
//     if (empty($nome) || empty($especialidade) || empty($crm) || empty($cpf) || empty($email) || empty($senha) || empty($telefone)) {
//         http_response_code(400);
//         echo json_encode(['error' => 'Todos os campos são obrigatórios.']);
//         exit;
//     }
    
//     try {
//         // Verificar se o CRM já está cadastrado
//         $stmt = $pdo->prepare("SELECT Codigo FROM Medico WHERE CRM = ?");
//         $stmt->execute([$crm]);
//         if ($stmt->fetch()) {
//             http_response_code(409);
//             echo json_encode(['error' => 'CRM já cadastrado.']);
//             exit;
//         }
        
//         // Inserir médico
//         $stmt = $pdo->prepare("INSERT INTO Medico (Nome, Especialidade, CRM) VALUES (?, ?, ?)");
//         $stmt->execute([$nome, $especialidade, $crm]);
        
//         echo json_encode([
//             'success' => true,
//             'message' => 'Médico cadastrado com sucesso.',
//             'medico_id' => $pdo->lastInsertId()
//         ]);
        
//     } catch (PDOException $e) {
//         http_response_code(500);
//         echo json_encode(['error' => 'Erro interno do servidor.']);
//     }
// } else {
//     http_response_code(405);
//     echo json_encode(['error' => 'Método não permitido.']);
// }

require_once '../includes/config.php'; // importa conexão e funções

// Se quiser restringir cadastro a usuários logados (funcionários)
// verificar_login();

// Receber e sanitizar os dados
$nome          = sanitize_input($_POST['nome'] ?? '');
$crm           = sanitize_input($_POST['crm'] ?? '');
$especialidade = sanitize_input($_POST['especialidade'] ?? '');

// --- Validações ---
$erros = [];

// Campos obrigatórios
if (empty($nome)  || empty($crm) || empty($especialidade)){
    $erros[] = "Todos os campos são obrigatórios.";
}


// CRM básico (UF + números)
if (!preg_match('/^[A-Z]{2}\d{1,6}$/', $crm)) {
    $erros[] = "CRM inválido. Use o formato UF000000 (ex: MG123456).";
}


if (!empty($erros)) {
    http_response_code(400);
    echo json_encode(["erros" => $erros], JSON_UNESCAPED_UNICODE);
    exit;
}

// Hash da senha
$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

try {
    // --- Verificar duplicatas ---
    $sql = "SELECT Codigo FROM Medico WHERE CRM = :crm";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':crm' => $crm]);

    if ($stmt->fetch()) {
        http_response_code(409); // conflito
        echo json_encode(["erro" => "Já existe um médico com este CRM."], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // --- Inserção ---
    $sql = "INSERT INTO Medico (Nome, Especialidade, CRM) 
            VALUES (:nome, :especialidade, :crm)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nome' => $nome,
        ':especialidade' => $especialidade,
        ':crm' => $crm,
    ]);

    echo json_encode(["sucesso" => "Médico cadastrado com sucesso!"], JSON_UNESCAPED_UNICODE);
    header("Location: ../src/pages/restrito/dashboard.php");
    exit;

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["erro" => "Erro ao cadastrar médico: " . $e->getMessage()], JSON_UNESCAPED_UNICODE);
}

?>

