<?php
// Zakiyah Al-Thunayyan 2240005958

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include("../includes/Connection.php");

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // التثبت من وجود البيانات لتفادي أخطاء الـ Undefined array key
    $username = isset($_POST['admin_user']) ? trim($_POST['admin_user']) : '';
    $password = isset($_POST['admin_pass']) ? trim($_POST['admin_pass']) : '';

    if (!empty($username) && !empty($password)) {

        $sql = "SELECT * FROM admin WHERE A_UserName = ? AND A_Password = ?";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $username, $password);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            if ($result && mysqli_num_rows($result) == 1) {

                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_user'] = $username;

                header("Location: AdminPage.php");
                exit();

            } else {
                $error = "Invalid username or password";
            }

            mysqli_stmt_close($stmt);
        } else {
            $error = "Database query error";
        }

    } else {
        $error = "Please fill in all fields";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>WeCrochet Login</title>
    <link rel="stylesheet" href="../Styles/LogIn_Admin.css">
</head>

<body>

<div class="container">

    <div class="left-panel">

        <h1>WeCrochet</h1>

        <p class="welcome">
            <img src="../images/logo.1.jpeg"
                 alt="WeCrochet Logo"
                 class="logo">

            Welcome Admin <br>
            Manage your store and control your content easily.
        </p>

    </div>

    <div class="right-panel">

        <h2>Login</h2>

        <?php if (!empty($error)) { ?>
            <p style="color:red; font-weight: bold;"><?php echo htmlspecialchars($error); ?></p>
        <?php } ?>

        <form action=""
              method="POST"
              id="loginForm">

            <input type="text"
                   id="username"
                   name="admin_user"
                   placeholder="Username"
                   class="input-box" required>

            <input type="password"
                   id="password"
                   name="admin_pass"
                   placeholder="Password"
                   class="input-box" required>

            <button type="submit" class="login-btn">
                Login
            </button>

        </form>

    </div>

</div>

<script src="../js/login.js"></script>

</body>
</html>
    <link rel="stylesheet" href="../Styles/LogIn_Admin.css">
