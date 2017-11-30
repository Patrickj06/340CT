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
    
function AddItem(Input){   
    
    var dropdowns = document.getElementById("myDropdown");
    var child = document.getElementById(Input);
    var output = document.getElementById(Input).id;

    document.getElementById("submit").style.visibility = "visible";
    document.getElementById("Inputs").value += (output + " ");
    child.style.display = "none";

    var textbox = document.createElement("INPUT");
    var title = document.createElement("H1");
    var text = document.createElement("LABEL");
    var span = document.createElement("SPAN");
    var title_text = document.createTextNode(Input);
    var text_text = document.createTextNode("Quantity :");

    //add new heading 
    title.setAttribute("for", (output + "Title"));
    title.appendChild(title_text);
    document.getElementById("Form").appendChild(title);

    //add new lable 
    text.setAttribute("id", (output + "quantity"));
    document.getElementById("Form").appendChild(text);

    //add new span inside the label
    span.setAttribute("id", (output + "Quantity"));
    span.appendChild(text_text);
    document.getElementById(output + "quantity").appendChild(span);

    //add new textbox inside the label
    textbox.setAttribute("type", "text");
    textbox.setAttribute("id", output);
    textbox.setAttribute("name", output);
    textbox.setAttribute("class", "input_text");
    document.getElementById(output + "quantity").appendChild(textbox);

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
                                     <?php while( $row = $result->fetch_assoc()) : ?>
                                         
                                        <a id = "<?php echo $row['item_name'];?>" onclick = "AddItem(this.id)"><?php echo $row['item_name'];?></a>
                                    <?php endwhile ?>
                                </div>
                           </div>
                            
                            <form id= "myForm" method="POST" action ="Event.php">
                                <div id = "Form" class="contact-form mar-top30">
    
                                    <input type="hidden" name="ID" class="input_text" value="<?php echo "4";?>">
                                    <input id = "Inputs" type="hidden" name="Inputs" class="input_text" value="">
                                    
                                </div>
                                <div class="contact-form mar-top30">
                                <input id = "submit" type="submit" class="button" value="Submit" />
                                </div>
                                <script> 
                                    document.getElementById("submit").style.visibility = "hidden";
                                    document.getElementById("Inputs").value = ("");

                                </script>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>