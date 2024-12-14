<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <style>
    body {
        font-family: Georgia, serif;
        background-color: #f0f8ff; /* Light teal background */
        margin: 0;
        padding: 20px;
        color: #333; /* Standard text color */
    }
    .container {
        max-width: 500px;
        margin: 50px auto; /* Center the container with space from top */
        background: #ffffff; /* White container */
        padding: 30px;
        border-radius: 12px; /* Slightly rounder corners */
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); /* Stronger shadow */
    }
    h2 {
        text-align: center; /* Center the title */
        font-size: 1.8em; /* Larger font size */
        color: #008080; /* Teal color for the title */
        margin-bottom: 20px; /* Add spacing below the title */
    }
    form {
        display: flex;
        flex-direction: column;
    }
    label {
        margin: 10px 0 5px;
        font-weight: bold; /* Bold labels for better emphasis */
        color: #004d4d; /* Darker teal for labels */
    }
    input, select {
        padding: 12px; /* More padding for better usability */
        font-size: 1em;
        margin-bottom: 20px;
        border: 1px solid #aaa; /* Softer border color */
        border-radius: 8px; /* Rounder input corners */
        transition: border-color 0.3s; /* Smooth transition on focus */
    }
    input:focus, select:focus {
        border-color: #008080; /* Teal highlight on focus */
        outline: none; /* Remove default outline */
    }
    button {
        background: #008080; /* Teal background */
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
    .message {
        margin-top: 20px;
        text-align: center;
        font-weight: bold;
        color: #28a745; /* Green for success messages */
    }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Collect form data
            $matric = $_POST['matric'];
            $name = $_POST['name'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encrypt the password
            $accessLevel = $_POST['accessLevel'];

            // Database connection
            $conn = new mysqli("localhost", "root", "", "Lab_5b");

            // Check the connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Insert data into the table
            $sql = "INSERT INTO users (matric, name, password, accessLevel) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            // Check for statement preparation success
            if (!$stmt) {
                die("Statement preparation failed: " . $conn->error);
            }

            // Bind parameters and execute the statement
            $stmt->bind_param("ssss", $matric, $name, $password, $accessLevel);

            if ($stmt->execute()) {
                // Redirect to display.php after successful registration
                header("Location: display.php");
                exit(); // Stop further script execution
            } else {
                echo "<p class='message' style='color: red;'>Error: " . $stmt->error . "</p>";
            }

            // Close the statement and connection
            $stmt->close();
            $conn->close();
        }
        ?>
        <form method="POST" action="">
            <label for="matric">Matric Number</label>
            <input type="text" id="matric" name="matric" required>

            <label for="name">Name</label>
            <input type="text" id="name" name="name" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <label for="accessLevel">Access Level</label>
            <select name="accessLevel" id="accessLevel" required>
                <option value="">Please select</option>
                <option value="lecturer">Lecturer</option>
                <option value="student">Student</option>
            </select><br>

            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
