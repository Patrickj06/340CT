<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "SCM5_db";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


$sql = "CREATE DATABASE SCM5_db";

if ($conn->query($sql) === TRUE) {
    echo "Database created successfully  ";
} else {
    echo "Error creating database: " . $conn->error;
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "CREATE TABLE staff (
staff_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
first_name VARCHAR(30) NOT NULL,
last_name VARCHAR(30) NOT NULL,
role VARCHAR(30) NOT NULL,
salary INT(6) UNSIGNED NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table staff created successfully  ";
} else {
    echo "Error creating table: " . $conn->error;
}

$sql = "CREATE TABLE stock (
item_id INT(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
item_name VARCHAR(20) NOT NULL,
item_price DEC(3,2) NOT NULL,
item_quantity INT(7) NOT NULL,
item_type VARCHAR(15) NOT NULL,
last_ordered DATE,
minimum_stock INT(5) NOT NULL,
maximum_stock INT(5) NOT NULL,
staff_check INT(6) UNSIGNED,
CONSTRAINT stock_staff_id_fk FOREIGN KEY (staff_check)
REFERENCES staff(staff_id)
)";
if ($conn->query($sql) === TRUE) {
    echo "Table stock created successfully  ";
} else {
    echo "Error creating table: " . $conn->error;
}

$sql = "CREATE TABLE orders (
order_id INT(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
order_price DEC(5,2) NOT NULL,
order_date DATE NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table order created successfully  ";
} else {
    echo "Error creating table: " . $conn->error;
}

$sql = "CREATE TABLE stock_order (
order_id INT(4),
item_id INT(4),
order_quantity INT(4),
CONSTRAINT order_id_pk PRIMARY KEY (order_id,item_id)
)";
if ($conn->query($sql) === TRUE) {
    echo "Table stock_order created successfully  ";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>



















