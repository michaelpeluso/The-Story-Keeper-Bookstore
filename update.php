<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>TSKB</title>

    <link rel="stylesheet" href="index.css">

</head>
<body class="newCus" onload="updatePage()">

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
        <h1>Update Purchase</h1>
        <p>Fill out the information below to update a purchase.</p>

        <form id="form" action="" method="POST">
        <table id="inputFields">
            <tr>
                <td> <label for="form">Customer's ID</label></td> <!--'-->
                <td> <input type="text" id="cidNum" name="cidNum" placeholder="12345678" required> </td> 
                <td><h6>REQUIRED</h6></td>
            </tr>
            <tr>
                <td> <label for="form">Customer's Purchase ID</label></td> <!--'-->
                <td> <input type="text" id="purId" name="purId" placeholder="56" required> </td>
                <td><h6>REQUIRED</h6></td>
            </tr>
            <tr>
                <td> <label for="form">Update In-store Purchase</label></td>
                <td> <input type="text" id="storePurUpdate" name="storePurUpdate" placeholder="Harry Potter $0.00" required> </td>
                <td><h6>REQUIRED (1/2)</h6></td>
            </tr>
            <tr>
                <td> <label for="form">Update Online Purchase</label></td>
                <td> <input type="text" id="onlPurUpdate" name="onlPurUpdate" placeholder="Romeo and Juliet $0.00" required> </td>
                <td><h6>REQUIRED (2/2)</h6></td>
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
        if ($_GET['validUpdate'] == "true") {
            if (findCustomer()) {
                if (updateOrder()) {
                    echo "<script>alert('Order ".$_GET['purId']." has successfully been updated.');</script>";
                }
                else {
                    echo "<script>alert('Error: Order ".$_GET['purId']." must maintain the same order type.');</script>";
                }
            }
            else {
                echo "<script>alert('Error: Order ".$_GET['purId']." does not exist.');</script>";
            }
        }
        
        //search for purchase id
        function findCustomer()
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
            
            //check if customer exists
            $query = "SELECT * FROM Payments WHERE purchaseID = ".$_GET['purId'];
            $queryCall = mysqli_query($con, $query);
            
            if (mysqli_num_rows($queryCall) > 0) {
                return true;
            }
        }
        
        //search for purchase id
        function updateOrder() 
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
            
            //check if customer exists
            $query = "SELECT * FROM Payments WHERE purchaseID = ".$_GET['purId'];
            $queryCall = mysqli_query($con, $query);
            
            while ($row = $queryCall->fetch_assoc())
            {
                echo "<script>console.log('".$_GET['storePurUpdate']." : ".$row['purhcase']."');</script>";
                echo "<script>console.log('".$_GET['onlPurUpdate']." : ".$row['online']."');</script>";
                
                if ($_GET['storePurUpdate'] != "" && $row['purhcase'] == "") {
                    return false;
                }
                if ($_GET['onlPurUpdate'] != "" && $row['online'] == "") {
                    return false;
                }
            }            
            
            //update order
            $query = "UPDATE `Payments` SET `purchase` = \"".$_GET['storePurUpdate']."\", `online` = \"".$_GET['onlPurUpdate']."\" WHERE purchaseID = ".$_GET['purId'].";";
            $queryCall = mysqli_query($con, $query);
            
            //print query
            echo "<script>console.log('".$query."');</script>";
            
            //check if valid query
            if ($queryCall) {
                return true;
            }
        }
        
    ?>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="index.js"></script>
    
</body>
</html>


