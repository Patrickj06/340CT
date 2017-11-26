<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "SCM5_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "INSERT INTO staff (first_name, last_name, role, salary)
VALUES ('Patrick', 'Johnson', 'CEO', 10)";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$sql = "INSERT INTO stock (item_name, item_price, item_quantity, item_type, last_ordered , minimum_stock, maximum_stock, staff_check)
VALUES ('Milk', 2.50, 1, 'Dariy', 30/10/2017, 100, 200, 1)";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$sql = "INSERT INTO stock (item_name, item_price, item_quantity, item_type, last_ordered , minimum_stock, maximum_stock, staff_check)
VALUES ('Bread', 1.50, 1, 'Bakery', 30/10/2017, 50, 100, 1)";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$sql = "INSERT INTO stock (item_name, item_price, item_quantity, item_type, last_ordered , minimum_stock, maximum_stock, staff_check)
VALUES ('Eggs', 2.75, 20, 'Eggs', 31/10/2017, 50, 75, 1)";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

?>
