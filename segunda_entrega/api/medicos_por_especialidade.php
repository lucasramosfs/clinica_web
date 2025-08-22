<?php
require_once '../includes/config.php';

if (isset($_GET['especialidade']) && !empty($_GET['especialidade'])) {
    $especialidade = $_GET['especialidade'];

    try {
        $stmt = $pdo->prepare("SELECT Codigo, Nome FROM Medico WHERE Especialidade = :esp ORDER BY Nome");
        $stmt->bindParam(':esp', $especialidade);
        $stmt->execute();
        $medicos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(['success' => true, 'medicos' => $medicos]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Erro ao carregar médicos']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Especialidade não informada']);
}
?>

