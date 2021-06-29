 <?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cake_curd";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "DROP DATABASE ".$dbname ;

if ($conn->query($sql) === TRUE) {
    echo "Database remove successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?> 