<!DOCTYPE html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SCM system</title>
<link href="css/StyleSheet.css" rel="stylesheet" type="text/css" />
    
<script>
    

    
    
    
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
}
    
function AddItem(item,num){   
    
    if (num == 0) {
        document.getElementById("Item1").innerHTML = "Quantity :";
        document.getElementById("item1").style.visibility = "visible";
        document.getElementById("submit").style.visibility = "visible";
        switch(item){
            case '1':
                document.getElementById("Item1Title").innerHTML = "Eggs";
                document.getElementById("item1").name = "eggs";
                break;
            case '2':
                document.getElementById("Item1Title").innerHTML = "Milk";
                document.getElementById("item1").name = "milk";
                break; 
            case '3':
                document.getElementById("Item1Title").innerHTML = "Bread";
                document.getElementById("item1").name = "bread";
                break;
        }
        
        
        
    
    } else if (num == 1){
        document.getElementById("Item2").innerHTML = "Quantity :";
        document.getElementById("item2").style.visibility = "visible";
        switch(item){
            case '1':
                document.getElementById("Item2Title").innerHTML = "Eggs";
                document.getElementById("item2").name = "eggs";
                break;
            case '2':
                document.getElementById("Item2Title").innerHTML = "Milk";
                document.getElementById("item2").name = "milk";
                break; 
            case '3':
                document.getElementById("Item2Title").innerHTML = "Bread";
                document.getElementById("item2").name = "bread";
                break;
        }
        
        
    } else {
        document.getElementById("Item3").innerHTML = "Quantity :";
        document.getElementById("item3").style.visibility = "visible";
        switch(item){
            case '1':
                document.getElementById("Item3Title").innerHTML = "Eggs";
                document.getElementById("item3").name = "eggs";
                break;
            case '2':
                document.getElementById("Item3Title").innerHTML = "Milk";
                document.getElementById("item3").name = "milk";
                break; 
            case '3':
                document.getElementById("Item3Title").innerHTML = "Bread";
                document.getElementById("item3").name = "bread";
                break;
        }
        
        
    }
    document.getElementById("Eggs").onclick = function() { AddItem('1',num+1)}; 
    document.getElementById("Milk").onclick = function() { AddItem('2',num+1)};
    document.getElementById("Bread").onclick = function() { AddItem('3',num+1)};
    
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
    
  if (!event.target.matches('.dropbtn')) {

    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}


    


</script>

</head>
    
<body>
    <?php
        $i = 0;
    
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
                <li><a href="home.html">Home</a></li>
                <li><a href="Sale.php" >Sale</a></li>
                <li><a href="Stock.php">Stock</a></li>
                <li><a href="Order_Stock.php" class="active">Order</a></li>
            </ul>
        </div>
        
        <div class="page-wrap">
            <div class="wrap3">  
                <div class="leftcol">
                    <div class="panel">
                        <div class="title">
                            <h1>Order Stock</h1>
                        </div>
                        <div class="panel">

                            <div class="dropdown">
                                <button onclick="myFunction()" class="dropbtn">Add Item</button>
                                <div id="myDropdown" class="dropdown-content">
                                     
                                         
                                        <a id = "Eggs" class = "button" onclick = "AddItem('1',0)">Eggs</a>
                                        <a id = "Milk" class = "button" onclick = "AddItem('2',0)">Milk</a>
                                        <a id = "Bread" class = "button" onclick = "AddItem('3',0)">Bread</a> 
                                    
                                </div>
                           </div>
                            
                            <form id= "myForm" method="POST" action ="Event.php">
                                <div class="contact-form mar-top30">
                                    
                                    
                                    <h1 id = "Item1Title"></h1>
                                    <label > <span id = "Item1"> </span>
                                        <input id = "item1" type="text" name="item1" class="input_text" value="<?php echo $Item1;?>">
                                        
                                    </label>
                    
                                    <h1 id = "Item2Title"></h1>
                                    <label > <span id = "Item2"></span>
                                        <input type="text" id="item2" class="input_text" value="<?php echo $Item2;?>"> <!--diplays the users last input back to the text box -->
                                    </label>
                                    
                                    <h1 id = "Item3Title"></h1>
                                    <label > <span id = Item3></span>
                                        <input type="text" id = "item3" class="input_text" value="<?php echo $Item3;?>"> <!--diplays the users last input back to the text box -->
                                    </label>
                                    <input type="hidden" name="ID" class="input_text" value="<?php echo "3";?>">
                                    
                                    <input id = "submit" type="submit" class="button" value="Submit" />
                                    
                                    <script>
                                        
                                        document.getElementById("item1").style.visibility = "hidden";
                                        document.getElementById("item2").style.visibility = "hidden";
                                        document.getElementById("item3").style.visibility = "hidden";
                                        document.getElementById("submit").style.visibility = "hidden";
                                         
                                    </script>
                                    
    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>