<?php
session_start();  // Memulai session
require_once 'config/koneksi.php';  // Koneksi database

// Cek apakah form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "Email dan Password harus diisi!";
    } else {
        // Query untuk memeriksa apakah pengguna ada di database
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $koneksi->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            // Simpan data user di session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];  // Menyimpan username ke session
            $_SESSION['email'] = $user['email'];        // Menyimpan email ke session

            // Redirect ke dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Email atau Password salah!";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>

    <style>
      @import url("https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap");
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Poppins", sans-serif;
      }
      html,
      body {
        display: grid;
        height: 100%;
        width: 100%;
        place-items: center;
        background: #f2f2f2;
      }
      .wrapper {
        width: 380px;
        background: #fff;
        border-radius: 15px;
        box-shadow: 0px 15px 20px rgba(0, 0, 0, 0.1);
      }
      .wrapper .title {
        font-size: 35px;
        font-weight: 600;
        text-align: center;
        line-height: 100px;
        color: #fff;
        background: linear-gradient(109.6deg, rgb(120, 143, 251) 11.2%, rgb(133, 235, 255) 91.1%);
        border-radius: 15px 15px 0 0;
      }
      .wrapper form {
        padding: 10px 30px 50px 30px;
      }
      .wrapper form .field {
        height: 50px;
        width: 100%;
        margin-top: 20px;
        position: relative;
      }
      .wrapper form .field input {
        height: 100%;
        width: 100%;
        outline: none;
        font-size: 17px;
        padding-left: 20px;
        border: 1px solid lightgrey;
        border-radius: 25px;
        transition: all 0.3s ease;
      }
      .wrapper form .field input:focus,
      form .field input:valid {
        border-color: #4158d0;
      }
      .wrapper form .field label {
        position: absolute;
        top: 50%;
        left: 20px;
        color: #999999;
        font-weight: 400;
        font-size: 17px;
        pointer-events: none;
        transform: translateY(-50%);
        transition: all 0.3s ease;
      }
      form .field input:focus ~ label,
      form .field input:valid ~ label {
        top: 0%;
        font-size: 16px;
        color: #4158d0;
        background: #fff;
        transform: translateY(-50%);
      }
      form .content {
        display: flex;
        width: 100%;
        height: 50px;
        font-size: 16px;
        align-items: center;
        justify-content: space-around;
      }
      form .content .checkbox {
        display: flex;
        align-items: center;
        justify-content: center;
      }
      form .content input {
        width: 15px;
        height: 15px;
        background: red;
      }
      form .content label {
        color: #262626;
        user-select: none;
        padding-left: 5px;
      }
      form .content .pass-link {
        color: "";
      }
      form .field input[type="submit"] {
        color: #fff;
        border: none;
        padding-left: 0;
        margin-top: -10px;
        font-size: 20px;
        font-weight: 500;
        cursor: pointer;
        background: linear-gradient(109.6deg, rgb(120, 143, 251) 11.2%, rgb(133, 235, 255) 91.1%);
        transition: all 0.3s ease;
      }
      form .field input[type="submit"]:active {
        transform: scale(0.95);
      }
      form .signup-link {
        color: #262626;
        margin-top: 20px;
        text-align: center;
      }
      form .pass-link a,
      form .signup-link a {
        color: #4158d0;
        text-decoration: none;
      }
      form .pass-link a:hover,
      form .signup-link a:hover {
        text-decoration: underline;
      }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="title">Login Form</div>

        <!-- Tampilkan error jika login gagal -->
        <?php if (isset($error)): ?>
            <div style="color: red; text-align: center;">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <div class="field">
                <input type="email" name="email" required />
                <label>Email Address</label>
            </div>
            <div class="field">
                <input type="password" name="password" required />
                <label>Password</label>
            </div>
            <div class="content">
                <div class="checkbox">
                    <input type="checkbox" id="remember-me" />
                    <label for="remember-me">Remember me</label>
                </div>
                <div class="pass-link">
                    <a href="#">Forgot password?</a>
                </div>
            </div>
            <div class="field" >
                <input type="submit" value="Login"   />
            </div>
            <div class="signup-link">
                Not a member? <a href="register.php">Signup now</a>
            </div>
        </form>
    </div>
</body>
</html>
