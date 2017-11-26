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


$sql = "SELECT * FROM staff";		
$result = $conn->query($sql);		
  		  
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["staff_id"]. " - Name: " . $row["first_name"]. " ";
    } 
} else {
    echo "0 results";
}

$sql = "SELECT * FROM stock";		
$result = $conn->query($sql);		
  		  
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["item_id"]. " - Name: " . $row["item_name"]. " ". $row["staff_check"]. " " ;
    } 
} else {
    echo "0 results";
}

$sql = "SELECT * FROM orders";		
$result = $conn->query($sql);		
  		  
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["order_id"]. " - Name: " . $row["order_price"]. " ";
    } 
} else {
    echo "0 results";
}

echo "                  ";
$sql = "SELECT * FROM stock_order";		
$result = $conn->query($sql);		
  		  
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "             g                   ";
        echo "Order Id: " . $row["order_id"]. " - Item ID: " . $row["item_id"]. "Item Quant: " . $row["order_quantity"]. " ";
    } 
} else {
    echo "0 results";
}
$conn->close();
?>