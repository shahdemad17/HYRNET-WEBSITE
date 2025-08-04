<?php
session_start();
include 'config.php';

// لو المستخدم مش عامل تسجيل دخول
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// استدعاء بيانات المستخدم من قاعدة البيانات
$userStmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$userStmt->execute([$_SESSION['user_id']]);
$currentUser = $userStmt->fetch(PDO::FETCH_ASSOC); // تأكد من استخدام FETCH_ASSOC

// ✅ بيانات تجريبية لو المستخدم غير موجود (للتطوير فقط)
if (!$currentUser) {
    $currentUser = [
        'name' => 'Shahd Emad',
        'job_title' => 'BIS Student / Data Analyst',
        'country' => 'Egypt',

        'profile_views' => 4,
        'post_impressions' => 7,
        'profile_image' => 'uploads/profile.jpg', // تأكدي إن الصورة موجودة في مجلد uploads
    ];
} else {
    // إضافة قيم افتراضية لو الأعمدة مش موجودة في قاعدة البيانات

    $currentUser['profile_views'] = $currentUser['profile_views'] ?? 0;
    $currentUser['post_impressions'] = $currentUser['post_impressions'] ?? 0;
}

// روابط المستخدم الجانبية
// Sidebar user links
$userLinks = [
    ['icon' => '📌', 'label' => 'Saved Items', 'url' => 'user_links.php?page=saved'],
    ['icon' => '👥', 'label' => 'Groups', 'url' => 'user_links.php?page=groups'],
    ['icon' => '📰', 'label' => 'Newsletters', 'url' => 'user_links.php?page=newsletters'],
    ['icon' => '📅', 'label' => 'Events', 'url' => 'user_links.php?page=events'],
];



// دالة آمنة لطباعة النصوص
function safe($val)
{
    return htmlspecialchars($val ?? '', ENT_QUOTES, 'UTF-8');
}

