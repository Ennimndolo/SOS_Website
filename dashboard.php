<?php
// dashboard.php - Displaying student or admin dashboard based on role

include 'db_connection.php';  // Database connection file
session_start();

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");  // Redirect to login page if not logged in
    exit();
}

// Fetch student profile data
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM students WHERE student_id = '$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="dash.css">
    <link rel="stylesheet" href="class.css">
    <link rel="stylesheet" href="responsive.css">
  

    <style>
        <!-- Styles for Modal -->
<style>
  /* Modal background */
  .modal {
    display: none; /* Hide modal initially */
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.4); /* Semi-transparent background */
    padding-top: 60px;
  }

  /* Modal content */
  .modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 500px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  }

  /* Close button */
  .close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
  }

  .close:hover,
  .close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
  }

  /* Button Style */
  .btn {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
    border-radius: 5px;
    font-size: 16px;
  }

  .btn:disabled {
    background-color: #cccccc;
    cursor: not-allowed;
    opacity: 0.6;
  }

  /* Alert style */
  .alert {
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 5px;
    color: #856404;
    background-color: #fff3cd;
    border-color: #ffeeba;
  }
  /* Default styling for the desktop view */
.Desktop-table {
  width: 100%;
  border-collapse: collapse;
}

.Desktop-table th, .Desktop-table td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
}

/* Hide the mobile version by default */
.mobile-table {
  display: none;
}

/* Make the mobile version visible on screens smaller than 768px */
@media only screen and (max-width: 768px) {
  /* Hide the desktop table */
  .Desktop-table {
    display: none;
  }

  /* Show the mobile table with two columns */
  .mobile-table {
    display: table;
    width: 100%;
    border-collapse: collapse;
  }

  .mobile-table th, .mobile-table td {
    padding: 10px;
    text-align: left;
    border: none;
  }

  .mobile-table tr {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    border-bottom: 1px solid #ddd;
    padding: 10px;
  }

  .mobile-table td::before {
    content: attr(data-label);
    font-weight: bold;
    display: inline-block;
    width: 45%; /* 45% of the width for the label */
    padding-right: 10px;
    border-right: 1px solid #ddd; /* Border between label and value */
    text-align: left;
 
    text-overflow: ellipsis;
  }

  .mobile-table td {
    width: 55%; /* 55% of the width for the value */
    padding-left: 10px;
    text-align: left;
    white-space: nowrap; /* Prevent wrapping */
    overflow: ;
    text-overflow: ellipsis; /* Add ellipsis if the text overflows */
  }
}

    </style>
</head>
<body>
    <!-- Notification for Successful Login -->
<div id="loginNotification" class="notification">
  <span id="notificationMessage"></span>
</div>

<nav id="nav-hum" style="background-color: dodgerblue;">
        <div class="logo">
            <img src="sos_logo.png" alt="Logo" style="height: 50px;">
        </div>
        
        <div class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
        
        <ul class="nav-links" id="nav-links">
            <li><a href="index.html">Home</a></li>
            <li><a href="about.html">About Us</a></li>
            <li><a href="index.html #courses">Courses on Offer</a></li>
            <li><a href="contact.html">Contact Us</a></li>
            <li> 
                <!-- Button to Open Term Registration -->
<button class="btn" id="registerTermBtn" onclick="openTermRegistration()" disabled>Register for Term</button>


            </li>
        </ul>
    </nav>

    <nav>
      
        <a href="#announcements">Announcements</a>
        <a href="#assignments">Assignments</a>
        <a href="#grades">Examination Results</a>
        <a href="#resources">Profile</a>

    </nav>
    <!-- Term Registration Popup Modal -->




<header>
    <div class="title">SOS VTC Student Portal</div>
    <div class="user-info">
        <span>
            <?php echo $user['full_name']; ?> |<?php echo ucfirst($user['role']); ?>
        </span>
        <img src="uploads/<?php echo $user['profile_pic']; ?>" alt="User Profile" class="profile-pic">
    </div>
</header>

<!-- Main Dashboard Content -->
 
<div id="termRegistrationModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeTermRegistration()">&times;</span>
    <h2>Term Registration</h2>

    <!-- Eligibility Alert Message -->
    <div id="eligibilityMessage" class="alert">
      <!-- This message will update based on payment check -->
    </div>

    <!-- Button to Confirm Term Registration -->
    <button id="confirmRegistrationBtn" class="btn" onclick="confirmRegistration()" disabled>Confirm Registration</button>
  </div>
</div>
<div class="dashboard">
    <div class="container">
        <h2>Welcome <?php echo $user['full_name']; ?></h2>

        <!-- Account Info Section -->
           
        <section class="account-info">
        <h3>Your Account Information</h3>
        <table class="Desktop-table">
  <tr>
    <th>Full Name</th>
    <th>Email</th>
    <th>Phone Number</th>
    <th>Username</th>
    <th>Role</th>
    <th>Registration Status</th>
    <th>Registration Period</th>
  </tr>
  <tr>
    <td><?php echo $user['full_name']; ?></td>
    <td><?php echo $user['email']; ?></td>
    <td><?php echo $user['phone_number']; ?></td>
    <td><?php echo $user['username']; ?></td>
    <td><?php echo ucfirst($user['role']); ?></td>
    <td><?php echo $user['registration_status']; ?></td>
    <td><?php echo $user['registration_period']; ?></td>
  </tr>
