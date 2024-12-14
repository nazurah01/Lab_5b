<?php
//Define a class to manage database connections
class Database
{
    //Properties for database connection details
    private $host = "localhost"; //Hostname of the database server
    private $username = "root"; //Username to connect to the database
    private $password = "123"; //Password for the database user
    public $conn; // Property to hold the database connection

    // Method to get the database connection
    public function getConnection()
    {
        //create a new MySQLi connection
        $this->conn = new mysqli($this->host, $this->username, $this->password);

        //Check if the connection failed
        if ($this->conn->connect_error) {
            // Terminate the script and display an error message
            die("Connection failed: " . $this->conn->connect_error);
        } else {
            // echo "Connected successfully";
        }
        //Return the connection object
        return $this->conn;
    }
}