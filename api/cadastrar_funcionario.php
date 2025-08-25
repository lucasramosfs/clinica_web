<?php
require_once '../includes/config.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Receber dados do formulário
    $nome = sanitize_input($_POST['nome'] ?? '');
    $email = sanitize_input($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $estado_civil = sanitize_input($_POST['estado_civil'] ?? '');
    $data_nascimento = sanitize_input($_POST['data_nascimento'] ?? '');
    $funcao = sanitize_input($_POST['funcao'] ?? '');
    
    // Validar dados de entrada
    if (empty($nome) || empty($email) || empty($senha) || empty($funcao)) {
        http_response_code(400);
        echo json_encode(['error' => 'Nome, email, senha e função são obrigatórios.']);
        exit;
    }
    
    // Validar formato de email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(['error' => 'Email inválido.']);
        exit;
    }
    
    try {
        // Verificar se o email já está cadastrado
        $stmt = $pdo->prepare("SELECT Codigo FROM Funcionario WHERE Email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            http_response_code(409);
            echo json_encode(['error' => 'Email já cadastrado.']);
            exit;
        }
        
        // Criptografar senha
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        
        // Inserir funcionário
        $stmt = $pdo->prepare("INSERT INTO Funcionario (Nome, Email, Senhahash, EstadoCivil, DataNascimento, Funcao) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nome, $email, $senha_hash, $estado_civil, $data_nascimento, $funcao]);
        
        echo json_encode([
            'success' => true,
            'message' => 'Funcionário cadastrado com sucesso.',
            'funcionario_id' => $pdo->lastInsertId()
        ]);

        header("Location: ../src/pages/restrito/dashboard.php");
        exit;
        
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Erro interno do servidor.']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido.']);
}
?>

