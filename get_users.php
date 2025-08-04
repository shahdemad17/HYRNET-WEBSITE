<?php
include 'config.php';

try {
    $stmt = $pdo->prepare("
        SELECT id, name FROM users WHERE id != ?
        ORDER BY name
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    header('Content-Type: application/json');
    echo json_encode($users);
} catch (PDOException $e) {
    header("HTTP/1.1 500 Internal Server Error");
    echo json_encode(['error' => $e->getMessage()]);
}
?>