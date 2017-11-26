<!--
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
</div>
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
-->
<?php



$servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "SCM5_db";

        // Create connection
        $GLOBALS['conn'] = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }


class Event 
{
    
    function __construct($type){
        $this->type = $type;
        echo $type;
        if ($type == '2'){
            $this->Item_id = $_POST["Item_id"];
            $this->Item_name = $_POST['Item_name'];
            $this->Item_price = $_POST['Item_price'];
            $this->Item_quantity = $_POST['Item_quantity'];
            $this->Item_type = $_POST['Item_type'];
            $this->Minimum = $_POST['Minimum_stock'];
            $this->Maximum = $_POST['Maximum_stock'];
        } else if ($type == '3' or $type == '4'){
            
            $inputs = explode(" ",$_POST['Inputs']);
            print_r($inputs);
            $this->input_values =array();
            $j = count($inputs);
            for($i = 0; $i < $j ; $i++) {
                $key = $inputs[$i];
                
                $value = $_POST[$inputs[$i]];
                $this->input_values = array_push_assoc($this->input_values,$key,$value);
            }
            print_r($this->input_values);
            
           
        }
        
    }
    
    
}

class Stock_Processor {
    
    public function Update_Stock($event)
    {

        $sql = "UPDATE stock 
        SET item_name = '$event->Item_name',
        item_price = '$event->Item_price', 
        item_quantity = '$event->Item_quantity', 
        item_type = '$event->Item_type', 
        minimum_stock = '$event->Minimum', 
        maximum_stock = '$event->Maximum'
        WHERE item_id = $event->Item_id";

        if (mysqli_query($GLOBALS['conn'], $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($GLOBALS['conn']);
        }
        
    }
    
    public function Check_Stock($event)
    {
        
        $ErrorQueue = new SplQueue();
        
        $j = count($event->input_values);
        foreach($event->input_values as $i=>$i_value) {
            $sql = "SELECT item_name,item_quantity FROM stock WHERE item_name ='$i'";		
            $result = $GLOBALS['conn']->query($sql);
            while($row = $result->fetch_assoc()) {
                if ($i_value > $row['item_quantity']){
                    $ErrorQueue->push($i);
                }
            }
        
        }
        //return $ErrorQueue;
    }
    
    public function Update_Stock_Level($event){
        
        
        foreach($event->input_values as $i=>$i_value){
            
            $sql = "SELECT item_quantity FROM stock WHERE item_name = '$i'";		
            $result = $GLOBALS['conn']->query($sql);

            while( $row = $result->fetch_assoc()) {
                $sub = $row['item_quantity'] - $i_value;                        
            }
            
            $sql = "UPDATE stock 
            SET item_quantity = '$sub'
            WHERE item_name = '$i'";

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
    
    public function Check_Stock_Max($event){
        echo "1";
        
        
        $maxStock = new SplQueue();
        foreach($event->input_values as $i=>$i_value){
        
        $sql = "SELECT item_id, item_name, maximum_stock, item_quantity FROM stock WHERE item_name = '$i'";		
        $result = $GLOBALS['conn']->query($sql);
        while( $row = $result->fetch_assoc()) {
            
            if (($i_value + $row['item_quantity']) > $row['maximum_stock']){
                $maxStock->push($i);
            }
        }
        return $maxStock;
    }
     
    }
}

class Order_Processor
{

    public function Add_Order($event){
        
        $total_price = 0;
        $date = date("Y/m/d");
        
        foreach($event->input_values as $i=>$i_value){
            
        $sql = "SELECT item_price FROM stock WHERE item_name ='$i'";		
        $result = $GLOBALS['conn']->query($sql);
        
        while( $row = $result->fetch_assoc()) {
            $total_price = $total_price + ($row['item_price'] * $i);
        }
        }
        
        $sql = "INSERT INTO orders (order_price, order_date)
        VALUES ('$total_price','$date')";
        if ($GLOBALS['conn']->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $GLOBALS['conn']->error;
        }

    }
    
    public function Add_Items_to_Order($event){
        
        $sql = "SELECT order_id FROM orders ORDER BY order_id DESC LIMIT 1";		
        $result = $GLOBALS['conn']->query($sql);
        
        while( $row = $result->fetch_assoc()) {
            $order_id = $row['order_id'];
        }
        
        foreach($event->input_values as $i=>$i_value){
            
                $sql = "SELECT item_id FROM stock WHERE item_name = '$i'";		
                $result = $GLOBALS['conn']->query($sql);

                while( $row = $result->fetch_assoc()) {
                    $item_id = $row['item_id'];
                }

                $sql = "INSERT INTO stock_order (order_id, item_id, order_quantity)
                VALUES ('$order_id', '$item_id', '$i_value')";

                if (mysqli_query($GLOBALS['conn'], $sql)) {
                    echo "Record updated successfully";
                } else {
                    echo "Error updating record: " . mysqli_error($GLOBALS['conn']);
                }
        }
    }
}



class Notifcation_Processor
{
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
    
    public function Notify_Max_Order($maxStock){
        while(!$maxStock->isEmpty()) {
           $max_item = $maxStock->pop();
            $message = $max_item . ' will go over the maximum amount of stock';
            echo "<script>
            alert('$message');
            
            </script>";
    }

}
}
class Validation_Processor
{
    public function Validate_Sales($event){
        if ($event->Bread == "" and $event->Eggs == "" and $event->Milk == ""){
            
        }
    }
}


class Event_Loop 
{
    function __construct(){
        
        $this->Stock_processor = new Stock_Processor();
        $this->Order_processor = new Order_Processor();
        $this->Notifcation_processor = new Notifcation_Processor();
        $this->Validation_processor = new Validation_Processor();
    }
      
      public function start($Queue)
     {
         while(!$Queue->isEmpty()) {
            $event = $Queue->pop();
             $id = $event->type;
             echo $event->type;
          	switch($id)
            {
                case '1':
                    echo "1";
                    break;
                case '2': //Update Stock Event 
                    $this->Stock_processor->Update_Stock($event);
                    $LowStock = $this->Stock_processor->Check_Stock_Levels();
                    $this->Notifcation_processor->Notify_Low_Stock($LowStock);
                    echo "<script>window.location.href='Update_Succ.php';</script>";
                    
                    break;
                case '3':
                    $errors = $this->Stock_processor->Check_Stock($event);
                    $this->Stock_processor->Update_Stock_Level($event);
                    $LowStock = $this->Stock_processor->Check_Stock_Levels();
                    $this->Notifcation_processor->Notify_Low_Stock($LowStock);
                    //echo "<script>window.location.href='Update_Succ.php';</script>";
                    break;
                case '4':
                    $MaxStock = $this->Stock_processor->Check_Stock_Max($event);
                    $this->Notifcation_processor->Notify_Max_Order($MaxStock);
                    /*if (!$MaxStock->isEmpty){
                        echo "<script>window.location.href='Order_Stock.php';</script>";
                    }*/
                    $this->Order_processor->Add_Order($event);
                    $this->Order_processor->Add_Items_to_Order($event);
                    
                    break;
            }
             
        }
          
     }
}

function array_push_assoc($array, $key, $value){
        $array[$key] = $value;
        return $array;
        }


$EventQueue = new SplQueue();
$ID = $_POST["ID"];

$event = new Event($ID);

$EventQueue->push($event);
//print_r($EventQueue);

$eventLoop = new Event_Loop();
$eventLoop->start($EventQueue);



?>
<!--
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
</div>
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
-->
