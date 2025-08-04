<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit();
}

$postId = $_POST['post_id'];
$receiverId = $_POST['receiver_id'];
$content = trim($_POST['content']);

if (empty($content)) {
    echo json_encode(['success' => false, 'message' => 'Message cannot be empty']);
    exit();
}

// Check if receiver exists
$userStmt = $pdo->prepare("SELECT id FROM users WHERE id = ?");
$userStmt->execute([$receiverId]);

if ($userStmt->rowCount() === 0) {
    echo json_encode(['success' => false, 'message' => 'User not found']);
    exit();
}

// Insert message
$stmt = $pdo->prepare("INSERT INTO post_chats (sender_id, receiver_id, post_id, message) VALUES (?, ?, ?, ?)");
$stmt->execute([$_SESSION['user_id'], $receiverId, $postId, $content]);

echo json_encode(['success' => true]);
?>