<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>TSKB</title>

    <link rel="stylesheet" href="index.css">

</head>
<body class="purForm" onload="purFormPage()">

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
        <h1>Purchase Form</h1>
        <p>Fill out the information below correctly in order to submit a book order.</p>

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
            <tr>
                <td> <label for="form">Customer's In-store Purchase</label></td> <!--'-->
                <td> <input type="text" id="storePur" name="storePur" placeholder="Harry Potter $0.00" required> </td>
                <td><h6>REQUIRED (1/2)</h6></td>
            </tr>
            <tr>
                <td> <label for="form">Customer's Online Purchase</label></td> <!--'-->
                <td> <input type="text" id="onlPur" name="onlPur" placeholder="Romeo and Juliet $0.00" required> </td>
                <td><h6>REQUIRED (2/2)</h6></td>
            </tr>
            <tr>
                <td> <label for="form">Date and Time</label></td>
                <td> <input type="date" id="date" name="date" value="2022-12-01" required> </td>
                <td><h6>REQUIRED</h6></td>
            </tr>
            <tr>
                <td> <label for="form">Payment Type</label> </td>
                <td>
                    <select name="payType" id="payType">
                        <option value="CREDIT">Credit</option>
                        <option value="CASH">Cash</option>
                    </select>
                </td>
                <td><h6>REQUIRED</h6></td>
            </tr>
            <tr>
                <td> <label for="form">Order Type</label> </td>
                <td>
                    <select name="orderType" id="orderType">
                        <option value="In Store">In Store</option>
                        <option value="Online">Online</option>
                    </select>
                </td>
                <td><h6>REQUIRED</h6></td>
            </tr>
            <tr>
                <td> <label for="form">Credit Card Number</label></td>
                <td> <input type="text" id="cardNum" name="cardNum" placeholder="1234 5678 2345 6789" required> </td>
            </tr>
            <tr>
                <td> <label for="form">Shipping Address</label></td>
                <td> <input type="text" id="address" name="address" placeholder="323 MLK Blvd, Newark, NJ 07102" required> </td>
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
        if ($_GET['validPurchase'] == "true") {
            if (findCustomer()) {
                if (addPurchase()) {
                    echo "<script>alert('Successful purchase made by ".$_GET['cfname']." ".$_GET['clname'].".');</script>";
                    //header("Location:sellerAccounts.php");
                }
                else {
                    echo "<script>alert('Error: Unsuccessful purchase.".'\n'."Try signing in again.');</script>";
                }
            }
            else { //".'\n'.
                echo "<script>alert('Error: Customer not found.".'\n'."If this customer does not have an account, naviate to the `New Customer` tab to create one.');</script>";
            }
        }
                
                
        //find customer
        function findCustomer() {

            //database credentials
            $servername = $_SESSION["sName"];
            $username = $_SESSION["uName"];
            $password = $_SESSION["pass"];
            $dbname = $_SESSION["dbName"];
            $con = mysqli_connect($servername,$username,$password,$dbname);
            
            $cusRecords = mysqli_query($con, 'SELECT * FROM `Customer_Information` WHERE customerId = '.$_GET['cidNum']);
            while ($row = $cusRecords->fetch_assoc()) 
            {
                $fnameMatch = ($_GET['cfname'] == $row['customerFirstName']);
                $lnameMatch = ($_GET['clname'] == $row['customerLastName']);
                $idMatch = ($_GET['cidNum'] == $row['customerId']);
                
                if ($fnameMatch && $lnameMatch && $idMatch) {
                    return true; //customer found
                }
            }
            return false;
        }
        
        
        //check user authentication
        function addPurchase()
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
            
            //new purchase id
            $purchaseIds = mysqli_query($con, "SELECT purchaseID FROM `Payments`");
            $purId = rand(10000000, 99999999);
            
            while ($row = $purchaseIds->fetch_assoc()) {
                if ($purId == $row['purchaseID']) {
                    $purchaseIds = mysqli_query($con, "SELECT purchaseID FROM `Payments`");
                }  
            }
        
            //setup input values
            array_shift($_GET);
            $payments = [
                $_GET['cfname'],
                $_GET['clname'],
                $purId,
                $_GET['cidNum'],
                $_SESSION['userInput']['idNum'],
                $_GET['storePur'],
                $_GET['onlPur'],
                $_GET['date'],
                $_GET['orderType'],
                $_GET['payType']."".$_GET['cardNum'], 
                $_GET['address']
            ];
            
            $paymentsInsert = '"'. implode('", "', $payments). '"';
            
            //insert data
            $insert = mysqli_query($con, "INSERT INTO `Payments` (
                id, 
                firstNameCust, 
                lastNameCust, 
                purchaseID, 
                customerID, 
                sellerId, 
                purchase, 
                online, 
                date, 
                orderType, 
                paymentType, 
                address) 
                VALUES ("."NULL,". $paymentsInsert .");");
            
            //print sql query
            echo "<script>console.log('INSERT INTO `Payments` (id, firstNameCust, lastNameCust, purchaseID, customerID, sellerId, purchase, online, date, orderType, paymentType, address) VALUES (". $paymentsInsert .");');</script>";
            
            //checl if query is valid
            if ($insert) {
                return true;
            }
            else {
                return false;
            }

        }
        
    ?>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="index.js"></script>
    
</body>
</html>


