<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="style.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    html,
    body {
      height: 100%;
    }

    body {
      background: url('photo/photo_2025-04-12_23-23-57.jpg') no-repeat center center fixed;
      background-size: cover;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .container {
      width: 100%;
      max-width: 800px;
      animation: fadeIn 1s ease forwards;
    }

    .form-box {
      background: white;
      display: flex;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
      flex-direction: row-reverse;
    }

    .left-side {
      width: 50%;
      position: relative;
    }

    .custom-img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }

    .overlay-text {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      color: white;
      background: rgba(0, 0, 0, 0.4);
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 20px;
      text-align: center;
    }

    .overlay-text h2 {
      margin-bottom: 10px;
      font-size: 22px;
      color: white;
    }

    .overlay-text p {
      font-size: 14px;
    }

    .right-side {
      width: 50%;
      padding: 20px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .right-side h2 {
      margin-bottom: 20px;
      color: #333;
      text-align: center;
    }

    form {
      display: flex;
      flex-direction: column;
    }

    input {
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .forgot {
      color: rgba(255, 87, 34, 0.9);
      font-size: 14px;
      margin-bottom: 10px;
      text-align: right;
      display: block;
    }

    button {
      padding: 10px;
      background-color: rgba(255, 87, 34, 0.9);
      color: white;
      border: none;
      border-radius: 4px;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    button:hover {
      background-color: rgba(255, 87, 34, 0.9);
      box-shadow: 0 0 10px 3px rgba(255, 87, 34, 0.9);
      transform: scale(1.05);
    }

    form p {
      margin-top: 10px;
      font-size: 14px;
      text-align: center;
    }

    form a {
      color: rgba(255, 87, 34, 0.9);
      text-decoration: none;
    }

    form a:hover {
      color: rgba(255, 87, 34, 0.9);
    }

    .error {
      background-color: #f8d7da;
      color: #721c24;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #f5c6cb;
      border-radius: 4px;
      text-align: center;
    }

    @keyframes fadeIn {
      0% {
        opacity: 0;
        transform: translateY(-30px);
      }

      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="form-box">
      <div class="left-side">
        <img src="photo/photo_2025-04-13_01-14-56.jpg" class="custom-img" />
        <div class="overlay-text">
          <h2>Welcome to HYRNET</h2>
          <p>Your Career Mirror</p>
        </div>
      </div>
      <div class="right-side">
        <h2>Login</h2>

        <?php


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          $email = $_POST['email'];
          $password = $_POST['password'];

          $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
          $stmt->execute([$email]);
          $user = $stmt->fetch();

          if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: index.html");
            exit();
          } else {
            echo "<div class='error'>Invalid email or password</div>";
          }
        }
        ?>
        <form method="POST">
          <input type="email" name="email" placeholder="Email" required />
          <input type="password" name="password" placeholder=" Password" required />
          <a href="#" class="forgot">?Forgot your password </a>
          <button type="submit">login</button>
          <p>Don't have an account? <a href="signup.php">Sign-up</a></p>
        </form>
      </div>
</body>

</html>