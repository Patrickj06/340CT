<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "SCM_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

#$sql = "INSERT INTO staff (first_name, last_name, role, salary)
#VALUES ('Patrick', 'Johnson', 'Beast', 10)";

#$sql = "INSERT INTO stock (item_name, item_price, item_quantity, last_ordered , minimum_stock, maximum_stock, staff_check)
#VALUES ('milk', 2.50, 1, 30/10/2017, 100, 200, 1)";

$sql = "INSERT INTO stock (item_name, item_price, item_quantity, last_ordered , minimum_stock, maximum_stock, staff_check)
VALUES ('bread', 1.50, 1, 30/10/2017, 50, 100, 1)";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

?>
