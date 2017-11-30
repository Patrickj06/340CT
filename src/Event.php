
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
            $this->input_values =array();
            $j = count($inputs) -1;
            for($i = 0; $i < $j ; $i++) {
                $key = $inputs[$i];
                
                $value = $_POST[$inputs[$i]];
                $this->input_values = array_push_assoc($this->input_values,$key,$value);
            }
            //print_r($this->input_values);
            
           
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
                    $message = "There isnt enough " . $i . " in stock";
                    $ErrorQueue->push($message);
                }
            }
        
        }
        return $ErrorQueue;
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
                $message = $row['item_name'] . "is low on stock";
                $lowStock->push($id);
            }
        }
        return $lowStock;
    }
    
    public function Check_Stock_Max($event){
        
        
        $maxStock = new SplQueue();
        foreach($event->input_values as $i=>$i_value){
        
        $sql = "SELECT item_id, item_name, maximum_stock, item_quantity FROM stock WHERE item_name = '$i'";		
        $result = $GLOBALS['conn']->query($sql);
        while( $row = $result->fetch_assoc()) {
            
            if (($i_value + $row['item_quantity']) > $row['maximum_stock']){
                echo $row['item_quantity'];
                echo $i_value;
                $message = $i . " will go over maximum amount of stock";
                $maxStock->push($message);
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
    
    public function Notify_Error($Error_List){
        while(!$Error_List->isEmpty()) {
           $error = $Error_List->pop();
            echo $error;
            
            echo "<script>
            alert('$error');
            
            </script>";
        }
    }
}
class Validation_Processor
{
    public function Validate_SalesOrders($event){
        $errorList = new SplQueue(); 
        foreach($event->input_values as $i=>$i_value){
            if (!preg_match("/^[0-9]*$/",$i_value) or $i_value == ""){
                $message = $i . " input must be a number";
                $errorList->push($message);
            }
        }

        return $errorList;
    }
    
    public function Validate_Stock_Update($event){

        $errorList = new SplQueue(); 
        if (!preg_match("/^[a-zA-Z ]*$/",$event->Item_name)) {
            $message = "Name must contain letters only";
            $errorList->push($message);
        }
        if (!preg_match("/^[1-9]\d*(\.\d+)?$/",$event->Item_price)) {
            $message = "Price must contain numbers only with a . followed by 2 numbers";
            $errorList->push($message);
        }
        if (!preg_match("/^[0-9]*$/",$event->Item_quantity)) {
            $message = "Quantity must contain number only";
            $errorList->push($message);
        }
        if (!preg_match("/^[a-zA-Z ]*$/",$event->Item_type)) {
            $message = "Type must contain letters only";
            $errorList->push($message);
        }
        if (!preg_match("/^[0-9]*$/",$event->Minimum)) {
            $message = "Minimum Stock must contain numbers only";
            $errorList->push($message);
        }
        if (!preg_match("/^[0-9]*$/",$event->Maximum)) {
            $message = "Maximum Stock must contain numbers only";
            $errorList->push($message);
        }
        if (Validate_Min_Max($event-Minimum, $event-Maximum) == true){
            $message = "Minimum Stock must be less than Maximum";
            $errorList->push($message);
        }
        return $errorList;
    }
    function Validate_Min_Max($Min,$Max){
        if ($Min >= $Max or $Max <= $Min){
            return true;
        }
        return false;
    }
}


class Mediator 
{
    function __construct(){
        
        $this->Stock_processor = new Stock_Processor();
        $this->Order_processor = new Order_Processor();
        $this->Notifcation_processor = new Notifcation_Processor();
        $this->Validation_processor = new Validation_Processor();
    }
      
      public function start($event)
     {
          $id = $event->type;
          	switch($id)
            {
                case '1':
                    echo "1";
                    break;
                case '2': //Update Stock Event 
                    $Error_List = $this->Validation_processor->Validate_SalesOrders($event);
                    if (!$Error_List->isEmpty()){
                        $this->Notifcation_processor->Notify_Error($Error_List);
                        echo "<script>window.location.href='Stock.php';</script>";
                    } else {
                        $this->Stock_processor->Update_Stock($event);
                        $LowStock = $this->Stock_processor->Check_Stock_Levels();
                        $this->Notifcation_processor->Notify_Error($LowStock);
                        echo "<script>window.location.href='Update_Succ.php';</script>";
                    }
                    
                    break;
                case '3':
                    $Validate_Errors = $this->Validation_processor->Validate_SalesOrders($event);
                    if (!$Validate_Errors->isEmpty()){
                        $this->Notifcation_processor->Notify_Error($Validate_Errors);
                        echo "<script>window.location.href='Sale.php';</script>";
                    } else {
                        $Stock_Errors = $this->Stock_processor->Check_Stock($event);
                        if (!$Stock_Errors->isEmpty()){
                            $this->Notifcation_processor->Notify_Error($Stock_Errors);
                            echo "<script>window.location.href='Sale.php';</script>";
                        } else {
                            $this->Stock_processor->Update_Stock_Level($event);
                            $LowStock = $this->Stock_processor->Check_Stock_Levels();
                            $this->Notifcation_processor->Notify_Low_Stock($LowStock);
                            echo "<script>window.location.href='Update_Succ.php';</script>";
                        }
                    }
                    break;
                case '4':
                    $Validate_Errors = $this->Validation_processor->Validate_SalesOrders($event);
                    if (!$Validate_Errors->isEmpty()){
                        $this->Notifcation_processor->Notify_Error($Validate_Errors);
                        echo "v";
                        echo "<script>window.location.href='Order_Stock.php';</script>";
                    } else {
                        $MaxStock_Errors = $this->Stock_processor->Check_Stock_Max($event);
                        if (!$MaxStock_Errors->isEmpty()){
                            $this->Notifcation_processor->Notify_Error($MaxStock_Errors);
                            echo "<script>window.location.href='Order_Stock.php';</script>";
                        } else {
                            $this->Order_processor->Add_Order($event);
                            $this->Order_processor->Add_Items_to_Order($event);
                            echo "<script>window.location.href='Update_Succ.php';</script>";
                        }
                    }
                    break;

          
     }
      }
}




class Event_Loop {
    
    function __construct(){
        $this->mediator = new Mediator();   
        echo "created";
    }
    
    public function Start_Event_Loop($EventQueue){
        echo "here";
        while(!$EventQueue->isEmpty()) {
            $event = $EventQueue->pop();
            echo "start";
            $this->mediator->start($event);
    }
        
    }
}

function array_push_assoc($array, $key, $value){
        $array[$key] = $value;
        return $array;
        }


$EventQueue = new SplQueue();
print_r($EventQueue);
$ID = $_POST["ID"];

$event = new Event($ID);

$EventQueue->push($event);
//print_r($EventQueue);

$eventLoop = new Event_Loop();
$eventLoop->Start_Event_Loop($EventQueue);

?>