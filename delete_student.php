<?php
// delete_student.php - Admin can delete a student record

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

    // Delete the student record from the database
    $delete_query = "DELETE FROM students WHERE id = '$student_id'";
    if (mysqli_query($conn, $delete_query)) {
        header("Location: admin_dashboard.php");  // Redirect to admin dashboard after deletion
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
