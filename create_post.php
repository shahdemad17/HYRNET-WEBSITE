<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    $content = $_POST['content'];
    $userId = $_SESSION['user_id'];
    
    // Handle file upload
    $imagePath = null;
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "uploads/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        
        $fileExt = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $fileName = uniqid() . '.' . $fileExt;
        $targetFile = $targetDir . $fileName;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $imagePath = $fileName;
        }
    }
    
    try {
        $stmt = $pdo->prepare("INSERT INTO posts (user_id, content, image) VALUES (?, ?, ?)");
        $stmt->execute([$userId, $content, $imagePath]);
        
        header("Location: dashboard.php");
        exit();
    } catch (PDOException $e) {
        die("Error creating post: " . $e->getMessage());
    }
} else {
    header("Location: login.php");
    exit();
}
?>