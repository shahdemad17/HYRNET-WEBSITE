<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false]);
    exit();
}

$postId = $_POST['post_id'];

// Check if already liked
$checkStmt = $pdo->prepare("SELECT id FROM likes WHERE user_id = ? AND post_id = ?");
$checkStmt->execute([$_SESSION['user_id'], $postId]);

if ($checkStmt->rowCount() > 0) {
    // Unlike
    $stmt = $pdo->prepare("DELETE FROM likes WHERE user_id = ? AND post_id = ?");
    $stmt->execute([$_SESSION['user_id'], $postId]);
    echo json_encode(['success' => true, 'action' => 'unliked']);
} else {
    // Like
    $stmt = $pdo->prepare("INSERT INTO likes (user_id, post_id) VALUES (?, ?)");
    $stmt->execute([$_SESSION['user_id'], $postId]);
    echo json_encode(['success' => true, 'action' => 'liked']);
}
?>