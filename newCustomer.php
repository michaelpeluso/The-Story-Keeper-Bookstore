<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>TSKB</title>

    <link rel="stylesheet" href="index.css">

</head>
<body class="newCus" onload="newCusPage()">

    <ul id="nav" >
      <li id="home"><a href="index.php">Home</a></li>
      <li><a href="sellerAccounts.php">Bookseller Records</a></li>
      <li><a href="purchaseForm.php">Purchase Form</a></li>
      <li><a href="return.php">Book Return</a></li>
      <li><a href="update.php">Update Book Order</a></li>
      <li><a href="cancel.php">Cancel Book Order</a></li>
      <li><a href="newCustomer.php">New Customer</a></li>
    </ul>

    <div id="container">
        <h1>New Customer</h1>
        <p>Fill out the information below to add a new customer profile.</p>

        <form id="form" action="" method="POST">
        <table id="inputFields">
            <tr>
                <td> <label for="form">Customer's First Name</label> </td> <!--'-->
                <td> <input type="text" id="cfname" name="cfname" placeholder="Ben" required>  </td> 
                <td><h6>REQUIRED</h6></td>
            </tr>
            <tr>
                <td> <label for="form">Customers's Last Name</label></td></td> <!--'-->
                <td> <input type="text" id="clname" name="clname" placeholder="Dover" required> </td> 
                <td><h6>REQUIRED</h6></td>
            </tr>
            <tr>
                <td> <label for="form">Customer's ID</label></td> <!--'-->
                <td> <input type="text" id="cidNum" name="cidNum" placeholder="12345678" required> </td> 
                <td><h6>REQUIRED</h6></td>
            </tr>
        </table>
        </form>
            <button id="submit" name="submit" onclick="validate()">Submit</button>
            <button id="reset" onclick="reset()">Reset</button>
        </div>

    <?php
        //check seller id
        if ($_SESSION['userInput']['idNum'] == "") {
            echo "<script>
                alert('Session timed out. Returning to sign in...');
                window.open('index.php', '_self');
            </script>";
        }
        
        //home button
        if (array_key_exists('home', $_POST)) { 
            header("Location:index.php");
            exit(); 
        }
                
        //on valid submission
        if ($_GET['validCusAcc'] == "true") {
            if (addCusAcc()) { 
                echo "<script>alert('".$_GET['cfname']." ".$_GET['clname']." has successfully been made an account.');</script>";
                //header("Location:sellerAccounts.php");
            }
            else {
                echo "<script>alert('Error: This Customer already exists.');</script>";
            }
        }
        
        //search for customer id
        function addCusAcc()
        {            
            
            //database credentials
            $servername = $_SESSION["sName"];
            $username = $_SESSION["uName"];
            $password = $_SESSION["pass"];
            $dbname = $_SESSION["dbName"];
            $con = mysqli_connect($servername,$username,$password,$dbname);

            if (mysqli_connect_errno()) {
                echo "<script>alert('Failed to connect to MySQL: ".mysqli_connect_error()."');</script>";
                return false;
            }
            
            $customerIds = mysqli_query($con, "SELECT customerId FROM `Customer_Information`");
            
            while ($row = $customerIds->fetch_assoc())
            {
                if ($row['customerId'] == $_GET['cidNum']) {
                    return false;
                }
            }
            
            //insert data
            $values = [$_GET['cfname'], $_GET['clname'], $_GET['cidNum']];
            $test = '"'. implode('", "', $values). '"';
            $query = "INSERT INTO Customer_Information (id, customerFirstName, customerLastName, customerId) VALUES ("."NULL,".$test.");";
            $insert = mysqli_query($con, $query);

            //print query
            echo "<script>console.log('".$query.");');</script>";
            
            //check if valid query
            if ($insert) {
                return true;
            }
        }
        
    ?>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="index.js"></script>
    
</body>
</html>


