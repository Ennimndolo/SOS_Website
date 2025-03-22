<?php
// Start session
session_start();

// Check if the student is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registration_system";

$conn = new mysqli($servername, $username, $password, 'student_portal');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user details
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM students WHERE student_id='$user_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

// Fetch enrolled courses
// $sql_courses = "SELECT courses.course_name, courses.description FROM enrollments
//                 JOIN courses ON enrollments.course_id = courses.id
//                 WHERE enrollments.user_id = '$user_id'";
// $courses_result = $conn->query($sql_courses);

// Handle profile update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $new_name = $_POST['fullname'];
    $new_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    $update_sql = "UPDATE users SET fullname='$new_name', password='$new_password' WHERE id='$user_id'";
    
    if ($conn->query($update_sql) === TRUE) {
        echo "Profile updated successfully!";
        $_SESSION['fullname'] = $new_name;  // Update session variable
    } else {
        echo "Error updating profile: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .dashboard-container {
            width: 80%;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
        }

        h1 {
            color: dodgerblue;
            text-align: center;
        }

        .profile-section, .courses-section, .announcement-section {
            margin-bottom: 20px;
        }

        .button {
            background-color: dodgerblue;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        
        .button:hover {
            background-color: #005bb5;
        }

        .logout {
            text-align: right;
        }

        .course {
            background-color: #f1f1f1;
            padding: 10px;
            margin: 10px 0;
        }
    </style>
</head>
<body>

    <div class="dashboard-container">
        <h1>Welcome, </h1>
        
        <!-- Profile Section -->
        <div class="profile-section">
            <h2>Your Profile</h2>
            <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
            <p><strong>Role:</strong> Student</p>
            
            <!-- Profile Update Form -->
            <form method="post" action="">
                <h3>Update Profile</h3>
                <label for="fullname">Full Name:</label>
                <input type="text" name="fullname" value="<?php echo $user['fullname']; ?>" required><br>
                
                <label for="password">New Password:</label>
                <input type="password" name="password" required><br>
                
                <button type="submit" name="update_profile" class="button">Update Profile</button>
            </form>
        </div>
        
        <!-- Enrolled Courses Section -->
        <div class="courses-section">
            <h2>Your Enrolled Courses</h2>
            <?php
            if ($courses_result->num_rows > 0) {
                while ($course = $courses_result->fetch_assoc()) {
                    echo "<div class='course'>";
                    echo "<h3>" . $course['course_name'] . "</h3>";
                    echo "<p>" . $course['description'] . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>You are not enrolled in any courses yet.</p>";
            }
            ?>
        </div>
        
        <!-- Announcements/Notifications Section -->
        <div class="announcement-section">
            <h2>Announcements</h2>
            <p>No new announcements at the moment.</p>
        </div>

        <!-- Logout Section -->
        <div class="logout">
            <a href="logout.php" class="button">Logout</a>
        </div>
    </div>

</body>
</html>
