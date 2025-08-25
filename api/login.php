<?php
// require_once '../includes/config.php';


// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     // Receber dados do formulário
//     $email = sanitize_input($_POST['email'] ?? '');
//     $senha = $_POST['senha'] ?? '';
    
//     // Validar dados de entrada
//     if (empty($email) || empty($senha)) {
//         http_response_code(400);
//         echo json_encode(['error' => 'Email e senha são obrigatórios.']);
//         exit;
//     }
    
//     try {
//         // Buscar funcionário no banco de dados
//         $stmt = $pdo->prepare("SELECT Codigo, Nome, Email, Senhahash FROM Funcionario WHERE Email = ?");
//         $stmt->execute([$email]);
//         $funcionario = $stmt->fetch();

//         if ($funcionario && password_verify($senha, $funcionario['Senhahash'])) {
//             // Login bem-sucedido
//             session_start();
//             $_SESSION['funcionario_id'] = $funcionario['Codigo'];
//             $_SESSION['funcionario_nome'] = $funcionario['Nome'];
//             $_SESSION['funcionario_email'] = $funcionario['Email'];
            
//             header("Location: ../src/pages/restrito/dashboard.php");
//             exit;

//         } else {
//             // Login falhou
//             http_response_code(401);
//             echo json_encode(['error' => 'Email ou senha incorretos.']);
//         }
        
//     } catch (PDOException $e) {
//         http_response_code(500);
//         echo json_encode(['error' => 'Erro interno do servidor.']);
//     }
// } else {
//     http_response_code(405);
//     echo json_encode(['error' => 'Método não permitido.']);
// }

require_once '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize_input($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if (empty($email) || empty($senha)) {
        header("Location: ../../login.php?erro=1");
        exit;
    }

    try {
        $stmt = $pdo->prepare("SELECT Codigo, Nome, Email, Senhahash FROM Funcionario WHERE Email = ?");
        $stmt->execute([$email]);
        $funcionario = $stmt->fetch();

        if ($funcionario && password_verify($senha, $funcionario['Senhahash'])) {
            session_start();
            $_SESSION['funcionario_id'] = $funcionario['Codigo'];
            $_SESSION['funcionario_nome'] = $funcionario['Nome'];
            $_SESSION['funcionario_email'] = $funcionario['Email'];

            header("Location: ../src/pages/restrito/dashboard.php");
            exit;
        } else {
            header("Location: ../../login.php?erro=2");
            exit;
        }
    } catch (PDOException $e) {
        header("Location: ../../login.php?erro=3");
        exit;
    }
} else {
    header("Location: ../../login.php");
    exit;
}

?>

