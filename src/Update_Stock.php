<!DOCTYPE html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SCM system</title>
    
<script type="text/javascript">
    function chgAction(num)
    '''Function that changes the action of the form nd then submits it to the controller'''
    {
        //document.getElementById("myForm").action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>";
        document.getElementById("myForm").submit();

        if (num == 0){ //if the number of validation error is 0 change the form

            document.getElementById("myForm").action = "Event.php";
            document.getElementById("myForm").submit();
        }
    }
</script>
<link href="css/StyleSheet.css" rel="stylesheet" type="text/css" />
</head>
    
<body>
     <?php
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
        
        $ID = $_POST["Stock_ID"];
        $Item_id = $Item_name = $Item_price = $Item_quantity = $Item_type = $Last_ordered = $Minimum_stock = $Maximum_stock = $Staff_check = "";
    
        $sql = "SELECT * FROM stock WHERE item_id = $ID";		
        $result = $conn->query($sql);
    
    while($row = $result->fetch_assoc()) {
        $Item_id = $row['item_id'];
        $Item_name = $row['item_name'];
        $Item_price = $row['item_price'];
        $Item_quantity = $row['item_quantity'];
        $Item_type = $row['item_type'];
        $Last_ordered = $row['last_ordered'];
        $Minimum_stock = $row['minimum_stock'];
        $Maximum_stock = $row['maximum_stock'];
        $Staff_check = $row['staff_check'];
    }
        
    ?>
    <div class="header-wrap">
	<div class="logo">
		<h1>SCM system</h1>
    </div>
    </div><!---header-wrap-End--->
    <div class="menu-wrap">
        <div class="menu">
            <ul>
                <li><a href="home.html" >Home</a></li>
                <li><a href="Sale.php">Sale</a></li>
                <li><a href="Stock.php" class="active">Stock</a></li>
                <li><a href="Order_Stock.php">Order</a></li>
            </ul>
        </div>
    </div>
    <div class="page-wrap">
            <div class="wrap3">  
                <div class="leftcol">
                    <div class="panel">
                        <div class="title">
                            <h1>Update Stock</h1>
                        </div>
                        <div class="panel">


                            <form id= "myForm" method="POST" action ="Event.php">
                                <div class="contact-form mar-top30">

                                    <label > <span>Name : </span>
                                        <input type="text" name="Item_name" class="input_text" value="<?php echo $Item_name;?>"> <!--diplays the users last input back to the text box -->
                                    </label>
                                    
                                    <label > <span>Price : </span>
                                        <input type="text" name="Item_price" class="input_text" value="<?php echo $Item_price;?>"> <!--diplays the users last input back to the text box -->
                                    </label>
                                    
                                    <label > <span>Quantiy :  </span>
                                        <input type="text" name="Item_quantity" class="input_text" value="<?php echo $Item_quantity;?>"> <!--diplays the users last input back to the text box -->
                                    </label>
                                    
                                    <label > <span>Type : </span>
                                        <input type="text" name="Item_type" class="input_text" value="<?php echo $Item_type;?>"> <!--diplays the users last input back to the text box -->
                                    </label>
                                    
                                    <label > <span>Minimum Stock :</span>
                                        <input type="text" name="Minimum_stock" class="input_text" value="<?php echo $Minimum_stock;?>"> <!--diplays the users last input back to the text box -->
                                    </label>
                                    
                                    <label > <span>Maximum Stock :  </span>
                                        <input type="text" name="Maximum_stock" class="input_text" value="<?php echo $Maximum_stock;?>"> <!--diplays the users last input back to the text box -->
                                    </label>
                                    
                                    <input type="hidden" name="Item_id" class="input_text" value="<?php echo $Item_id;?>">
                                    <input type="hidden" name="Last_ordered" class="input_text" value="<?php echo $Last_ordered;?>">
                                    <input type="hidden" name="Staff_check" class="input_text" value="<?php echo $Staff_check;?>">
                                    <input type="hidden" name="ID" class="input_text" value="<?php echo "2";?>">
                                    
                                    <input type="submit" class="button" value="Submit" onclick= "chgAction(0)"/>
                                    
                                </div>
                            </form>
                        <div class="clearing"></div>
                    </div>
                </div>	
            </div>
        </div>
    </div>
</body>
</html>