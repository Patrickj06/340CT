<!DOCTYPE html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SCM system</title>
<link href="css/StyleSheet.css" rel="stylesheet" type="text/css" />
</head>
    
<body>
    <div class="header-wrap">
	<div class="logo">
		<h1>SCM system</h1>
    </div>
</div><!---header-wrap-End--->
    <div class="menu-wrap">
        <div class="menu">
            <ul>
                <li><a href="home.html">Home</a></li>
                <li><a href="Sale.php">Sale</a></li>
                <li><a href="Stock.php">Stock</a></li>
                <li><a href="Order_Stock.php">Order</a></li>
            </ul>
        </div>
    </div>
    
</body>
</html>

<?php

$servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "SCM2_db";

        // Create connection
        $GLOBALS['conn'] = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }


class Event {
    
    public function Update_Stock()
    {
        $Item_id = $_POST["Item_id"];
        $Item_name = $_POST['Item_name'];
        $Item_price = $_POST['Item_price'];
        $Item_quantity = $_POST['Item_quantity'];
        $Item_type = $_POST['Item_type'];
        $Minimum = $_POST['Minimum_stock'];
        $Maximum = $_POST['Maximum_stock'];
            
        $sql = "UPDATE stock 
        SET item_name = '$Item_name',
        item_price = '$Item_price', 
        item_quantity = '$Item_quantity', 
        item_type = '$Item_type', 
        minimum_stock = '$Minimum', 
        maximum_stock = '$Maximum'
        WHERE item_id = $Item_id";

        if (mysqli_query($GLOBALS['conn'], $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($GLOBALS['conn']);
        }
        
    }
    
    public function Check_Stock()
    {
        $Eggs = $_POST['eggs'];
        $Milk = $_POST['milk'];
        $Bread = $_POST['bread'];
        
        $sql = "SELECT item_quantity FROM stock";		
        $result = $GLOBALS['conn']->query($sql);
        
        $i = 0;
        while( $row = $result->fetch_assoc()) {
            if ($i == 0){
                
                if ($Milk > $row['item_quantity'] and $Milk <> "" ){
                    echo "Milk Error";
                }
               
            } else if ($i == 1){
                if ($Bread >= $row['item_quantity'] and $Bread <> "" ){
                    echo "Bread Error";
                    
                    echo $row['item_quantity'];
                    
                }
            } else if ($i == 2){
               if ($Eggs >= $row['item_quantity'] and $Eggs <> "" ){
                    echo "Eggs Error"; 
               }       
            }
            $i = $i + 1;
        }
        
        echo $Eggs;
    }
    
    public function Update_Stock_Level(){
        
        $Eggs = $_POST['eggs'];
        $Milk = $_POST['milk'];
        $Bread = $_POST['bread'];
        
        $sql = "SELECT item_quantity FROM stock";		
        $result = $GLOBALS['conn']->query($sql);

        $i = 0;
        while( $row = $result->fetch_assoc()) {
            switch($i){
                case 0:
                    if ($Milk <> ""){
                        $Milk_sub = $row['item_quantity'] - $Milk;                        
                    }
                    break;
                case 1:
                    if ($Bread <> ""){
                        $Bread_sub = $row['item_quantity'] - $Bread;
                    }
                    break;
                case 2:
                    if ($Eggs <> ""){
                        $Eggs_sub = $row['item_quantity'] - $Eggs;
                    }
                    break;
            }
            $i = $i + 1;
        }
            if ($Eggs <> ""){
                $item_id = '3';
                $sql = "UPDATE stock 
                SET item_quantity = '$Eggs_sub'
                WHERE item_id = 3";

                if (mysqli_query($GLOBALS['conn'], $sql)) {
                    echo "Record updated successfully";
                } else {
                    echo "Error updating record: " . mysqli_error($GLOBALS['conn']);
                }
            }
            if ($Bread <> ""){
                $item_id = '2';
                $sql = "UPDATE stock 
                SET item_quantity = '$Bread_sub'
                WHERE item_id = 2";

                if (mysqli_query($GLOBALS['conn'], $sql)) {
                    echo "Record updated successfully";
                } else {
                    echo "Error updating record: " . mysqli_error($GLOBALS['conn']);
                }
            }
        
            if ($Milk <> ""){
                $item_id = '1';
                $sql = "UPDATE stock 
                SET item_quantity = '$Milk_sub'
                WHERE item_id = 1";

                if (mysqli_query($GLOBALS['conn'], $sql)) {
                    echo "Record updated successfully";
                } else {
                    echo "Error updating record: " . mysqli_error($GLOBALS['conn']);
                }
            }
    }
    
    public function Check_Stock_Levels(){
        
        $lowStock = new SplQueue();
        $sql = "SELECT item_name, item_quantity, Minimum_stock FROM stock";		
        $result = $GLOBALS['conn']->query($sql);
        
        while( $row = $result->fetch_assoc()) {
            if ($row['item_quantity'] < $row['Minimum_stock']){
                $id = $row['item_name'];
                $lowStock->push($id);
            }
        }
        return $lowStock;
    }
    
    public function Notify_Low_Stock($lowStock){
        
        while(!$lowStock->isEmpty()) {
           $low_item = $lowStock->pop();
            $message = $low_item . ' is low on stock';
            echo $message;
            echo "<script>
            alert('$message');
            
            </script>";
        }
    }
}
 


class Event_Loop 
{
      
      public function start($Queue,$Event)
     {
         while(!$Queue->isEmpty()) {
            $ID = $Queue->pop();
          	switch($ID)
            {
                case '1':
                    echo "1";
                    break;
                case '2': 
                    $Event->Update_Stock();
                    $LowStock = $Event->Check_Stock_Levels();
                    $Event->Notify_Low_Stock($LowStock);
                    echo "<script>window.location.href='Update_Succ.php';</script>";
                    
                    break;
                case '3':
                   
                    $Event->Check_Stock();
                    $Event->Update_Stock_Level();
                    $LowStock = $Event->Check_Stock_Levels();
                    $Event->Notify_Low_Stock($LowStock);
                    echo "<script>window.location.href='Update_Succ.php';</script>";
                    break;
                    

            }
             
        }
          
     }
}


$EventQueue = new SplQueue();
$ID = $_POST["ID"];
$EventQueue->push($ID);
//print_r($EventQueue);

$eventLoop = new Event_Loop();
$Event = new Event();

$eventLoop->start($EventQueue,$Event);



?>