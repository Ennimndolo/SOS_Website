<?php
// admin_dashboard.php - Admin Dashboard that controls student details

include 'db_connection.php';  // Include database connection file
session_start();

// Check if user is logged in and has admin role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");  // Redirect to login if not logged in or not an admin
    exit();
}

// Fetch all students' data for admin to view and manage
$query = "SELECT * FROM students";  // Query to fetch all students
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="dash.css">
</head>
<body>

    <!-- Admin Dashboard Header -->
    <header>
        <h1>Welcome, Admin!</h1>
        <a href="logout.php">Logout</a>  <!-- Add logout link -->
    </header>

    <!-- Admin Controls Section -->
    <section id="admin-controls">
        <h2>Manage Students</h2>
        <p>Here you can view and edit student profiles, manage student data, and perform administrative tasks.</p>
        
        <h3>Student List</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($student = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $student['id']; ?></td>
                        <td><?php echo $student['username']; ?></td>
                        <td><?php echo $student['email']; ?></td>
                        <td><?php echo $student['role']; ?></td>
                        <td>
                            <!-- Edit and Delete buttons for each student -->
                            <a href="edit_student.php?id=<?php echo $student['id']; ?>">Edit</a> |
                            <a href="delete_student.php?id=<?php echo $student['id']; ?>" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </section>

    <!-- Additional Sections for Admin Functions -->
    <section id="additional-controls">
        <h3>Other Admin Controls</h3>
        <!-- You can add other admin functions like attendance management, course registration, etc. -->
    </section>

</body>
</html>
