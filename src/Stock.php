<!DOCTYPE html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SCM system</title>
<link href="css/StyleSheet.css" rel="stylesheet" type="text/css" />
<style>
            table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 100%;
                color: #000000;
            }
            td, th {
                border: 1px solid #111111;
                text-align: left;
                padding: 8px;
                background-color: #dddddd;
            }
</style>
</head>
<body>
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
    
        $sql = "SELECT * FROM stock";		
        $result = $conn->query($sql);
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
            <li><a href="staff_page.html">Log In</a></li>
            <li><a href="Stock.php" class="active">Stock</a></li>
        </ul>
    </div>
    </div>
    
    <div class="page-wrap">
        <div class="wrap3">  
            <div class="leftcol">
                <div class="panel">
                    <div class="title">
                        <h1>View Stock</h1>
                    </div>
                    <div class="panel"></div>
                        <form id= "myForm" method="POST">
                            
                             <label > <span>Type</span>
                                <input type="text" name="type" class="input_text" value="<?php echo $type;?>"> <!--diplays the users last input back to the text box -->
                            </label>
                            <br>
                            <br>
                            <br>
                            
                            
                            
                            <table id="stock_table">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Staff checked</th>
                                </tr>
                                <tbody>
                                    <!--Use a while loop to make a table row for every DB row-->
                                    <?php while( $row = $result->fetch_assoc()) : ?>
                                    <tr>
                                        <!--Each table column is echoed in to a td cell-->
                                        <td><?php echo $row['item_id']; ?></td>
                                        <td><?php echo $row['item_name']; ?></td>
                                        <td><?php echo "£" .$row['item_price'];?></td>
                                        <td><?php echo $row['item_quantity'];?></td>
                                        <td><?php echo $row['staff_check'];?></td>
                                    </tr>
                                    <?php endwhile ?>
                                </tbody>
                                
                            </table>
                                
                        </form>

                            
                        <div class="clearing"></div>
                    
                </div>	
            </div>
        </div>
    </div>
    
</body>
</html>