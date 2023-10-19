<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>TSKB</title>

    <link rel="stylesheet" href="index.css">
    
    

</head>
<body class="index" onload="indexPage()">

    <div id="container">
        <h1>The Story Keeper Bookstore</h1>

        <form id="form">
        <table id="inputFields">
            <tr>
                <td> <label for="form">Book Seller's First Name</label> </td>
                <td style="width: 45%"><input type="text" id="fname" name="fname" placeholder="Ben" required></td>
                <td><h6>REQUIRED</h6></td>
            </tr>
            <tr>
                <td> <label for="form">Book Seller's Last Name</label></td>
                <td><input type="text" id="lname" name="lname" placeholder="Dover" required></td>
                <td><h6>REQUIRED</h6></td>
            </tr>
            <tr>
                <td> <label for="form">Book Seller's Password</label> </td>
                <td><input type="password" id="pass" name="pass" placeholder="&#x2022&#x2022&#x2022&#x2022&#x2022&#x2022&#x2022&#x2022" required> </td>
                <td><h6>REQUIRED</h6></td>
            </tr>
            <tr>
                <td> <label for="form">Book Seller's ID</label></td>
                <td><input type="text" id="idNum" name="idNum" placeholder="12345678" required></td>
                <td><h6>REQUIRED</h6></td>
            </tr>
            <tr>
                <td> <label for="form">Book Seller's Phone Number</label></td>
                <td><input type="text" id="phone" name="phone" placeholder="9735551234" required></td>
                <td><h6>REQUIRED</h6></td>
            </tr>
            <tr>
                <td> <label for="form">Book Seller's Email</label></td>
                <td> <input type="text" id="email" name="email" placeholder="example@tskb.com"></td>
            </tr>
            <tr>
                <td colspan="2" style="line-height: 2;">
                    <input type="checkbox" id="emailConfirmation" name="emailConfirmation">
                    <label for="form">Check box to request email confirmation</label>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <label for="transactions">Select a transaction</label>
                    <br>
                    <select name="transactions" id="transactions">
                        <option value="none" selected disabled hidden>Select Transaction Option</option>
                        <option value="sellerAccounts">Search A Bookseller's Records</option> <!-- '-->
                        <option value="purchaseForm">Make A Customer's Book Purchase</option> <!-- '-->
                        <option value="return">Return A Customer's Book Order</option> <!-- '-->
                        <option value="update">Update A Customer's Book Order</option> <!-- '-->
                        <option value="cancel">Cancel A Customer's Book Order</option> <!-- '-->
                        <option value="newCustomer">Create A New Customer Account</option>
                    </select>
                </td>
            </tr>
        </table>
        </form>

        <form id="buttonForm" action="" method="POST" style="display: inline;">  
        </form>
            <button id="submit" onclick="validate()">Submit</button>   
            <button id="reset" onclick="reset()">Reset</button>
            <button id="forms" onclick="openForms()">Forms</button>
        
    </div>

    <?php
        
        //information validated
        if ($_GET['valid'] == "true") {
        
            $_SESSION['sellerId'] = $_SESSION['userInput']['idNum'];
            $_SESSION['userInput'] = array();
            foreach($_GET as $key => $value){
                $_SESSION['userInput'][$key] = $value;
            }
            
            //call authorization function
            if (authorize($_SESSION['userInput'])) {
                $transactions = array(
                    "sellerAccounts" => "Search A Bookseller\'s Records", 
                    "purchaseForm" => "Make A Customer\'s Book Purchase", 
                    "return" => "Return A Customer\'s Book Order", 
                    "update" => "Update A Customer\'s Book Order", 
                    "cancel" => "Cancel A Customer\'s Book Order", 
                    "newCustomer" => "Create A New Customer Account"
                );
                echo "<script>alert('Welcome ".$_SESSION['userInput']['fname']." ".$_SESSION['userInput']['lname'].", preforming transaction: ".'\n'.$transactions[$_SESSION['userInput']['transactions']]."');</script>";
                echo '<script>window.open("'.$_SESSION['userInput']['transactions'].'.php?idNum='. $_SESSION['userInput']['idNum'] .'", "_self");</script>';
            }
            else {
                echo "<script>alert('Error: No Seller found with the given credentials.');</script>";
            }
        }
        
        //check user authentication
        function authorize($userInput)
        {    
            
            //database credentials
            $servername = $_SESSION["sName"];
            $username = $_SESSION["uName"];
            $password = $_SESSION["pass"];
            $dbname = $_SESSION["dbName"];
            $con = mysqli_connect($servername,$username,$password,$dbname);
            
            //open database
            if (mysqli_connect_errno()) {
                echo "<script>alert('Failed to connect to MySQL: ".mysqli_connect_error()."');</script>";
                return false;
            }
            
            //gather data
            $sellerRow = mysqli_query($con, 'SELECT * FROM `Sellers` WHERE `sellerId` = '.$userInput['idNum']);
            if (!$sellerRow) { return false; }
            $sellerRow = $sellerRow->fetch_assoc();
            
            //cross-check data with input
            $email = true;
            if ($userInput['email'] == "") { $email = false; }
            if (
                $userInput['fname'] == $sellerRow['firstName'] &&
                $userInput['lname'] == $sellerRow['lastName'] &&
                $userInput['pass'] == $sellerRow['password'] &&
                $userInput['idNum'] == $sellerRow['sellerId'] &&
                $userInput['phone'] == $sellerRow['phone'] &&
                ($userInput['email'] == $sellerRow['email'] || !$email)
            ) {
                return true;
            }
            else { return false; }
        }
    ?>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="index.js"></script>

</body>
</html>


