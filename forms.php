<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>TSKB</title>

    <link rel="stylesheet" href="index.css?v=<?php echo time(); ?>">

</head>
<body class="forms" onload="formsPage()">
    
    <form id="buttons" method="post">
    <ul id="nav">
      <li><button id="home" name="home">Home</button></li>
      <li><button id="infoTbl" name="infoTbl">Customer Information</button></li>
      <li><button id="paymentsTbl" name="paymentsTbl">Payments</button></li>
      <li><button id="sellersTbl" name="sellersTbl">Sellers</button></li>
    </ul>
    </form>
    
    <?php
    
        //print table
        function printTable($tableName) 
        {
            //table title
            echo '<h1 style="display: flex; justify-content: center;">'. str_replace('_', ' ', $tableName) .'</h1>';
            echo '<div id="container">';
        
            //database credentials
            $servername = $_SESSION["sName"];
            $username = $_SESSION["uName"];
            $password = $_SESSION["pass"];
            $dbname = $_SESSION["dbName"];
            $con = mysqli_connect($servername,$username,$password,$dbname);
          
            //open database
            if (mysqli_connect_errno()) {
                echo "<script>alert('Failed to connect to MySQL: " . mysqli_connect_error()."');</script>";
            }
          
            //gather table data
            $columns = 'SELECT column_name FROM information_schema.columns WHERE table_schema = \'mp272\' AND table_name = \''. $tableName .'\'';
            $sql = 'SELECT * FROM '. $tableName;
            $cols1 = $cols2 = mysqli_query($con, $columns);
            $records = mysqli_query($con, $sql);
            
            //open table fails
            if (!$records || !$cols1) {
                echo "Failed to find table";
            }
            
            //create html table
            echo "<table id=\"table_forms\" style=\"padding: 1%; display: flex; justify-content: center;\">"; //overflow: scroll; height: 50%;\">";
            
            //print column names
            echo "<tr>";
            while ($col = $cols1->fetch_assoc())
            {   
                //add space
                $colName = $col['COLUMN_NAME'];
                for ($i = 1; $i < strlen($colName); $i++) {
                    if (ctype_upper($colName[$i])) {
                        $colName = substr_replace($col['COLUMN_NAME'], ' ', $i - 1, 0); 
                    }
                }
                
                echo "<th>". $colName ."</th>";
            }
            echo "</tr>";
            
            //print values
            while ($row = $records->fetch_assoc())
            {
            echo "<tr>";
                foreach ($cols2 as $col) 
                {
                    echo "<td>" . $row[$col['COLUMN_NAME']] . "</td>";
                }
            echo "</tr>";
            }
        }
        
        //onclick functions
        if (array_key_exists('home', $_POST)) { 
            header("Location:index.php"); 
            exit(); 
        }
        if (array_key_exists('infoTbl', $_POST)) {   
            printTable('Customer_Information'); 
        }
        if (array_key_exists('orderTbl', $_POST)) { 
            printTable('Customer_Order');
        }
        if (array_key_exists('paymentsTbl', $_POST)) { 
            printTable('Payments');
        }
        if (array_key_exists('sellersTbl', $_POST)) { 
            printTable('Sellers');
        }
        
    ?>
        
        </table>
    </div>   
    
    <div id="footer"></div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="index.js"></script>

</body>
</html>