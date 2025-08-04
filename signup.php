<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> create new account </title>
  <link rel="stylesheet" href="style.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Roboto', sans-serif !important;
    }

    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-image: url('photo/photo_2025-04-12_23-23-57.jpg');
      /* غيري المسار حسب مكان الصورة */
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
    }

    .container {
      background: white;
      padding: 30px;
      border-radius: 10px;
      width: 100%;
      max-width: 500px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
      animation: fadeIn 1s ease forwards;
    }

    .form h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin: 10px 0 5px;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="tel"],
    input[type="date"],
    select {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 6px;
      margin-bottom: 10px;
    }

    .row {
      display: flex;
      gap: 10px;
    }

    .column {
      flex: 1;
    }

    .gender-group {
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
    }

    .gender-group label {
      font-size: 14px;
    }

    button {
      width: 100%;
      padding: 12px;
      background-color: rgba(255, 87, 34, 0.9);
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
      margin-top: 10px;
    }

    button:hover {
      background-color: rgba(255, 87, 34, 0.9);
      box-shadow: 0 0 10px 3px rgba(255, 87, 34, 0.9);
      transform: scale(1.05);
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


    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $name = $_POST['fullname'];
      $email = $_POST['email'];
      $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
      $mobile = $_POST['mobile'];
      $birthdate = $_POST['birthdate'];
      $gender = $_POST['gender'];
      $address = $_POST['address'];

      try {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, mobile, birthdate, gender, address)
                               VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $password, $mobile, $birthdate, $gender, $address]);

        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['user_name'] = $name;
        header("Location: index.html");
        exit();
      } catch (PDOException $e) {
        echo "<div class='error'>خطأ: " . $e->getMessage() . "</div>";
      }
    }
    ?>

    <div class="container">
      <form action="signup.php" method="POST" class="form">
        <h2>create new account</h2>

        <label for="fullname">Full Name</label>
        <input type="text" name="fullname" id="fullname" placeholder="Enter your full name" required>

        <label for="email">Email Address</label>
        <input type="email" name="email" id="email" placeholder="Enter your email" required>

        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Enter your password" required>
        <div class="row">
          <div class="column">
            <label for="mobile">Mobile Number</label>
            <input type="tel" name="mobile" id="mobile" placeholder="Enter your mobile number" required>
          </div>
          <div class="column">
            <label for="birthdate">Birth Date</label>
            <input type="date" name="birthdate" id="birthdate" required>
          </div>
        </div>

        <label>Gender</label>
        <div class="gender-group">
          <label><input type="radio" name="gender" value="male" checked> Male</label>
          <label><input type="radio" name="gender" value="female"> Female</label>
          <label><input type="radio" name="gender" value="prefer_not_to_say"> Prefer not to say</label>
        </div>

        <label for="address">Address</label>
        <input type="text" name="address" id="address" placeholder="Enter your address" required>


        <button type="submit" name="save">Submit</button>

      </form>
    </div>
</body>

</html>