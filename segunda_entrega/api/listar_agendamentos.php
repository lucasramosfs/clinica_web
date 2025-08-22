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



// require_once '../includes/config.php';

// echo "<h1>Teste do Banco de Dados VitaCare</h1>";

// try {
//     // Teste 1: Conexão
//     echo "<h2>✅ Teste 1: Conexão</h2>";
//     if ($pdo) {
//         echo "<p style='color: green;'>Conexão estabelecida com sucesso!</p>";
//     } else {
//         echo "<p style='color: red;'>Erro na conexão</p>";
//         exit;
//     }

//     // Teste 2: Verificar tabelas
//     echo "<h2>📋 Teste 2: Tabelas</h2>";
//     $tables = ['Agendamento', 'Medico', 'Paciente', 'Funcionario', 'Contato'];
    
//     foreach ($tables as $table) {
//         $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
//         if ($stmt->rowCount() > 0) {
//             echo "<p style='color: green;'>✅ Tabela '$table' encontrada</p>";
//         } else {
//             echo "<p style='color: red;'>❌ Tabela '$table' NÃO encontrada</p>";
//         }
//     }

//     // Teste 3: Estrutura Agendamento
//     echo "<h2>🏗️ Teste 3: Estrutura da Tabela Agendamento</h2>";
//     $stmt = $pdo->query("DESCRIBE Agendamento");
//     $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
//     echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
//     echo "<tr style='background: #f0f0f0;'><th>Campo</th><th>Tipo</th><th>Nulo</th><th>Chave</th><th>Padrão</th></tr>";
//     foreach ($columns as $col) {
//         echo "<tr>";
//         echo "<td>" . htmlspecialchars($col['Field']) . "</td>";
//         echo "<td>" . htmlspecialchars($col['Type']) . "</td>";
//         echo "<td>" . htmlspecialchars($col['Null']) . "</td>";
//         echo "<td>" . htmlspecialchars($col['Key']) . "</td>";
//         echo "<td>" . htmlspecialchars($col['Default'] ?? 'NULL') . "</td>";
//         echo "</tr>";
//     }
//     echo "</table>";

//     // Teste 4: Contar registros
//     echo "<h2>📊 Teste 4: Contagem de Registros</h2>";
    
//     foreach ($tables as $table) {
//         try {
//             $stmt = $pdo->query("SELECT COUNT(*) as total FROM $table");
//             $result = $stmt->fetch(PDO::FETCH_ASSOC);
//             echo "<p>📈 <strong>$table:</strong> " . $result['total'] . " registro(s)</p>";
//         } catch (Exception $e) {
//             echo "<p style='color: red;'>❌ Erro ao contar $table: " . $e->getMessage() . "</p>";
//         }
//     }

//     // Teste 5: Query dos agendamentos (igual ao sistema)
//     echo "<h2>🔍 Teste 5: Query dos Agendamentos</h2>";
    
//     $stmt = $pdo->prepare("
//         SELECT 
//             a.Codigo,
//             a.Datahora,
//             COALESCE(m.Nome, 'Médico não encontrado') as NomeMedico,
//             COALESCE(m.Especialidade, 'Não informado') as Especialidade,
//             COALESCE(p.Nome, 'Paciente não encontrado') as NomePaciente,
//             COALESCE(p.Email, 'Não informado') as EmailPaciente,
//             COALESCE(p.Telefone, 'Não informado') as TelefonePaciente
//         FROM Agendamento a
//         LEFT JOIN Medico m ON a.CodigoMedico = m.Codigo
//         LEFT JOIN Paciente p ON a.CodigoPaciente = p.Codigo
//         ORDER BY a.Datahora DESC
//         LIMIT 5
//     ");
    
//     $stmt->execute();
//     $agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
//     if (count($agendamentos) > 0) {
//         echo "<p style='color: green;'>✅ Query executada com sucesso! " . count($agendamentos) . " registro(s) encontrado(s):</p>";
        
//         echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
//         echo "<tr style='background: #f0f0f0;'>";
//         echo "<th>Código</th><th>Data/Hora</th><th>Paciente</th><th>Email</th><th>Telefone</th><th>Médico</th><th>Especialidade</th>";
//         echo "</tr>";
        
//         foreach ($agendamentos as $ag) {
//             echo "<tr>";
//             echo "<td>" . htmlspecialchars($ag['Codigo']) . "</td>";
//             echo "<td>" . htmlspecialchars($ag['Datahora']) . "</td>";
//             echo "<td>" . htmlspecialchars($ag['NomePaciente']) . "</td>";
//             echo "<td>" . htmlspecialchars($ag['EmailPaciente']) . "</td>";
//             echo "<td>" . htmlspecialchars($ag['TelefonePaciente']) . "</td>";
//             echo "<td>" . htmlspecialchars($ag['NomeMedico']) . "</td>";
//             echo "<td>" . htmlspecialchars($ag['Especialidade']) . "</td>";
//             echo "</tr>";
//         }
//         echo "</table>";
//     } else {
//         echo "<p style='color: orange;'>⚠️ Nenhum agendamento encontrado. Insira alguns dados de teste.</p>";
//     }

//     // Teste 6: JSON como a API retornaria
//     echo "<h2>📄 Teste 6: Resposta JSON da API</h2>";
    
//     $response = [
//         'success' => true,
//         'agendamentos' => $agendamentos,
//         'total' => count($agendamentos)
//     ];
    
//     echo "<pre style='background: #f5f5f5; padding: 15px; border-radius: 5px;'>";
//     echo htmlspecialchars(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
//     echo "</pre>";

// } catch (Exception $e) {
//     echo "<h2 style='color: red;'>❌ Erro</h2>";
//     echo "<p style='color: red;'>Erro: " . htmlspecialchars($e->getMessage()) . "</p>";
// }

// echo "<hr>";
// echo "<p><strong>Próximo passo:</strong> Se tudo estiver OK aqui, teste a URL da API diretamente:</p>";
// echo "<p><a href='../../../api/listar_agendamentos.php' target='_blank'>../../../api/listar_agendamentos.php</a></p>";

?>

