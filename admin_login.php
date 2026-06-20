<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = sprintf("SELECT * FROM tbladmin
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    
    if ($user) {
        
        if (password_verify($_POST["password"], $user["password_hash"])) {
            
            session_start();
            
            session_regenerate_id();
            
            $_SESSION["user_id"] = $user["id"];
            
            header("Location: Dashboard_admin.php");
            exit;
        }
    }
    
    $is_invalid = true;
}
?>

<!DOCTYPE html>
<!-- Coding by CodingLab | www.codinglabweb.com-->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Login and Signup Form</title>

    <!-- CSS -->
    <link rel="stylesheet" href="css/css/style.css">
    <style>
        body{
            background-image: url('./img/login/background.png');
            background-size: cover;  
        }
    </style>
            
    <!-- Boxicons CSS -->
</head>
<body>
   
    <section class="container forms">
        <!-- Login Form -->
        <div class="form login">
            <div class="form-content">
                <header>Login Admin</header>
                <p class="text">Hey, Enter your details to get login in to your account</p>

                <div>
                <?php if ($is_invalid): ?>
                 <em class="em">Invalid login</em>
                 <?php endif; ?>
                <form method="post" action="admin_login.php"></div>
                    
                    <!-- Input fields for login -->
                    <div class="field input-field">
                        <input type="email" name="email" id="email" required class="input"
                        value="<?= htmlspecialchars($_POST["email"] ?? "") ?>" placeholder="Email"/>
                        
                    </div>
                    <div class="field input-field">
                        <input type="password" id="password" name="password" required class="password" placeholder="password">
                        <i class='bx bx-hide eye-icon'></i>
                    </div>
                    
                    <!-- Submit button -->
                    <div class="field button-field">
                        <button type="submit">Login</button>
                    </div>
                </form>

                <!-- Social login icons -->
                <div class="log_con">
                    <div class="icons_log">
                        <div class="icons_log_pic">
                            <img src="img/login/social_10124147.png" alt=""><p class="text3">Google</p>
                        </div>
                    </div>
                    <div class="icons_log">
                        <div class="icons_log_pic">
                            <img src="img/login/mac-os-logo_2235.png" alt=""><p class="text3">Apple</p>
                        </div>
                    </div>
                    <div class="icons_log">
                        <div class="icons_log_pic">
                            <img src="img/login/tik-tok_3046120.png" alt=""><p class="text3">Tik Tok</p>
                        </div>
                    </div>
                </div>
                
                <!-- Signup link -->
                <div class="form-link">
                    <span>Don't have an account? <a href="#" class="link signup-link text_a">Sign up</a></span>
                </div>
            </div>
        </div>

        <!-- Signup Form -->
        <div class="form signup">
            <div class="form-content">
                <header>Signup Admin</header>
                <p class="text">Hey, Enter your details to get Signup in to your account</p>
                <form action="process-signup_admin.php" method="post" id="signup" novalidate>
                    <!-- Input fields for signup -->
                    <div class="field input-field">
                        <input type="text" id="name" name="name" required class="input" placeholder="name">
                    </div>
                    
                    <div class="field input-field">
                        <input type="email" id="email" name="email" required placeholder="Email" class="input">
                    </div>
                    <div class="field input-field">
                        <input type="password" id="password" name="password" required placeholder="Create password" class="password">
                    </div>
                    <div class="field input-field">
                    
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Repeat password">
                    </div>
                    
                        
            
        </div>
                    
                    
                    <!-- Submit button -->
                    <div class="field button-field">
                        <button type="submit">Signup</button>
                    </div>
                </form>

                <!-- Login link -->
                <div class="form-link">
                    <span>Already have an account? <a href="#" class="link login-link text_a">Login</a></span>
                </div>
            </div>
        </div>
    </section>

    <script src="js/login.js"></script>
</body>
</html>
