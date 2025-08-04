<?php
include 'config.php';

if (!isset($_GET['post_id']) || !isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit();
}

$postId = $_GET['post_id'];

$stmt = $pdo->prepare("
    SELECT c.*, u.name, u.profile_image 
    FROM comments c
    JOIN users u ON c.user_id = u.id
    WHERE c.post_id = ?
    ORDER BY c.created_at DESC
");
$stmt->execute([$postId]);
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($comments);
?>