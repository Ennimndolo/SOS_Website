<?php
// register.php - Updated form with profile picture input and role selection

include 'db_connection.php';  // Database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);  // Encrypt password
    $role = $_POST['role'];  // Get selected role (student or admin)
    
    // Handle profile picture upload
    $profile_pic = 'default-profile.png';  // Default profile picture
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        $profile_pic_name = $_FILES['profile_pic']['name'];
        $profile_pic_temp = $_FILES['profile_pic']['tmp_name'];
        $profile_pic_ext = pathinfo($profile_pic_name, PATHINFO_EXTENSION);
        
        // Check if the uploaded file is an image
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array(strtolower($profile_pic_ext), $allowed_extensions)) {
            $profile_pic = uniqid() . '.' . $profile_pic_ext;
            move_uploaded_file($profile_pic_temp, 'uploads/' . $profile_pic);  // Move the uploaded file to the 'uploads' folder
        } else {
            echo "Invalid file type. Only images are allowed.";
            exit();
        }
    }

    // Set registration status and period
    $registration_status = 'Not Registered';  // Default status
    $registration_period = 'TBD';  // Default period

    // Insert student data into the database
    $query = "INSERT INTO students (full_name, email, phone_number, username, password, registration_status, registration_period, profile_pic, role) 
              VALUES ('$full_name', '$email', '$phone_number', '$username', '$password', '$registration_status', '$registration_period', '$profile_pic', '$role')";
    
    if (mysqli_query($conn, $query)) {
        echo "Registration successful!";
        header("Location: login.php");  // Redirect to login page
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Registration</title>
    <link rel="stylesheet" type="text/css" href="regi.css">

<style>
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
                <li><a href="#" style="background-color: grey; border-radius: 5px; padding: 5px;">Become A Partener</a></li>
                <li><a href="#">Apply for the course</a></li>
                <li><a href="edu-system.html">Education_System</a></li>
                <li><a href="login.php">Login</a></li>

            </ul>
        </nav>
    </header>
    <form method="POST" enctype="multipart/form-data">
        <h1 class="regi-h1 ">Register Here</h1>

        <input type="text" name="full_name" required placeholder="Full Name"><br>
    
        <input type="email" name="email" required placeholder="email"><br>
        
        <input type="text" name="phone_number" required placeholder="Phone Number"><br>
        
        <input type="text" name="username" required placeholder="Username"><br>
        
        <input type="password" name="password" required placeholder="Password"><br>

        <!-- Role selection -->
         <label for="role">Register As</label>
        <select name="role" required>
            <option value="student">Student</option>
            <option value="admin">Admin</option>
        </select><br>

        <!-- Profile Picture upload -->
        <label for="profile_pic">Profile Picture</label>
        <input type="file" name="profile_pic" accept="image/*" required><br>
        <div class="form-footer" style="margin-right: 30px;">
        <button type="submit" style="width: 30%;">Register</button>
        <a href="login.php" style="">Already_Registered? Login_Here</a>
        </div>
    </form>
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
