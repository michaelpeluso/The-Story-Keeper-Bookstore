<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>TSKB</title>

    <link rel="stylesheet" href="index.css">

</head>
<body class="newCus" onload="cancelPage()">

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
        <h1>Cancel Book</h1>
        <p>Fill out the information below to cancel an online purchase.</p>

        <form id="form" action="" method="POST">
        <table id="inputFields">
            <tr>
                <td> <label for="form">Customer's ID</label></td> <!--'-->
                <td> <input type="text" id="cidNum" name="cidNum" placeholder="12345678" required> </td> 
                <td><h6>REQUIRED</h6></td>
            </tr>
            <tr>
                <td> <label for="form">Customer's Purchase ID</label></td> <!--'-->
                <td> <input type="text" id="purId" name="purId" placeholder="94106606" required> </td>
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
        if ($_GET['validCancel'] == "true") {
            if (cancelBook()) {
                echo "<script>alert('Order ".$_GET['purId']." has successfully been cancelled.');</script>";
            }
            else {
                echo "<script>alert('Error: Order ".$_GET['purId']." does not exist or is not currently in transaction.');</script>";
            }
        }
        
        //search for purchase id
        function cancelBook()
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
            
            $purchaseIds = mysqli_query($con, "SELECT * FROM `Payments` WHERE purchaseID = ".$_GET['purId']);
            
            while ($row = $purchaseIds->fetch_assoc())
            {
            
                if ($row['online'] != "") {
                
                    //drop data
                    $query = mysqli_query($con, "DELETE FROM `Payments` WHERE purchaseID = ".$_GET['purId']);
                    
                    //print query
                    echo "<script>console.log('DELETE FROM `Payments` WHERE purchaseID = ".$_GET['purId']."');</script>";
            
                    //check if valid query
                    if ($query) {
                        return true;
                    }
                }
            }
        }
        
        
    //https://web.njit.edu/~mp272/IT_202/Assignment4/purchaseForm.php?validPurchase=true&cfname=Matthew&clname=Francescutto&cidNum=14056660&storePur=&onlPur=Diary%20of%20a%20Wimpy%20Kid%20$19.12&date=2022-12-15&payType=CASH&orderType=In%20Store&cardNum=&address=553%20Richfield%20Ave,%20Kenilworth,%20NJ
    ?>    
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="index.js"></script>
    
</body>
</html>


