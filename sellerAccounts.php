<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>TSKB</title>

    <link rel="stylesheet" href="index.css?v=<?php echo time(); ?>">

</head>
<body class="sellerAccounts" onload="sellerAccountsPage()">

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
        <h1>Bookseller Records</h1>
        <p>All information regarding the respective bookseller.</p>
    
    <?php
    
        //check seller id
        if ($_SESSION['userInput']['idNum'] == "") {
            echo "<script>alert('Session timed out. Returning to sign in...');</script>";
        }
        

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
      
        //gather table data
        $idNum = $_SESSION['userInput']['idNum'];
        $joinedTable = mysqli_query($con, 
            'SELECT * FROM `Sellers` 
            INNER JOIN `Payments` 
                ON Sellers.sellerId = '. $idNum .' AND Payments.sellerId = '. $idNum
        );
        
        //open table fails
        if (!$joinedTable) {
            echo "Failed to find tables";
        }
        
        //create html table
        echo "<table id=\"table_forms\">";
        
        $columnHeaders = array(
            "BookSeller's First Name", 
            "BookSeller's Last Name", 
            "BookSeller's ID Number", 
            "BookSeller's Phone Number", 
            "BookSeller's Phone Email", 
            "Customer's First Name", 
            "Customer's Last Name", 
            "Purchase ID",
            "Customer's ID", 
            "Customer's In Store Purchase", 
            "Customer's Online Purchase", 
            "Date and Time", 
            "Order Type",
            "Payment Type", 
            "Shipping Address"
        );
        
        //print column names
        echo "<tr>";
            foreach ($columnHeaders as $title) {
                echo "<th>". $title ."</th>";
            }
        echo "</tr>";
        
        //print values
        while ($row = $joinedTable->fetch_assoc())
        {
            $column = 0;
            echo "<tr>";
                foreach ($row as $cell) 
                {
                    $column++;
                    if ($column == 1 || $column == 4) {
                        continue; 
                    }
                    echo "<td>". $cell ."</td>";
                }
            echo "</tr>";
            }
        
        //onclick functions
        if (array_key_exists('home', $_POST)) { 
            header("Location:index.php"); 
            exit(); 
        }
        
        //print query
        echo "<script>console.log('SELECT * FROM `Sellers` INNER JOIN `Payments` ON Sellers.sellerId = ". $idNum ." AND Payments.sellerId = ". $idNum."');</script>";
        
    ?>
        
        </table>
    </div>   
    
    <div id="footer"></div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="index.js"></script>

</body>
</html>