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
    
function AddItem(Title,Text,Textbox,Input){   
    //alert(Input);
    var dropdowns = document.getElementById("myDropdown");
    var child = document.getElementById(Input);
    var output = document.getElementById(Input).id;
    var milk = document.getElementById("Milk");
    var bread = document.getElementById("Bread");
    var eggs = document.getElementById("Eggs");
    
        document.getElementById(Text).innerHTML = "Quantity :";
        document.getElementById(Textbox).style.visibility = "visible";
        document.getElementById("submit").style.visibility = "visible";
        document.getElementById("Inputs").value += (output + " ");
        document.getElementById(Title).innerHTML = output;
        document.getElementById(Textbox).name = output;
        child.style.display = "none";
        
        milk.onclick = function() {AddItem(Title+3,Text+3,Textbox+3,milk.id)};
        bread.onclick = function() {AddItem(Title+3,Text+3,Textbox+3,bread.id)};
        eggs.onclick = function() {AddItem(Title+3,Text+3,Textbox+3,eggs.id)};
    
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
        $i = 1;
    
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
                <li><a href="Sale.php" class="active">Sale</a></li>
                <li><a href="Stock.php">Stock</a></li>
                <li><a href="Order_Stock.php">Order</a></li>
            </ul>
        </div>
        
        <div class="page-wrap">
            <div class="wrap3">  
                <div class="leftcol">
                    <div class="panel">
                        <div class="title">
                            <h1>Sale</h1>
                        </div>
                        <div class="panel">

                            <div class="dropdown">
                                <button onclick="myFunction()" class="dropbtn">Add Item</button>
                                <div id="myDropdown" class="dropdown-content">
                                     <?php while( $row = $result->fetch_assoc()) : ?>
                                         
                                        <a id = "<?php echo $row['item_name'];?>" onclick = "AddItem(1,2,3,this.id)"><?php echo $row['item_name'];?></a>
                                    <?php endwhile ?>
                                </div>
                           </div>
                            
                            <form id= "myForm" method="POST" action ="Event.php">
                                <div class="contact-form mar-top30">
                                    
                                    
                                    <h1 id = "1"></h1>
                                    <label > <span id = "2"> </span>
                                        <input id = "3" type="text" name="item1" class="input_text" value="<?php echo $Item1;?>">
                                        
                                    </label>
                    
                                    <h1 id = "4"></h1>
                                    <label > <span id = "5"></span>
                                        <input type="text" id="6" class="input_text" value="<?php echo $Item2;?>"> <!--diplays the users last input back to the text box -->
                                    </label>
                                    
                                    <h1 id = "7"></h1>
                                    <label > <span id = 8></span>
                                        <input type="text" id = "9" class="input_text" value="<?php echo $Item3;?>"> <!--diplays the users last input back to the text box -->
                                    </label>
                                    <input type="hidden" name="ID" class="input_text" value="<?php echo "3";?>">
                                    <input id = "Inputs" type="hidden" name="Inputs" class="input_text" value="">
                                    
                                    <input id = "submit" type="submit" class="button" value="Submit" />
                                    
                                    <script>
                                        
                                        document.getElementById("3").style.visibility = "hidden";
                                        document.getElementById("6").style.visibility = "hidden";
                                        document.getElementById("9").style.visibility = "hidden";
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