<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>TSKB</title>

    <link rel="stylesheet" href="index.css">

</head>
<body class="newCus" onload="returnPage()">

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
        <h1>Return Book</h1>
        <p>Fill out the information below to reutrn a purchase.</p>

        <form id="form" action="" method="POST">
        <table id="inputFields">
            <tr>
                <td> <label for="form">Customer's ID</label></td> <!--'-->
                <td> <input type="text" id="cidNum" name="cidNum" placeholder="12345678" required> </td> 
                <td><h6>REQUIRED</h6></td>
            </tr>
            <tr>
                <td> <label for="form">Customer's Purchase ID</label></td> <!--'-->
                <td> <input type="text" id="purId" name="purId" placeholder="52873456" required> </td>
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
        if ($_GET['validReturn'] == "true") {
            if (returnBook()) {
                echo "<script>alert('Order ".$_GET['purId']." has successfully been returned.');</script>";
            }
            else {
                echo "<script>alert('Order ".$_GET['purId']." does not exist.');</script>";
            }
        }
        
        //search for purchase id
        function returnBook()
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
            
            $purchaseIds = mysqli_query($con, "SELECT purchaseID FROM `Payments`");
            
            while ($row = $purchaseIds->fetch_assoc())
            {
                if ($row['purchaseID'] == $_GET['purId']) {
                
                    //drop data
                    $query = mysqli_query($con, "DELETE FROM `Payments` WHERE purchaseID = ".$_GET['purId'].";");
                    
                    //print query
                    echo "<script>console.log('DELETE FROM `Payments` WHERE purchaseID = ".$_GET['purId']."');</script>";
        
                    if ($query) {
                        return true;
                    }
                }
            }
        }
    ?>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="index.js"></script>
    
</body>
</html>


