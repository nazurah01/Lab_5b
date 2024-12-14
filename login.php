<?php
session_start(); // Start the session to manage user login

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Check if the form is submitted
    // Collect form data
    $matric = $_POST['matric']; //Dapatkan matric number daripada form
    $password = $_POST['password']; // Dapatkan password daripada form

    // Database connection
    $conn = new mysqli("localhost", "root", "", "Lab_5b"); //Connect to the database

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error); // Terminate script if connection fails
    }

    // Query to fetch user with the given matric
    $sql = "SELECT matric, password FROM users WHERE matric = ?"; // Parameterized query to prevent SQL injection
    $stmt = $conn->prepare($sql); // Prepare the statement
    $stmt->bind_param("s", $matric); // Bind the matric value to the query
    $stmt->execute(); //Execute the query
    $result = $stmt->get_result(); // Get the result set

    if ($result->num_rows > 0) { // Check if a user exists with the given matric
        $row = $result->fetch_assoc(); //Fetch the user data
        // Verify password
        if (password_verify($password, $row['password'])) { // Check if the entered password matches the stored hashed password
            // Authentication successful
            $_SESSION['user'] = $matric; // Store matric in session
            header("Location: manage.php"); // Redirect to display page
            exit(); // Terminate the script
        } else {
            $error = "Invalid password."; // Error message for incorrect password
        }
    } else {
        $error = "Invalid username or password, try login again."; // Error message for non-existent user
    }

    // Close statement and connection
    $stmt->close(); //Close the prepared statement
    $conn->close(); //Close the database connection
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title> <!--Page title-->
    <style>
    /* Styling for the page */
    body {
        font-family: Georgia, serif; /* Font style */
        background-color: #f0f8ff; /* Light teal background */
        padding: 20px;
        margin: 0;
        color: #333; /* Standard text color */
    }
    /* Container styling for the form */
    .container {
        max-width: 500px; /* Limit width */
        margin: 50px auto; /* Center container with top spacing */
        background: #ffffff; /* White container */
        padding: 30px;
        border-radius: 12px; /* Slightly rounder corners */
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); /* Stronger shadow */
    }
    /* Title styling */
    h2 {
        text-align: center; /* Center the title */
        font-size: 1.8em; /* Larger font size */
        color: #008080; /* Teal color for the title */
        margin-bottom: 20px; /* Add spacing below the title */
    }
    /* Form layout */
    form {
        display: flex;
        flex-direction: column; /* Susun element form secara menegak */
    }
    /* Label styling */
    label {
        margin: 10px 0 5px;
        font-weight: bold; /* Bold labels for better emphasis */
        color: #004d4d; /* Darker teal for labels */
    }
    input {
        padding: 12px; /* More padding for better usability */
        font-size: 1em;
        margin-bottom: 20px;
        border: 1px solid #aaa; /* Softer border color */
        border-radius: 8px; /* Rounder input corners */
        transition: border-color 0.3s; /* Smooth transition on focus */
    }
    input:focus {
        border-color: #008080; /* Teal border on focus */
        outline: none; /* Remove default outline */
    }
    button {
        background: #008080; /* Teal background for button */
        color: white;
        padding: 12px;
        font-size: 1em;
        font-weight: bold;
        border: none;
        border-radius: 8px; /* Rounder button corners */
        cursor: pointer;
        transition: background 0.3s; /* Smooth hover effect */
    }
    button:hover {
        background: #006666; /* Darker teal on hover */
    }
    /* Error message styling */
    .error {
        color: #cc0000; /* Red for error messages */
        text-align: center; /* Center the error message */
        margin-top: 10px;
        font-weight: bold;
    }
    .link {
        text-align: center; /* Center the link section */
        margin-top: 20px; /* Spacing above links */
    }
    .link a {
        color: #008080; /* Teal color for links */
        text-decoration: none; /* Remove underline */
        font-weight: bold;
    }
    .link a:hover {
        text-decoration: underline; /* Underline on hover */
    }
</style>

</head>
<body>
    <div class="container">
        <h2>Login</h2> <!--Page title-->
        <?php if (!empty($error)): ?> <!--Display error message-->
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST" action=""> <!--Login form-->
            <label for="matric">Matric Number</label>
            <input type="text" id="matric" name="matric" required> <!--Input for matric-->

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required> <!--Input for password-->

            <button type="submit">Login</button> <!--Submit button-->
        </form>
        <div class="link"> <!--Section for additional links-->
            <p>Don't have an account? <a href="register.php">Register here</a></p> <!--Link to register page-->
        </div>
    </div>
</body>
</html>
