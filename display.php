<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "Lab_5b"); //Create a new connection to the Lab_5b database

// Check connection
if ($conn->connect_error) {
    //Terminate script and display an error if connection fails
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the users table
$sql = "SELECT matric, name, accessLevel FROM users"; //Query untuk dapatkan matric, name, and access level
$result = $conn->query($sql); //Execute the query and store the result set

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Users</title> <!---Page title--->
    <style>
    body {
        font-family: Georgia, serif; /* Font syle */
        background-color: #f0f8ff; /* Light teal background */
        padding: 20px; 
        margin: 0;
        color: #333; /* Standard text color */
    }
    /* Styling for the main container */
    .container {
        max-width: 800px; /* Limit the width */
        margin: 50px auto; /* Center container with spacing from the top */
        background: #ffffff; /* White background for the container */
        padding: 30px; /* Increased padding for a spacious feel */
        border-radius: 12px; /* Slightly rounder corners */
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); /* Stronger shadow for a modern look */
    }
    /* Styling for the title */
    h2 {
        text-align: center; /* Center the title */
        font-size: 1.8em; /* Larger font size for the title */
        color: #008080; /* Teal color for the title */
        margin-bottom: 20px; /* Add spacing below the title */
    }
    /* Styling for the table */
    table {
        width: 100%; /* Full width */
        border-collapse: collapse; /* Remove space between table cells */
        margin-top: 20px;
        background-color: #fff; /* White table background */
    }
     /* Styling for table headers and cells */
    th, td {
        padding: 12px; /* Increased padding for better readability */
        text-align: left; /* Align text to the left */
        border: 1px solid #ddd; /* Light border for table cells */
    }
     /* Styling for table headers */
    th {
        background-color: #008080; /* Teal background for headers */
        color: white; /* White text for headers */
        font-size: 1.1em; /* Slightly larger font for header */
    }
     /* Styling for table cells */
    td {
        font-size: 0.95em; /* Slightly smaller font for table data */
    }
    /* Alter row background for clarity */
    tr:nth-child(even) {
        background-color: #f9f9f9; /* Light grey background for alternate rows */
    }
    /* Hover effect for rows */
    tr:hover {
        background-color: #e0f7fa; /* Light teal highlight on hover */
    }
</style>

</head>
<body>
    <div class="container">
        <h2>Registered Users</h2> <!---Title of the page-->
        <?php if ($result->num_rows > 0): ?> <!----Check if the query returned any rows-->
            <table>
                <thead>
                    <tr>
                        <th>Matric Number</th> <!---Column header for matric-->
                        <th>Name</th> <!---Column header for name-->
                        <th>Level</th> <!--Column header for access level-->
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?> <!---Iterate through each row in the result set-->
                        <tr>
                            <td><?php echo htmlspecialchars($row['matric']); ?></td> <!-- Display matric-->
                            <td><?php echo htmlspecialchars($row['name']); ?></td> <!--Display name,-->
                            <td><?php echo htmlspecialchars($row['accessLevel']); ?></td> <!---Display access level-->
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No users found.</p> <!---Display a message if no data is available-->
        <?php endif; ?>
    </div>
</body>
</html>
<?php
// Close the database connection
$conn->close(); // Free up resources by closing the connection
?>
