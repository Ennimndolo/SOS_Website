<?php
// edit_student.php - Admin can edit student details

include 'db_connection.php';  // Include database connection file
session_start();

// Check if user is logged in and has admin role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");  // Redirect to login if not logged in or not an admin
    exit();
}

// Check if student ID is provided in the URL
if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    // Fetch student data from database
    $query = "SELECT * FROM students WHERE id = '$student_id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $student = mysqli_fetch_assoc($result);
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Update student details after form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Update the student record in the database
    $update_query = "UPDATE students SET username = '$username', email = '$email', role = '$role' WHERE id = '$student_id'";
    if (mysqli_query($conn, $update_query)) {
        header("Location: admin_dashboard.php");  // Redirect to admin dashboard after update
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Student Profile</title>
    <link rel="stylesheet" href="dash.css">
    <link rel="stylesheet" href="edu.css">
</head>
<body>

    <h1>Edit Student Profile</h1>

    <form method="POST">
        <label for="username">Username</label>
        <input type="text" name="username" value="<?php echo $student['username']; ?>" required><br>

        <label for="email">Email</label>
        <input type="email" name="email" value="<?php echo $student['email']; ?>" required><br>

        <label for="role">Role</label>
        <select name="role" required>
            <option value="student" <?php echo ($student['role'] == 'student') ? 'selected' : ''; ?>>Student</option>
            <option value="admin" <?php echo ($student['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
        </select><br>

        <button type="submit">Update</button>
    </form>

    <a href="admin_dashboard.php">Back to Dashboard</a>

</body>
</html>
