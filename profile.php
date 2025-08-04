<?php
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get current user data
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $job_title = $_POST['job_title'];

    // Handle profile image upload
    if (!empty($_FILES['profile_image']['name'])) {
        $target_dir = "uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $file_extension = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        $new_filename = uniqid() . '.' . $file_extension;
        $target_file = $target_dir . $new_filename;

        // Verify the file is an image
        $check = getimagesize($_FILES['profile_image']['tmp_name']);
        if ($check !== false) {
            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
                // Delete old image if exists
                if ($user['profile_image'] && file_exists($target_dir . $user['profile_image'])) {
                    unlink($target_dir . $user['profile_image']);
                }
                $profile_image = $new_filename;
            }
        }
    } else {
        $profile_image = $user['profile_image'];
    }

    // Update database
    try {
        $stmt = $pdo->prepare("UPDATE users SET name = ?, job_title = ?, profile_image = ? WHERE id = ?");
        $stmt->execute([$name, $job_title, $profile_image, $_SESSION['user_id']]);

        $_SESSION['user_name'] = $name;
        $_SESSION['success'] = "Profile updated successfully!";
        header("Location: profile.php");
        exit();
    } catch (PDOException $e) {
        $error = "Error updating profile: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile | HYRNET</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #0077B5;
            --primary-dark: #006097;
            --primary-light: #E6F2F8;
            --secondary: #00A0DC;
            --dark: #313335;
            --darker: #1C1F21;
            --gray: #86888A;
            --light-gray: #EEF3F8;
            --lighter-gray: #F8FAFC;
            --white: #FFFFFF;
            --border-radius: 12px;
            --border-radius-sm: 8px;
            --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            --box-shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.12);
            --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        body {
            background-color: white;
            color: var(--dark);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
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

        /* Search bar */
        .search-bar {
            flex-grow: 1;
            position: relative;
            max-width: 380px;
        }

        .search-bar input {
            width: 100%;
            padding: 10px 16px 10px 42px;
            border-radius: var(--border-radius);
            border: 1px solid var(--light-gray);
            background-color: var(--lighter-gray);
            font-size: 14px;
            transition: var(--transition);
            color: var(--dark);
            font-weight: 500;
        }

        .search-bar input::placeholder {
            color: var(--gray);
            font-weight: 400;
        }

        .search-bar input:focus {
            outline: none;
            background-color: var(--white);
            box-shadow: 0 0 10px 3px rgba(255, 87, 34, 0.9);
            /* تأثير التوهج */

            ;
            border-color: rgba(255, 87, 34, 0.9);
        }

        .search-bar i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
            font-size: 15px;
        }


        .navbar {
            position: absolute;
            top: 0;
            width: 100%;
            z-index: 1000;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            font-size: 1rem;
            font-family: 'Roboto', sans-serif !important;
            padding: 8px 16px;
            height: 68px;
            display: flex;
            flex-wrap: wrap;
        }

        .navbar-nav {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            overflow: hidden;
            flex-wrap: wrap;
            max-width: 100%;
            overflow-x: hidden;
            flex-grow: 1;
            margin: 0 auto;
        }

        .navbar-nav .nav-link {
            color: #333;
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


        /* Main content */
        .dashboard-container {
            max-width: 1200px;
            margin: 84px auto 32px;
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 24px;
            padding: 0 24px;
        }

        /* Sidebar */
        .sidebar {
            position: sticky;
            top: 84px;
            height: fit-content;
        }

        /* Profile card */
        .profile-card {
            background-color: var(--white);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--box-shadow);
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .profile-bg {
            height: 72px;
            background: linear-gradient(135deg, rgba(255, 87, 34, 0.9));
        }

        .profile-info {
            padding: 24px 16px 16px;
            position: relative;
        }



        .profile-img {
            width: 88px;
            height: 88px;
            border-radius: 50%;
            border: 4px solid var(--white);
            object-fit: cover;
            position: absolute;
            top: -44px;
            left: 50%;
            transform: translateX(-50%);
            box-shadow: var(--box-shadow);
            transition: var(--transition);
        }

        .profile-img:hover {
            transform: translateX(-50%) scale(1.05);
        }

        .profile-default {
            width: 88px;
            height: 88px;
            border-radius: 50%;
            border: 4px solid var(--white);
            background-color: var(--light-gray);
            position: absolute;
            top: -44px;
            left: 50%;
            transform: translateX(-50%);
            box-shadow: var(--box-shadow);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray);
            font-size: 36px;
        }

        .profile-name {
            margin-top: 36px;
            font-weight: 700;
            font-size: 18px;
            color: var(--darker);
        }

        .profile-title {
            color: var(--gray);
            font-size: 14px;
            margin: 8px 0 16px;
            padding: 0 10px;
            line-height: 1.4;
        }

        .profile-stats {
            display: flex;
            justify-content: space-around;
            border-top: 1px solid var(--light-gray);
            padding-top: 16px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-weight: 700;
            color: rgba(255, 87, 34, 0.9);
            font-size: 16px;
        }

        .stat-label {
            font-size: 12px;
            color: var(--gray);
            margin-top: 4px;
        }

        /* Navigation */
        .sidebar nav {
            background-color: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 16px;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .sidebar nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: var(--gray);
            font-weight: 500;
            border-radius: var(--border-radius-sm);
            transition: var(--transition);
        }

        .sidebar nav a:hover {
            background-color: white;
            color: black;
        }

        .sidebar nav a.active {
            background-color: white;
            color: black;
        }

        .sidebar nav a i {
            width: 24px;
            text-align: center;
        }

        /* Main content */
        .main-content {
            background-color: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 32px;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .main-content h1 {
            font-size: 24px;
            margin-bottom: 24px;
            color: var(--darker);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .main-content h1 i {
            color: rgba(255, 87, 34, 0.9);
        }

        /* Alerts */
        .alert {
            padding: 12px 16px;
            border-radius: var(--border-radius-sm);
            margin-bottom: 24px;
            font-weight: 500;
        }

        .alert.success {
            background-color: #E6F7EE;
            color: rgba(255, 87, 34, 0.9);
            border: 1px solid #B8EFCC;
        }

        .alert.error {
            background-color: #FBE7E8;
            color: #A30D11;
            border: 1px solid #F3A8AA;
        }

        /* Form styles */
        .profile-form {
            max-width: 600px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--darker);
        }

        .form-group input[type="text"],
        .form-group input[type="file"] {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--light-gray);
            border-radius: var(--border-radius-sm);
            font-size: 15px;
            transition: var(--transition);
        }

        .form-group input[type="text"]:focus {
            outline: none;
            border-color: rgba(255, 87, 34, 0.9);
            box-shadow: 0 0 0 3px rgba(0, 119, 181, 0.15);
        }

        .current-image {
            font-size: 13px;
            color: var(--gray);
            margin-top: 8px;
        }

        /* Button */
        .btn-update {
            background-color: rgba(255, 87, 34, 0.9);
            color: white;
            border: none;
            border-radius: var(--border-radius);
            padding: 12px 24px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-update:hover {
            background-color: rgba(255, 87, 34, 0.9);

            box-shadow: 0 0 10px 3px rgba(255, 87, 34, 0.9);
            /* تأثير التوهج */
            transform: scale(1.05);
        }

        /* Responsive design */
        @media (max-width: 992px) {
            .dashboard-container {
                grid-template-columns: 1fr;
                padding: 0 20px;
            }

            .sidebar {
                position: static;
                order: 2;
            }

            .profile-card {
                display: grid;
                grid-template-columns: 100px 1fr;
                text-align: left;
            }

            .profile-bg {
                display: none;
            }

            .profile-info {
                padding: 20px;
            }

            .profile-img,
            .profile-default {
                position: relative;
                top: auto;
                left: auto;
                transform: none;
                width: 80px;
                height: 80px;
                margin-right: 20px;
            }

            .profile-name {
                margin-top: 0;
            }
        }

        @media (max-width: 768px) {
            .header-container {
                padding: 0 16px;
            }

            .logo-img {
                height: 32px;
                margin-right: 16px;
            }

            .nav-item {
                padding: 8px 12px;
            }

            .nav-item i {
                font-size: 20px;
            }

            .main-content {
                padding: 24px;
            }

            .main-content h1 {
                font-size: 20px;
            }
        }

        @media (max-width: 768px) {
            .dashboard-container {
                display: flex;
                flex-direction: row;
                /* لجعلهم جنب بعض */
                justify-content: space-between;
                /* مسافة بين العناصر */
                gap: 20px;
                /* فراغ بين الـ sidebar و الـ main-content */
            }

            .sidebar {
                width: 40%;
                /* حجم أصغر للـ sidebar */
                flex-shrink: 0;
                /* ما يتقلصش */
            }

            .main-content {
                width: 55%;
                /* حجم أصغر للـ main-content */
                flex-shrink: 0;
                /* ما يتقلصش */
            }
        }
    </style>
</head>

<body>

    <!-- Google Translate -->
    <div id="google_translate_element" style="position: fixed; top: 10px; left: 200px; z-index: 9999;"></div>



    <!-- Main Content -->
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="profile-card">
                <div class="profile-bg"></div>
                <div class="profile-info">
                    <?php if ($user['profile_image']): ?>
                        <img src="uploads/<?php echo htmlspecialchars($user['profile_image']); ?>" class="profile-img" alt="Profile Image">
                    <?php else: ?>
                        <div class="profile-default">
                            <i class="fas fa-user"></i>
                        </div>
                    <?php endif; ?>
                    <div class="profile-name"><?php echo htmlspecialchars($user['name']); ?></div>
                    <div class="profile-title"><?php echo htmlspecialchars($user['job_title'] ?? 'No job title specified'); ?></div>

                </div>
            </div>

            <nav>
                <a href="dashboard.php" class="active"><i class="fas fa-user-edit"></i> Edit Profile</a>
                <a href="#"><i class="fas fa-cog"></i> Account Settings</a>
                <a href="#"><i class="fas fa-lock"></i> Privacy</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </nav>
        </div>

        <!-- Main Content Area -->
        <div class="main-content">
            <h1><i class="fas fa-user-edit"></i> Edit Profile</h1>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert success">
                    <?php echo $_SESSION['success'];
                    unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <div class="alert error"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data" class="profile-form">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="job_title">Job Title</label>
                    <input type="text" id="job_title" name="job_title" value="<?php echo htmlspecialchars($user['job_title'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label for="profile_image" style="margin-bottom:8px; font-weight:600; text-align: center; display:block;">Upload your CV</label>

                    <!-- زرار مخصص -->
                    <label for="profile_image" style="cursor:pointer; background-color:rgba(255, 87, 34, 0.9); color: white; padding: 8px 16px; border-radius: 8px; font-weight: 600; display:block; width: fit-content; margin: 0 auto;">
                        Choose Image
                    </label>

                    <input type="file" id="profile_image" name="image" accept="image/*" style="display:none;" onchange="document.getElementById('file-name').textContent = this.files[0]?.name || 'No file chosen';">

                    <!-- نص اسم الملف -->
                    <span id="file-name" style="margin-top: 10px; font-size: 14px; color: #555; display: block; text-align: center;">No file chosen</span>

                </div>
                <?php if ($user['profile_image']): ?>
                    <p class="current-image" style="display: block; width: fit-content; margin: 10px auto; text-align: center;">
                        Current: <?php echo htmlspecialchars($user['profile_image']); ?>
                    </p>
                <?php endif; ?>


        </div>

        <button type="submit" class="btn-update"><i class="fas fa-save"></i> Save Changes</button>
        </form>
    </div>
    </div>


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