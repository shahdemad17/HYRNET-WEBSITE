<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false]);
    exit();
}

$postId = $_POST['post_id'];
$content = trim($_POST['content']);

if (!empty($content)) {
    $stmt = $pdo->prepare("INSERT INTO comments (user_id, post_id, content) VALUES (?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $postId, $content]);
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Comment cannot be empty']);
}
?>