// استدعاء المنشورات مع معلومات إضافية
$postsStmt = $pdo->prepare("
    SELECT p.*, u.id AS user_id, u.name, u.profile_image, u.job_title, 
           (SELECT COUNT(*) FROM likes WHERE post_id = p.id) AS like_count,
           (SELECT COUNT(*) FROM comments WHERE post_id = p.id) AS comment_count,
           EXISTS(SELECT 1 FROM likes WHERE post_id = p.id AND user_id = ?) AS is_liked,
           EXISTS(SELECT 1 FROM follows WHERE follower_id = ? AND following_id = u.id) AS is_following
    FROM posts p
    JOIN users u ON p.user_id = u.id
    ORDER BY p.created_at DESC
    LIMIT 10
");
$postsStmt->execute([$_SESSION['user_id'], $_SESSION['user_id']]);
$posts = $postsStmt->fetchAll(PDO::FETCH_ASSOC);

// اقتراحات مستخدمين جدد
$suggestionsStmt = $pdo->prepare("
    SELECT u.id, u.name, u.profile_image, u.job_title 
    FROM users u
    WHERE u.id != ? AND u.id NOT IN (
        SELECT following_id FROM follows WHERE follower_id = ?
    )
    ORDER BY RAND()
    LIMIT 3
");
$suggestionsStmt->execute([$_SESSION['user_id'], $_SESSION['user_id']]);
$suggestions = $suggestionsStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HYRNET - Your Career Mirror</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


    <link rel="stylesheet" href="css/bootstrap.css">

    <style>
        :root {
            --primary: #0077B5;
            --secondary: #00A0DC;
            --dark: #313335;
            --gray: #86888A;
            --light-gray: #EEF3F8;
            --white: #FFFFFF;
            --border-radius: 10px;
            --box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: white;
            color: var(--dark);
            line-height: 1.6;
            margin-top: 80px;
        }

        /* Header */
        header {
            background-color: var(--white);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 100;
            padding: 8px 0;
            margin-bottom: 60px;
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            padding: 0 16px;

        }


        .search-bar {
            flex-grow: 1;
            position: relative;
        }

        .search-bar input {
            width: 100%;
            max-width: 300px;
            padding: 10px 16px 10px 40px;
            border-radius: var(--border-radius);
            border: 1px solid var(--white);
            background-color: white;
            font-size: 14px;
            transition: var(--transition);
        }

        .search-bar input:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(255, 87, 34, 0.9);
        }

        .search-bar i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: white;
        }

        .navbar {
            position: absolute;
            top: 0;
            width: 100%;
            z-index: 1000;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            font-size: 1rem;
            /* أصغر شوية */
            font-family: 'Roboto', sans-serif !important;
            padding: 8px 16px;
            /* أصغر */
            height: 68px;
        }



        .navbar-nav .nav-link {
            color: #333;
            margin: 0 0px;
            /* تقليل المسافة بين العناصر */
            font-weight: 500;
            transition: color 0.3s;
            font-family: 'Roboto', sans-serif !important;

        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-item.active .nav-link {
            color: #333;
        }

        .nav-profile {
            display: flex;
            align-items: center;
            gap: 8px;
            position: absolute;
            right: 40px;
            /* خليه في اليمين */
            top: 50%;
            transform: translateY(-50%);
            text-decoration: none !important;

            color: rgba(255, 87, 34, 0.9);
            font-weight: bold;
            font-size: 15px;
            transition: all 0.3s ease-in-out;
            padding: 8px 14px;
            border-radius: 5px;

            background: none;
        }

        .nav-profile:hover {

            color: white;
            transform: scale(1.05);
            outline: 2px solid rgba(255, 87, 34, 0.9);
            box-shadow: 4px 5px 17px -4px rgba(255, 87, 34, 0.9);
            background-color: rgba(255, 87, 34, 0.9);
        }

        .nav-profile i {
            font-size: 30px;

        }


        /* Main Content */
        /* Main Container Layout */

        .main-container {
            max-width: 1100px;
            margin: 70px auto 20px;
            display: grid;
            grid-template-columns: 250px 1fr;
            gap: 20px;
            margin-top: 50px;
        }

        /* Left Sidebar */
        /* Container */
        .left-sidebar {
            width: 100%;
            max-width: 320px;
            padding: 20px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-bottom: 30px;
            max-height: 750px;
            overflow-y: auto;
            font-family: 'Cairo', sans-serif;
        }

        .profile-card {
            position: relative;
        }

        .profile-bg {
            height: 80px;
            background: linear-gradient(135deg, #ff6b00, #ffa500);
            border-top-left-radius: 16px;
            border-top-right-radius: 16px;
        }

        .profile-info {
            margin-top: -40px;
        }

        .profile-img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            border: 4px solid #fff;
            object-fit: cover;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }

        .profile-name {
            font-weight: bold;
            font-size: 18px;
            margin-top: 10px;
        }

        .profile-title {
            color: #888;
            font-size: 14px;
        }

        .scroll-images {
            margin-top: 20px;
        }

        .card-title {
            font-size: 16px;
            font-weight: bold;
            color: #444;
            margin-bottom: 10px;
        }

        .scroll-images-container {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .scroll-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
        }

        .user-details {
            margin-top: 20px;
            font-size: 14px;
            color: #333;
        }

        .location-platform p {
            margin: 5px 0;
        }

        .stats {
            margin: 15px 0;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .stat .count {
            font-weight: bold;
            font-size: 16px;
        }

        .stat .label {
            color: #555;
            font-size: 13px;
        }

        .premium-upgrade {
            background-color: #f5f5f5;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 15px;
            font-size: 13px;
            line-height: 1.6;
        }

        .try-premium {
            margin-top: 5px;
            font-weight: bold;
        }

        .user-links {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 10px;
            text-align: right;
        }

        .link-item {
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            font-weight: 500;
            transition: background 0.3s;
            cursor: pointer;
        }

        .link-item:hover {
            background-color: #f1f1f1;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border-radius: 10px;
            width: 300px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .close {
            float: right;
            font-size: 20px;
            cursor: pointer;
        }

        .btn-premium {
            background-color: orange;
            border: none;
            padding: 10px 20px;
            color: #fff;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 10px;
        }

        /* Feed */
        .feed {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-top: 2px;

        }

        /* Create Post */
        .post-create {
            background-color: var(--white);
            border-radius: var(--border-radius);
            padding: 16px;
            box-shadow: var(--box-shadow);
            transition: var(--transition);
        }

        .post-create:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .post-create-top {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .post-create-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
        }

        .post-create-input {
            flex-grow: 1;
            padding: 12px 16px;
            border-radius: 30px;
            border: 1px solid var(--gray);
            background-color: white;
            cursor: pointer;
            font-size: 14px;
            transition: var(--transition);

        }

        .post-create-input:hover {
            background-color: white;
        }

        /* Posts */
        .post {
            background-color: var(--white);
            border-radius: var(--border-radius);
            padding: 16px;
            box-shadow: var(--box-shadow);
            transition: var(--transition);
        }

        .post:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);

        }

        .post-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .post-user {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .post-user-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--light-gray);
        }

        .post-user-info {
            display: flex;
            flex-direction: column;
        }

        .post-user-name {
            font-weight: 700;
            font-size: 16px;
        }

        .post-user-title {
            color: var(--gray);
            font-size: 13px;
        }

        .post-time {
            color: var(--gray);
            font-size: 12px;
            margin-top: 2px;
        }

        .post-content {
            margin-bottom: 12px;
            font-size: 15px;
            line-height: 1.5;
            white-space: pre-line;
        }

        .post-image {
            width: 100%;
            max-height: 500px;
            object-fit: contain;
            border-radius: 8px;
            margin-bottom: 12px;
            cursor: pointer;
            transition: var(--transition);
        }

        .post-image:hover {
            opacity: 0.9;
        }

        .post-stats {
            display: flex;
            justify-content: space-between;
            color: var(--gray);
            font-size: 13px;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }

        .post-actions {
            display: flex;
            justify-content: space-between;
            padding-top: 8px;
        }

        .post-action {
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--gray);
            font-size: 14px;
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 4px;
            transition: var(--transition);
            flex: 1;
            justify-content: center;

        }

        .post-action:hover {
            background-color: var(--light-gray);
            color: rgba(255, 87, 34, 0.9);
        }

        .post-action.liked {
            color: rgba(255, 87, 34, 0.9);
        }

        .post-action.liked i {
            font-weight: 900;
        }

        /* Follow Button */
        .follow-btn {
            background-color: rgba(255, 87, 34, 0.9);
            color: white;
            border: none;
            border-radius: 16px;
            padding: 4px 12px;
            font-weight: 500;
            font-size: 13px;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 5px;
            height: 30px;
        }

        .follow-btn:hover {
            background-color: #86888A;
            transform: translateY(-1px);
        }

        .follow-btn.following {
            background-color: var(--light-gray);
            color: var(--dark);
        }

        .follow-btn.following:hover {
            background-color: #e0e0e0;
        }

        /* Footer */
        footer {
            background-color: var(--white);
            padding: 40px 20px;
            font-size: 14px;
            color: var(--gray);
            margin-top: 40px;
            border-top: 1px solid #eee;
        }

        .footer-container {
            display: flex;
            justify-content: center;
            /* وسط الصفحة */
            gap: 60px;
            /* مسافة بين الأقسام */
            flex-wrap: wrap;
            /* يخليهم ينزلوا تحت بعض في الشاشات الصغيرة */
            max-width: 1000px;
            margin: auto;
            text-align: center;
        }

        .footer-section {
            min-width: 180px;
        }

        .footer-title {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 10px;
            color: #333;
        }

        .footer-section ul {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            /* خليهم ينزلوا تحت بعض لو الشاشة صغيرة */
            padding: 0;
            margin: 0;
            list-style: none;
            justify-content: center;

        }




        .footer-section ul li a {
            display: flex;
            /* يخلي الأيقونة والنص جنب بعض */
            align-items: center;
            /* يوسّطهم رأسيًا */
            gap: 8px;
            /* مسافة بين الأيقونة والنص */
            color: var(--gray);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-section ul li a:hover {
            color: rgba(255, 87, 34, 0.9);
            text-decoration: underline;
        }

        .footer-section ul li a i {
            color: rgba(255, 87, 34, 0.9);
            min-width: 16px;
        }

        .footer-bottom {

            padding: 6px 10px;
            margin-top: 10px;
            text-align: center;
            color: #aaaaaa;
            font-size: 12px;
            line-height: 1.4;

        }

        .footer-logo {
            margin-top: 15px;


        }

        .footer-logo img {
            height: 35px;
            margin-top: 6px;
        }


        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.3s;


        }



        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .modal-content {
            background-color: var(--white);
            border-radius: var(--border-radius);
            width: 100%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            animation: slideUp 0.3s;
        }

        @keyframes slideUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-header {
            display: flex;
            justify-content: center;
            /* الوساطة */
            align-items: center;
            margin-bottom: 20px;
            position: sticky;
            top: 0;
            background: white;
            padding: 10px 0;
            z-index: 1;
        }

        .modal-title {
            font-size: 20px;
            font-weight: 700;
            text-align: center;
            /* التأكد من أن النص في المنتصف */
            flex-grow: 1;
            /* يضمن أن العنوان يستحوذ على المساحة المتاحة */
        }

        .close {
            font-size: 24px;
            cursor: pointer;
            color: var(--gray);
            transition: var(--transition);
        }

        .close:hover {
            color: var(--dark);
            transform: rotate(90deg);
        }

        /* Message Form */
        .message-form {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .message-input {
            width: 100%;
            padding: 12px 16px;
            border-radius: 20px;
            border: 1px solid var(--gray);
            font-size: 14px;
            margin-bottom: 10px;
            resize: none;
        }

        .message-input:focus {
            outline: none;
            border-color: rgba(255, 87, 34, 0.9);
        }

        .send-message-btn {
            background-color: rgba(255, 87, 34, 0.9);
            color: white;
            border: none;
            border-radius: 20px;
            padding: 8px 16px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            float: right;
        }

        .send-message-btn:hover {
            background-color: rgba(255, 87, 34, 0.9);
        }

        /* Responsive */


        @media (max-width: 768px) {
            .nav-menu {
                width: 100%;
                justify-content: space-between;
            }

            .nav-item {
                padding: 8px 8px;
            }

            .post-actions {
                gap: 5px;
            }

            .post-action span {
                display: none;
            }
        }

        /* Loading Animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 87, 34, 0.9);
            border-radius: 50%;
            border-top-color: rgba(255, 87, 34, 0.9);
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        @media (max-width: 768px) {

            /* الحاوية الأساسية */
            .container {
                display: flex;
                flex-direction: row;
                flex-wrap: nowrap;
                justify-content: space-between;
                align-items: flex-start;
                gap: 10px;
                padding: 10px;
            }

            /* العمود الأيسر: البروفايل */
            .left {
                width: 22%;
                /* أصغر من الأول */
                margin-left: 5px;
                /* مسافة بسيطة من الشمال */
                padding: 0;
            }

            .left .profile {
                width: 100%;
            }

            /* العمود الأوسط: البوستات */
            .middle {
                width: 68%;
                /* مساحة مناسبة بعد تصغير اليسار */
                padding: 0;
                margin-right: 15px;
                /* مسافة واضحة من اليمين */
            }

            .middle .feed {
                width: 100%;
                padding: 15px;
                box-sizing: border-box;
                background: #fff;
                border-radius: 10px;
            }

            /* إلغاء أي تأثيرات جعلتهم تحت بعض */
            .left,
            .middle {
                float: none;
                display: block;
            }

            /* منع سكرول أفقي */
            body {
                overflow-x: hidden;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid d-flex justify-content-between align-items-center">

                <!-- Logo -->
                <a class="navbar-brand ms-0 me-auto" href="index.html" style="padding-left: 0;">
                    <img src="images/logo.png" alt="Logo" style="height: 6vh; margin-top: 6px; margin-left: 0;">
                </a>


                <!-- Links -->
                <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item active"><a href="index.html" class="nav-link">Home</a></li>
                        <li class="nav-item"><a href="About.html" class="nav-link">About</a></li>
                        <li class="nav-item"><a href="Personality home.html" class="nav-link">Personal Test</a></li>
                        <li class="nav-item"><a href="dashboard.php" class="nav-link">Job</a></li>
                        <li class="nav-item"><a href="interview.html" class="nav-link">Interview</a></li>
                        <li class="nav-item"><a href="training.html" class="nav-link">Training</a></li>
                        <li class="nav-item"><a href="reviews.html" class="nav-link">Reviews</a></li>
                    </ul>
                </div>

                <!-- Profile Button -->
                <a href="profile.php" class="nav-profile">
                    <i class="fas fa-user-circle"></i>
                    <span>Profile</span>
                </a>

                <!-- ضيفي ده في الهيدر أو فوق الفوتر -->
                <div id="google_translate_element" style="position: fixed; top: 10px; left: 200px; z-index: 9999; "></div>
            </div>
        </nav>




    </header>

    <!-- Main Content -->
    <div class="main-container">
        <div class="left-sidebar">
            <div class="profile-card">
                <div class="profile-bg"></div>
                <div class="profile-info">
                    <img src="<?php echo !empty($currentUser['profile_image']) ? 'uploads/' . $currentUser['profile_image'] : 'images/default-profile.png'; ?>" class="profile-img">
                    <div class="profile-name"><?php echo htmlspecialchars($currentUser['name']); ?></div>
                    <div class="profile-title"><?php echo htmlspecialchars($currentUser['job_title'] ?? 'No job title'); ?></div>
                </div>
            </div>



            <div class="user-details">
                <div class="location-platform">
                    <p class="location"><?php echo safe($currentUser['country']); ?></p>

                </div>

                <div class="stats">
                    <div class="stat">
                        <span class="count"><?php echo safe($currentUser['profile_views']); ?></span>
                        <span class="label">Profile Viewers</span>
                    </div>
                    <div class="stat">
                        <span class="count"><?php echo safe($currentUser['post_impressions']); ?></span>
                        <span class="label">Post Impressions</span>
                    </div>
                </div>



                <div class="premium-upgrade">
                    <p>Grow your business with a <br><strong>Premium</strong> Business Account</p>
                    <p class="try-premium">
                        • <a href="#" onclick="openPremiumModal()" style="color:#000; font-weight:bold; text-decoration: none;">
                            Retry for <span>EGP</span> <span class="icon">📦</span>
                        </a>
                    </p>
                </div>

                <div class="user-links">
                    <?php foreach ($userLinks as $link): ?>
                        <div class="link-item"><?php echo $link['icon'] . ' ' . safe($link['label']); ?></div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div id="premiumModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closePremiumModal()">&times;</span>
                <h3>Premium Trial</h3>
                <p>Enjoy extra features to boost your visibility and opportunities!</p>
                <button class="btn-premium">Start Trial Now</button>
            </div>
        </div>
        <!-- Feed -->
        <div class="feed">
            <!-- Create Post -->
            <div class="post-create">
                <div class="post-create-top">
                    <img src="<?php echo !empty($currentUser['profile_image']) ? 'uploads/' . $currentUser['profile_image'] : 'images/default-profile.png'; ?>" class="post-create-img">
                    <div class="post-create-input" onclick="document.getElementById('post-modal').style.display='flex'">Start a new post...</div>
                </div>
            </div>

            <!-- Posts -->
            <?php foreach ($posts as $post): ?>
                <div class="post" id="post-<?php echo $post['id']; ?>">
                    <!-- Inside the post loop -->
                    <div class="post-header">
                        <div class="post-user" data-user-id="<?php echo $post['user_id']; ?>">
                            <img src="<?php echo !empty($post['profile_image']) ? 'uploads/' . $post['profile_image'] : 'images/default-profile.png'; ?>" class="post-user-img">
                            <div class="post-user-info">
                                <div class="post-user-name"><?php echo htmlspecialchars($post['name']); ?></div>
                                <div class="post-user-title"><?php echo htmlspecialchars($post['job_title'] ?? 'No job title'); ?></div>
                                <div class="post-time"><?php echo date('j M Y \a\t H:i', strtotime($post['created_at'])); ?></div>
                            </div>
                        </div>

                        <!-- In your post header section -->
                        <?php if ($post['user_id'] != $_SESSION['user_id']): ?>
                            <button class="follow-btn <?php echo $post['is_following'] ? 'following' : ''; ?>"
                                data-user-id="<?php echo $post['user_id']; ?>"
                                data-following="<?php echo $post['is_following'] ? 'true' : 'false'; ?>">
                                <i class="fas fa-<?php echo $post['is_following'] ? 'user-check' : 'user-plus'; ?>"></i>
                                <span><?php echo $post['is_following'] ? 'Following' : 'Follow'; ?></span>
                            </button>
                        <?php endif; ?>
                    </div>

                    <div class="post-content">
                        <?php echo nl2br(htmlspecialchars($post['content'])); ?>
                    </div>

                    <?php if (!empty($post['image'])): ?>
                        <img src="uploads/<?php echo htmlspecialchars($post['image']); ?>" class="post-image" onclick="openImageModal('<?php echo htmlspecialchars($post['image']); ?>')">
                    <?php endif; ?>

                    <div class="post-stats">
                        <div class="post-likes">
                            <i class="fas fa-thumbs-up"></i>
                            <span><?php echo $post['like_count']; ?> likes</span>
                        </div>
                        <div class="post-comments">
                            <span><?php echo $post['comment_count']; ?> comments</span>
                        </div>
                    </div>

                    <div class="post-actions">
                        <div class="post-action like-btn <?php echo $post['is_liked'] ? 'liked' : ''; ?>" data-post-id="<?php echo $post['id']; ?>">
                            <i class="<?php echo $post['is_liked'] ? 'fas' : 'far'; ?> fa-thumbs-up"></i>
                            <span>Like</span>
                        </div>
                        <div class="post-action comment-btn" onclick="openCommentModal(<?php echo $post['id']; ?>)">
                            <i class="far fa-comment"></i>
                            <span>Comment</span>
                        </div>
                        <div class="post-action send-btn" onclick="openSendModal(<?php echo $post['id']; ?>, <?php echo $post['user_id']; ?>, '<?php echo htmlspecialchars($post['name']); ?>')">
                            <i class="fas fa-paper-plane"></i>
                            <span>Send</span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-section">

            <ul>
                <li><a href="help-center.html#faq"><i class="fas fa-question-circle"></i> FAQ</a></li>
                <li><a href="help-center.html#Community Guidelines"><i class="fas fa-users-cog"></i> Community Guidelines</a></li>
                <li><a href="help-center.html#Advertise"><i class="fas fa-bullhorn"></i> Advertise</a></li>
                <li><a href="help-center.html#terms"><i class="fas fa-file-contract"></i> Terms & Conditions</a></li>
            </ul>
        </div>


        <div class="footer-bottom">

            <div class="footer-logo m-3">
                <img src="images/logo.png" alt="Logo">
            </div>
            <p>&copy; 2025 YourCompany. All rights reserved.</p>
        </div>
    </footer>
    </footer>

    <!-- Post Modal -->
    <div id="post-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Create Post</div>
                <span class="close" onclick="document.getElementById('post-modal').style.display='none'">&times;</span>
            </div>
            <form id="post-form" method="POST" enctype="multipart/form-data" action="create_post.php" onsubmit="return validatePostForm()">
                <div class="post-create-top">
                    <img src="<?php echo !empty($currentUser['profile_image']) ? 'uploads/' . $currentUser['profile_image'] : 'images/default-profile.png'; ?>" class="post-create-img">
                    <div class="post-user-info">
                        <div class="post-user-name"><?php echo htmlspecialchars($currentUser['name']); ?></div>
                    </div>
                </div>

                <textarea name="content" id="post-content" placeholder="What do you want to say?" required style="width:100%; padding:12px; border:1px solid #ddd; border-radius:8px; margin-bottom:16px; min-height:120px; resize:none;"></textarea>

                <div style="margin-bottom:16px; display: flex; flex-direction: column; align-items: center;">
                    <label for="post-image" style="margin-bottom:8px; font-weight:600; text-align: center;">Add image (optional)</label>

                    <!-- زرار مخصص -->
                    <label for="post-image" style="cursor:pointer; background-color:rgba(255, 87, 34, 0.9) ; color: white; padding: 10px 20px; border-radius: 8px; font-weight: 600;">
                        Choose Image
                    </label>

                    <!-- الزرار الحقيقي مخفي -->
                    <input type="file" id="post-image" name="image" accept="image/*" style="display:none;" onchange="document.getElementById('file-name').textContent = this.files[0]?.name || 'No file chosen';">

                    <!-- نص اسم الملف -->
                    <span id="file-name" style="margin-top: 10px; font-size: 14px; color: #555;">No file chosen</span>
                </div>


                <div style="display: flex; justify-content: center; margin-top: 30px;">
                    <button type="submit" id="post-submit-btn" style="background-color: rgba(255, 87, 34, 0.9); color:white; border:none; padding:10px 20px; border-radius: 10px; font-weight:600; cursor:pointer; width:auto; justify-content: center; align-items: center;display: flex; text-align: center;">
                        <span id="post-btn-text">Post</span>
                        <span id="post-btn-loading" class="loading" style="display:none;"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Comment Modal -->
    <div id="comment-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Comments</div>
                <span class="close" onclick="closeCommentModal()">&times;</span>
            </div>
            <div id="comments-container"></div>

            <!-- Add Comment Form -->
            <form class="add-comment" method="POST" action="add_comment.php" onsubmit="return submitCommentForm(event)">
                <input type="hidden" name="post_id" id="comment-post-id">
                <div style="display:flex; gap:12px; margin-top:16px; align-items:center;">
                    <img src="<?php echo !empty($currentUser['profile_image']) ? 'uploads/' . $currentUser['profile_image'] : 'images/default-profile.png'; ?>" style="width:40px; height:40px; border-radius:50%; object-fit:cover;">
                    <div style="flex-grow:1; position:relative;">
                        <textarea name="content" placeholder="Add a comment..." required style="width:100%; padding:10px 16px; border-radius:20px; border:1px solid #ddd; resize:none; min-height:40px;"></textarea>
                        <button type="submit" style="position:absolute; right:8px; bottom:8px; background:none; border:none; color:rgba(255, 87, 34, 0.9); cursor:pointer;">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Send Message Modal -->
    <div id="send-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Send Message</div>
                <span class="close" onclick="closeSendModal()">&times;</span>
            </div>
            <div style="margin-bottom:16px;">
                <div style="font-weight:600; margin-bottom:8px;">To: <span id="send-to-name"></span></div>
                <div style="color:var(--gray); font-size:14px;">This message will be about the post you're viewing</div>
            </div>

            <form id="send-message-form" onsubmit="return submitMessageForm(event)">
                <input type="hidden" id="send-post-id">
                <input type="hidden" id="send-receiver-id">
                <textarea id="message-content" class="message-input" placeholder="Write your message..." required></textarea>
                <button type="submit" class="send-message-btn">
                    <span id="send-btn-text">Send</span>
                    <span id="send-btn-loading" class="loading" style="display:none;"></span>
                </button>
            </form>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="image-modal" class="modal" onclick="closeImageModal()">
        <div class="modal-content" style="max-width:90%; max-height:90%; background:transparent; box-shadow:none;" onclick="event.stopPropagation()">
            <span class="close" style="position:absolute; top:-40px; right:0; color:white; font-size:30px;" onclick="closeImageModal()">&times;</span>
            <img id="modal-image" src="" style="width:100%; height:auto; max-height:80vh; object-fit:contain; border-radius:8px;">
        </div>
    </div>

    <script>
        // Like Button
        document.querySelectorAll('.like-btn').forEach(button => {
            button.addEventListener('click', function() {
                const postId = this.getAttribute('data-post-id');
                const likeBtn = this;

                fetch('like_post.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `post_id=${postId}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const icon = likeBtn.querySelector('i');
                            const likesCount = likeBtn.closest('.post').querySelector('.post-likes span');

                            if (data.action === 'liked') {
                                likeBtn.classList.add('liked');
                                icon.classList.remove('far');
                                icon.classList.add('fas');
                                likesCount.textContent = (parseInt(likesCount.textContent) + 1) + ' likes';
                            } else {
                                likeBtn.classList.remove('liked');
                                icon.classList.remove('fas');
                                icon.classList.add('far');
                                likesCount.textContent = (parseInt(likesCount.textContent) - 1) + ' likes';
                            }
                        }
                    });
            });
        });

        // Follow Button
        // Update your follow button event handler
        document.querySelectorAll('.follow-btn').forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.getAttribute('data-user-id');
                const isFollowing = this.getAttribute('data-following') === 'true';
                const followBtn = this;

                fetch('follow_user.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `user_id=${userId}&action=${isFollowing ? 'unfollow' : 'follow'}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Toggle button state
                            const newState = !isFollowing;
                            followBtn.setAttribute('data-following', newState ? 'true' : 'false');
                            followBtn.classList.toggle('following', newState);

                            // Update icon and text
                            const icon = followBtn.querySelector('i');
                            const text = followBtn.querySelector('span');
                            icon.className = `fas fa-${newState ? 'user-check' : 'user-plus'}`;
                            text.textContent = newState ? 'Following' : 'Follow';
                        }
                    });
            });
        });

        // Comment Modal
        function openCommentModal(postId) {
            document.getElementById('comment-post-id').value = postId;
            document.getElementById('comment-modal').style.display = 'flex';
            loadComments(postId);
        }

        function closeCommentModal() {
            document.getElementById('comment-modal').style.display = 'none';
        }

        function loadComments(postId) {
            const container = document.getElementById('comments-container');
            container.innerHTML = '<p style="text-align:center; padding:20px 0;">Loading comments...</p>';

            fetch(`get_comments.php?post_id=${postId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length === 0) {
                        container.innerHTML = '<p style="text-align:center; color:var(--gray); padding:20px 0;">No comments yet</p>';
                    } else {
                        container.innerHTML = '';
                        data.forEach(comment => {
                            const commentDiv = document.createElement('div');
                            commentDiv.className = 'comment';
                            commentDiv.style.display = 'flex';
                            commentDiv.style.gap = '12px';
                            commentDiv.style.marginBottom = '16px';
                            commentDiv.style.paddingBottom = '16px';
                            commentDiv.style.borderBottom = '1px solid #eee';

                            commentDiv.innerHTML = `
                                <img src="${comment.profile_image ? 'uploads/'+comment.profile_image : 'images/default-profile.png'}" style="width:40px; height:40px; border-radius:50%; object-fit:cover;">
                                <div>
                                    <div style="font-weight:600;">${comment.name}</div>
                                    <div style="margin:4px 0;">${comment.content}</div>
                                    <div style="font-size:12px; color:var(--gray);">
                                        ${new Date(comment.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}
                                    </div>
                                </div>
                            `;

                            container.appendChild(commentDiv);
                        });
                    }
                });
        }

        function submitCommentForm(event) {
            event.preventDefault();
            const form = event.target;
            const formData = new FormData(form);

            fetch(form.action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        form.querySelector('textarea').value = '';
                        loadComments(document.getElementById('comment-post-id').value);
                    }
                });

            return false;
        }

        // Send Message Modal
        function openSendModal(postId, receiverId, receiverName) {
            document.getElementById('send-post-id').value = postId;
            document.getElementById('send-receiver-id').value = receiverId;
            document.getElementById('send-to-name').textContent = receiverName;
            document.getElementById('send-modal').style.display = 'flex';
        }

        function closeSendModal() {
            document.getElementById('send-modal').style.display = 'none';
            document.getElementById('message-content').value = '';
        }

        function submitMessageForm(event) {
            event.preventDefault();

            const postId = document.getElementById('send-post-id').value;
            const receiverId = document.getElementById('send-receiver-id').value;
            const content = document.getElementById('message-content').value;

            const sendBtnText = document.getElementById('send-btn-text');
            const sendBtnLoading = document.getElementById('send-btn-loading');

            sendBtnText.style.display = 'none';
            sendBtnLoading.style.display = 'inline-block';

            fetch('send_message.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `post_id=${postId}&receiver_id=${receiverId}&content=${encodeURIComponent(content)}`
                })
                .then(response => response.json())
                .then(data => {
                    sendBtnText.style.display = 'inline-block';
                    sendBtnLoading.style.display = 'none';

                    if (data.success) {
                        alert('Message sent successfully!');
                        closeSendModal();
                    } else {
                        alert('Error: ' + data.message);
                    }
                });

            return false;
        }

        // Image Modal
        function openImageModal(imageSrc) {
            document.getElementById('modal-image').src = 'uploads/' + imageSrc;
            document.getElementById('image-modal').style.display = 'flex';
        }

        function closeImageModal() {
            document.getElementById('image-modal').style.display = 'none';
        }

        // Post Form Validation
        function validatePostForm() {
            const content = document.getElementById('post-content').value.trim();
            const image = document.getElementById('post-image').value;

            if (content === '' && image === '') {
                alert('Please enter content or select an image');
                return false;
            }

            const postBtnText = document.getElementById('post-btn-text');
            const postBtnLoading = document.getElementById('post-btn-loading');

            postBtnText.style.display = 'none';
            postBtnLoading.style.display = 'inline-block';

            return true;
        }

        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';

                if (event.target.id === 'comment-modal') {
                    document.getElementById('comment-post-id').value = '';
                }
            }
        });
    </script>


    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                    pageLanguage: 'en',
                    includedLanguages: 'ar,en',
                    layout: google.translate.TranslateElement.InlineLayout.SIMPLE
                },
                'google_translate_element'
            );
        }
    </script>

    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</body>

</html>