<?php

require_once '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (!$pdo) {
            throw new Exception("Conexão com banco de dados não estabelecida");
        }

        // Obter dados JSON
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Dados JSON inválidos");
        }

        // Campos obrigatórios
        $requiredFields = ['codigo', 'nome', 'email', 'funcao'];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || empty(trim($data[$field]))) {
                throw new Exception("Campo '$field' é obrigatório");
            }
        }

        $codigo = intval($data['codigo']);
        $nome = trim($data['nome']);
        $email = trim($data['email']);
        $funcao = trim($data['funcao']);
        $estadoCivil = isset($data['estadoCivil']) ? trim($data['estadoCivil']) : null;
        $dataNascimento = isset($data['dataNascimento']) ? trim($data['dataNascimento']) : null;
        $senha = isset($data['senha']) ? trim($data['senha']) : null;

        if ($codigo <= 0) throw new Exception("Código do funcionário inválido");
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) throw new Exception("Email inválido");

        // Verificar se o funcionário existe
        $stmtCheck = $pdo->prepare("SELECT Codigo FROM Funcionario WHERE Codigo = :codigo");
        $stmtCheck->bindParam(':codigo', $codigo, PDO::PARAM_INT);
        $stmtCheck->execute();
        if ($stmtCheck->rowCount() == 0) throw new Exception("Funcionário não encontrado");

        // Verificar email duplicado
        $stmtEmailCheck = $pdo->prepare("SELECT Codigo FROM Funcionario WHERE Email = :email AND Codigo != :codigo");
        $stmtEmailCheck->bindParam(':email', $email);
        $stmtEmailCheck->bindParam(':codigo', $codigo, PDO::PARAM_INT);
        $stmtEmailCheck->execute();
        if ($stmtEmailCheck->rowCount() > 0) throw new Exception("Este email já está sendo usado por outro funcionário");

        // Montar query de atualização dinamicamente
        $sql = "UPDATE Funcionario SET Nome = :nome, Email = :email, Funcao = :funcao";
        $params = [
            ':nome' => $nome,
            ':email' => $email,
            ':funcao' => $funcao,
            ':codigo' => $codigo
        ];

        if ($estadoCivil !== null && $estadoCivil !== '') {
            $sql .= ", EstadoCivil = :estadoCivil";
            $params[':estadoCivil'] = $estadoCivil;
        }

        if ($dataNascimento !== null && $dataNascimento !== '') {
            $dateObj = DateTime::createFromFormat('Y-m-d', $dataNascimento);
            if ($dateObj && $dateObj->format('Y-m-d') === $dataNascimento) {
                $sql .= ", DataNascimento = :dataNascimento";
                $params[':dataNascimento'] = $dataNascimento;
            } else {
                throw new Exception("Data de nascimento inválida. Use o formato YYYY-MM-DD");
            }
        }

        if ($senha !== null && $senha !== '') {
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
            $sql .= ", Senhahash = :senha";
            $params[':senha'] = $senha_hash;
        }

        $sql .= " WHERE Codigo = :codigo";

        // Executar atualização
        $stmt = $pdo->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();

        echo json_encode([
            'success' => true,
            'message' => $stmt->rowCount() > 0 ? 'Funcionário atualizado com sucesso.' : 'Funcionário atualizado (nenhuma alteração detectada).'
        ], JSON_UNESCAPED_UNICODE);

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => 'Erro ao atualizar no banco de dados.',
            'debug' => $e->getMessage()
        ], JSON_UNESCAPED_UNICODE);
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ], JSON_UNESCAPED_UNICODE);
    }
} else {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'error' => 'Método não permitido. Use POST.'
    ], JSON_UNESCAPED_UNICODE);
}
?>
