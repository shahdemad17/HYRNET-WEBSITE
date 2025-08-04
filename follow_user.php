<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false]);
    exit();
}

$userId = $_POST['user_id'];
$action = $_POST['action'] ?? 'follow'; // Default to follow if not specified

// Prevent user from following themselves
if ($userId == $_SESSION['user_id']) {
    echo json_encode(['success' => false, 'message' => 'You cannot follow yourself']);
    exit();
}

if ($action === 'follow') {
    // Check if not already following
    $checkStmt = $pdo->prepare("SELECT id FROM follows WHERE follower_id = ? AND following_id = ?");
    $checkStmt->execute([$_SESSION['user_id'], $userId]);

    if ($checkStmt->rowCount() === 0) {
        $stmt = $pdo->prepare("INSERT INTO follows (follower_id, following_id) VALUES (?, ?)");
        $stmt->execute([$_SESSION['user_id'], $userId]);
        echo json_encode(['success' => true, 'action' => 'followed']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Already following']);
    }
} elseif ($action === 'unfollow') {
    $stmt = $pdo->prepare("DELETE FROM follows WHERE follower_id = ? AND following_id = ?");
    $stmt->execute([$_SESSION['user_id'], $userId]);
    echo json_encode(['success' => true, 'action' => 'unfollowed']);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid action']);
}
?>