</table>

<table class="mobile-table">
  <tr>
    <td data-label="Full Name" class="table_td"> <?php echo $user['full_name']; ?></td>
  </tr>
  <tr>
    <td data-label="Email" class="table_td"> <?php echo $user['email']; ?></td>
  </tr>
  <tr>
    <td data-label="Phone Number" class="table_td"> <?php echo $user['phone_number']; ?></td>
  </tr>
  <tr>
    <td data-label="Username" class="table_td"> <?php echo $user['username']; ?></td>
  </tr>
  <tr>
    <td data-label="Role" class="table_td"> <?php echo ucfirst($user['role']); ?></td>
  </tr>
  <tr>
    <td data-label="Registration Status" class="table_td"> <?php echo $user['registration_status']; ?></td>
  </tr>
  <tr>
    <td data-label="Registration Period" class="table_td"><?php echo $user['registration_period']; ?></td>
  </tr>
</table>

        </section>

        <!-- Modules Section -->
        <section class="modules">
            <h3>Modules to Attend This Term</h3>
            <!-- Example of modules (you can fetch this dynamically from the database) -->
            <ol style="padding-left: 30px;">
                <li>ICT/COG-01-01 - Communication Graphics</li>
                <li>ICT/ESH-01-01 - Entrepreneureship</li>
                <li>ICT/CML-01-01 - Commucation Language</li>
                <li>ICT/NUM-01-01 - Numerancy</li>
                <li>ICT/OSH-01-01- Occupational Saftey and Helth</li>
                <li>ICT/SCE-01-01 - Science</li>
                                <!-- Add more modules based on the student data -->
            </ol>
        </section>

        <!-- Calendar Section (Can be connected to events or schedule if needed) -->
        <section class="calendar">
            <h3>Calendar of Events</h3>
            <!-- Here you can fetch and display calendar events -->
        <a href="edu-system.html#calendar"> View Here</a>
        </section>

        <!-- Notice Board Section -->
        <section class="notice-board" id="announcements">
            <h3>Notice Board</h3>
            <p>Attention! Make sure you have paid at least half of tuition fee so that you register the term</p>
        </section>
    </div>
</div>

<!-- Footer Section -->

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
 </div>
</body>
<script>
 // Select DOM items
const hamburger = document.getElementById('hamburger');
const navLinks = document.getElementById('nav-links');

// Toggle the nav links on click
hamburger.addEventListener('click', () => {
    navLinks.classList.toggle('active');
});
 // Open the term registration modal
 function openTermRegistration() {
    document.getElementById("termRegistrationModal").style.display = "block";
    checkEligibility();
  }

  // Close the term registration modal
  function closeTermRegistration() {
    document.getElementById("termRegistrationModal").style.display = "none";
  }

  // Check if the student has paid at least half of the tuition fees
  function checkEligibility() {
    // Simulating tuition fee status for demo (should be dynamic based on the student's payment record)
    var tuitionFeePaid = 600;  // Amount paid by the student (Example)
    var totalTuitionFee = 1000; // Total tuition fee for the term (Example)

    var registerTermButton = document.getElementById("registerTermBtn");
    var confirmButton = document.getElementById("confirmRegistrationBtn");
    var eligibilityMessage = document.getElementById("eligibilityMessage");

    // Check eligibility based on payment
    if (tuitionFeePaid >= totalTuitionFee / 2) {
      confirmButton.disabled = false;  // Enable confirm button if eligible
      eligibilityMessage.innerHTML = "You are eligible to register for this term!";
      eligibilityMessage.style.backgroundColor = "#d4edda"; // Green success alert
      eligibilityMessage.style.borderColor = "#c3e6cb";
      eligibilityMessage.style.color = "#155724";
      registerTermButton.disabled = false; // Enable "Register for Term" button
    } else {
      confirmButton.disabled = true; // Disable the confirm button
      eligibilityMessage.innerHTML = "You must pay at least half of the tuition fees before registering for the term.";
      eligibilityMessage.style.backgroundColor = "#fff3cd"; // Yellow warning alert
      eligibilityMessage.style.borderColor = "#ffeeba";
      eligibilityMessage.style.color = "#856404";
      registerTermButton.disabled = true; // Disable the "Register for Term" button
    }
  }

  // Confirm Term Registration
  function confirmRegistration() {
    alert("You have successfully registered for the term!");
    closeTermRegistration();  // Close the modal after registration
  }
  // Function to show the login success notification
function showLoginNotification() {
  var notification = document.getElementById("loginNotification");
  var message = document.getElementById("notificationMessage");

  // Change the message if needed (e.g., based on username)
  message.innerHTML = " Welcome <?php echo $user['full_name']; ?> , You have logged in successfully!";

  // Display the notification
  notification.classList.add("show");

  // After 3 seconds, hide the notification
  setTimeout(function() {
    notification.classList.add("fade-out");
    setTimeout(function() {
      notification.classList.remove("show", "fade-out");
    }, 500); // Wait for fade-out to complete before removing the class
  }, 3000); // Hide after 3 seconds
}

// Call this function after successful login, like so:
showLoginNotification();

</script>
</html>

