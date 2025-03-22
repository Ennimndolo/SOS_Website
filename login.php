<?php
// login.php - Handling user login (with role-based logic)

include 'db_connection.php'; // Include database connection file
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Use prepared statements to prevent SQL injection
    $query = "SELECT * FROM students WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        $user = mysqli_fetch_assoc($result);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['student_id']; // Use student_id
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            $_SESSION['logged_in'] = true;

            if ($user['role'] == 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: dashboard.php");
            }
            exit();
        } else {
            echo "<script>alert('Invalid username or password.');</script>";
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt); // Close the statement
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Login</title>
    <link rel="stylesheet" href="regi.css">
    <style>
        #loginNotification {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            border-radius: 5px;
            display: none;
            z-index: 1000;
        }

        #loginNotification.show {
            display: block;
            opacity: 1;
            transition: opacity 0.5s ease-in-out;
        }

        #loginNotification.fade-out {
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }
          /* footer section */
.footer{
    display: grid;
    grid-template-columns: 1fr 1fr 1fr ;
    column-gap: 40px;
    justify-content: center;
    margin-left: 10%;
    background-color: #f4f4f9;
    padding-bottom: 30px;
    border-bottom: 40px solid green;
    margin-top: 2em;
  }
  
  .logo-footer{
    border-left: 1px solid green;
    border-right: 1px solid green;
    padding-left: 20px;
   
  }
  .location h1{
  color: dodgerblue;
  }
  .quick-links{
    display: flex;
    flex-direction: column;
    padding-left: 20px;
    border-left: 1px solid green;
    border-right: 1px solid green;
    margin-right: 10%;
  }
  .quick-links h1{
    color: dodgerblue;
  }
  .quick-links a{
    text-decoration: none;
    line-height: 2em;
    color: dodgerblue;
  }
  .quick-links a:hover{
    text-decoration: underline;
  }
  @media ( max-width: 1000px) {
      .footer{
       display: flex;
       margin-top: 2em;
       flex-direction: column;
       row-gap: 2em;
      }
      .logo-footer{
          width: 100%;
      }
      .location{
          width: 100%;
          border-left: 1px solid green;
          border-right: 1px solid green;
          padding-left: 20px;
      }
      .quick-links{
          width: 100%;
      }
  }


    </style>
</head>
<body>
<div class="head">
    <header>
        <nav style="background-color: dodgerblue;">
            <div class="logo">
                <img src="sos_logo.png" style="height: 3em; width: 7em; border-radius: 10px;">
            </div>
            <div class="hamburger" id="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <ul class="nav-links" id="nav-links">
                <li><a href="#">Become A Partner</a></li>
                <li><a href="index.html">Home</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
                <li><a href="#">Donate</a></li>
            </ul>
        </nav>
    </header>
</div>
<div class="container-form">
    <form method="POST">
        <label for="username">Username</label>
        <input type="text" name="username" required><br>

        <label for="password">Password</label>
        <input type="password" name="password" required><br>

        <button type="submit">Login</button>
        <a href="register.php">Not Registered? Click Here</a>
    </form>
</div>

<div id="loginNotification">
    <span id="notificationMessage"></span>
</div>

<script>
    function showLoginNotification() {
        var notification = document.getElementById("loginNotification");
        var message = document.getElementById("notificationMessage");

        if (!sessionStorage.getItem("notificationShown")) {
            message.innerHTML = "You have logged in successfully!";
            notification.classList.add("show");

            setTimeout(function() {
                notification.classList.add("fade-out");
                setTimeout(function() {
                    notification.classList.remove("show", "fade-out");
                }, 500);
            }, 3000);

            sessionStorage.setItem("notificationShown", "true");
        }
    }

    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
        showLoginNotification();
        <?php unset($_SESSION['logged_in']); // Clear the session variable ?>
    <?php endif; ?>

    const hamburger = document.getElementById('hamburger');
    const navLinks = document.getElementById('nav-links');

    hamburger.addEventListener('click', () => {
        navLinks.classList.toggle('active');
    });
</script>
<div class="footer">
    
    <div class="logo-footer">
     <img src="sos_logo.png" alt="logo"><br>
     
     <p>
         Partener with SOS Vocational Training centre, You will never regret it! 
     </p>

    </div>  
    <div class="location">
     <h1>Our Address</h1>
     SOS Vocational Training Centre <br>
     Lilongwe programme<br>
     Box 3359<br>
     Area 22<br>
     Along M1 Road, Behind Parteners in Hope Hospital<br>
     Lilongwe, Malawi
     
    </div>
    <div class="quick-links">
     <h1>
     Quick Links
    </h1>
     <a href="Partner.html">Become a Partener</a>
     <a href="#contact-fomr">Contact Us</a>
     <a href="register.html">Apply for the course</a>
     <a href="login.html">Login as Student </a>
    

    </div>

<script src="scripts.js"></script>
</body>

</html>
