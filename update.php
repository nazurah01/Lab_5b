<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "Lab_5b"); //Connect to the Lab_5b database

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // Stop script execution if the connection fails
}

// Handle form submission for update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $originalMatric = $_POST['originalMatric']; //Retrive the original matric from the form
    $newMatric = $_POST['newMatric']; //Retrieve the new matric from the form
    $name = $_POST['name']; //Retrieve the name from the form
    $accessLevel = $_POST['accessLevel']; //Retrieve the access level from the form

    //Prepare the SQL query to update the user details
    $updateSQL = "UPDATE users SET matric = ?, name = ?, accessLevel = ? WHERE matric = ?";
    $stmt = $conn->prepare($updateSQL); //Prepare the SQL statement
    $stmt->bind_param("ssss", $newMatric, $name, $accessLevel, $originalMatric); // Bind the form data to the query

    // Execute the query and check if it was successful
    if ($stmt->execute()) {
        header("Location: manage.php"); //Redirect to the manage page after successful update
        exit(); //Terminate the script
    } else {
        echo "Error updating user: " . $stmt->error;  // Display error if the update fails
    }

    $stmt->close(); //Close the prepared statement
}

// Fetch the user data for editing
if (isset($_GET['matric'])) { // Check if matric is provided in the URL
    $matric = $_GET['matric']; // Get the matric number from the URL
    $sql = "SELECT matric, name, accessLevel FROM users WHERE matric = ?"; // SQL query to fetch user data
    $stmt = $conn->prepare($sql); //Prepare the SQL statement
    $stmt->bind_param("s", $matric);
    $stmt->execute(); //Execute the query
    $result = $stmt->get_result(); //Get the result of the query
    $user = $result->fetch_assoc(); //Fetch the user data
    $stmt->close(); //Close the statement
} else {
    header("Location: manage.php"); //If no matric is provided, redirect to the manage page
    exit();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title> <!--Page title-->
    <style>
    body {
        font-family: Georgia, serif; /* Font style */
        background-color: #f0f8ff; /* Light teal background */
        padding: 20px;
        margin: 0;
        color: #333;
    }
    .container {
        max-width: 500px; /* Limit the width */
        margin: 50px auto; /* Center the container with spacing from the top */
        background: #ffffff; /* White background for the form */
        padding: 30px; /* Add padding inside the container */
        border-radius: 12px; /* Round corners */
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); /* Strong shadows */
    }
    h2 {
        text-align: center; /* Center align the title */
        font-size: 1.8em; /* Larger font size */
        margin-bottom: 20px; /* Add spacing below title */
        color: #008080; /* Teal color for the title */
    }
    form {
        display: flex;
        flex-direction: column; /* Stack form elements menegak */
    }
    label {
        margin: 10px 0 5px; /* Add spacing between elements */
        font-weight: bold; /* Bold labels */
        color: #004d4d; /* Darker teal for labels */
    }
    input {
        padding: 12px; /* More padding  */
        font-size: 1em;
        margin-bottom: 20px;
        border: 1px solid #aaa; /* Softer border color */
        border-radius: 8px; /* Rounder input corners */
        transition: border-color 0.3s; /*Smooth transition */
    }
    input:focus {
        border-color: #008080; /* Teal highlight on focus */
        outline: none; /* Remove default outline */
    }
    button {
        background: #008080; /* Teal button background */
        color: white;
        padding: 12px;
        font-size: 1em;
        font-weight: bold;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.3s;
        margin-bottom: 10px;
    }
    button:hover {
        background: #006666; /* Darker teal on hover */
    }
    .cancel-btn {
        background: #ff6666; /* Soft red for cancel button */
        transition: background 0.3s;
    }
    .cancel-btn:hover {
        background: #cc0000; /* Darker red on hover */
    }
    a.cancel-btn {
        text-align: center;
        text-decoration: none;
        display: block;
        padding: 12px;
        color: white;
    }
</style>


</head>
<body>
    <div class="container">
        <h2>Update User</h2> <!--Page title-->
        <form method="POST" action=""> <!--Form for updating user details-->
            <!-- Original Matric (hidden field for tracking) -->
            <input type="hidden" name="originalMatric" value="<?php echo htmlspecialchars($user['matric']); ?>">

            <!-- New Matric -->
            <label for="newMatric">Matric Number</label>
            <input type="text" id="newMatric" name="newMatric" value="<?php echo htmlspecialchars($user['matric']); ?>" required>

            <!-- Name -->
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>

            <!-- Access Level -->
            <label for="accessLevel">Access Level</label>
            <input type="text" id="accessLevel" name="accessLevel" value="<?php echo htmlspecialchars($user['accessLevel']); ?>" required>

            <!-- Submit and Cancel Buttons -->
            <button type="submit">Update User</button> <!--Button to submit the form-->
            <a href="manage.php" class="cancel-btn" style="text-align:center; display:block; padding:10px; text-decoration:none; color:white; border-radius:5px;">Cancel</a> <!-- Link to cancel and go back to manage page -->
        </form>
    </div>
</body>
</html>
