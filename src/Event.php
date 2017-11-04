<?php

 


class Event {
    
    public function Update_Stock()
    {
        
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "SCM2_db";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
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

        
        if (mysqli_query($conn, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
        echo 4;
        header("Location: Update_Succ.php");
    }
    
}
  


class Event_Loop 
{
      
      public function start($Queue,$Event)
     {
         while(!$Queue->isEmpty()) {
            $ID = $Queue->pop();
             echo $ID;
          	switch($ID)
            {
                case '1':
                    echo "1";
                    break;
                case '2': 
                    $Event->Update_Stock();
                    echo 3;
                    break;
                case '3':
                    echo "3";
                    break;
                    

            }
             
        }
          echo "Hello";
     }
}


$EventQueue = new SplQueue();
$ID = $_POST["ID"];
$EventQueue->push($ID);
print_r($EventQueue);

$eventLoop = new Event_Loop();
$Event = new Event();
echo 1;
$eventLoop->start($EventQueue,$Event);
echo 2;


?>