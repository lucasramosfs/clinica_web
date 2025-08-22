<?php

require_once '../includes/config.php';

try {
    $stmt = $pdo->prepare("SELECT DISTINCT Especialidade FROM Medico ORDER BY Especialidade");
    $stmt->execute();
    $especialidades = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo json_encode(['success' => true, 'especialidades' => $especialidades]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Erro ao carregar especialidades']);
}
?>

