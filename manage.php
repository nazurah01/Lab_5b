<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "Lab_5b");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle deletion request
if (isset($_GET['delete'])) { //Check if a delete request is received
    $matric = $_GET['delete']; //Get the matric number from the URL
    $deleteSQL = "DELETE FROM users WHERE matric = ?"; //SQL query to delete a user
    $stmt = $conn->prepare($deleteSQL); //Prepare the SQL statement
    $stmt->bind_param("s", $matric); //Bind the matric parameter to the query
    if ($stmt->execute()) { //Execute the delete query
        header("Location: manage.php"); //Redirect to the same page after deletion
        exit(); //Stop futher execution after redirection
    } else {
        echo "Error deleting user: " . $stmt->error; //Display an error message if deletion fails
    }
    $stmt->close(); //Close the statement
}

// Fetch data from the users table
$sql = "SELECT matric, name, accessLevel FROM users"; //SQL query to fetch matric, name, and access level
$result = $conn->query($sql); //Execute the query and store the result
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <style>
    /* General body styling */
    body {
        font-family: Georgia, serif; /* Font style */
        background-color: #f0f8ff; /* Light teal background */
        padding: 20px;
        margin: 0;
        color: #333; /* Standard text color */
    }
    .container {
        max-width: 800px;
        margin: 50px auto; /* Center container with margin from the top */
        background: #ffffff; /* White container */
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); /* Stronger shadow */
    }
    h2 {
        text-align: center; /* Center the title */
        font-size: 1.8em; /* Slightly larger font */
        margin-bottom: 20px; /* Space below the title */
        color: #008080; /* Teal color for the title */
    }
    table {
        width: 100%;
        border-collapse: collapse; /*Remove space between table cells */
        margin-top: 20px;
        background-color: #fff; /* White background for table */
    }
    th, td {
        padding: 12px; /* Increased padding for better readability */
        text-align: left; /* Align text to the left */
        border: 1px solid #ddd; /* Light border for rows */
    }
    th {
        background-color: #008080; /* Teal background for headers */
        color: white; /* White text for headers */
        font-size: 1.1em; /* Slightly larger font for header */
    }
    td {
        font-size: 0.95em; /* Slightly smaller font for table data */
    }
    .btn {
        padding: 8px 12px; /* Larger padding for better usability */
        color: white;
        border: none;
        border-radius: 8px; /* Rounder buttons */
        text-decoration: none; /* Remove underline */
        font-size: 0.95em;
        transition: background 0.3s; /* Smooth hover effect */
    }
    .btn-update {
        background-color: #008080; /* Teal for update button */
    }
    .btn-delete {
        background-color: #ff6666; /* Light red for delete button */
    }
    .btn-update:hover {
        background-color: #006666; /* Darker teal on hover */
    }
    .btn-delete:hover {
        background-color: #cc0000; /* Darker red on hover */
    }
</style>

</head>
<body>
    <div class="container">
        <h2>Manage Users</h2> <!--Page title-->
        <?php if ($result->num_rows > 0): ?> <!--Check if there are rows in the result -->
            <table>  <!-- Display the data in a table -->
                <thead>
                    <tr>
                        <th>Matric Number</th> <!--Table header for matric-->
                        <th>Name</th> <!--Table header for name-->
                        <th>Access Level</th> <!--Table header for access level-->
                        <th>Actions</th> <!--Table header for actions-->
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?> <!-- Loop through each row -->
                        <tr>
                            <td><?php echo htmlspecialchars($row['matric']); ?></td> <!-- Display matric -->
                            <td><?php echo htmlspecialchars($row['name']); ?></td> <!-- Display name -->
                            <td><?php echo htmlspecialchars($row['accessLevel']); ?></td> <!-- Display access level -->
                            <td>
                                <a href="update.php?matric=<?php echo urlencode($row['matric']); ?>" class="btn btn-update">Update</a> <!--Update button-->
                                <a href="?delete=<?php echo urlencode($row['matric']); ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a> <!--Delete button-->
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No users found.</p> <!--Message when no data is available-->
        <?php endif; ?>
    </div>
</body>
</html>
<?php
// Close the database connection
$conn->close(); // Free up resources by closing the connection
?>
