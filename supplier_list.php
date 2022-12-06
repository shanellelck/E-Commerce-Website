<?php include "header.php" ?>
<?php include "connection.php" ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="style-list.css">

</head>
<body>
<?php 
    session_start();
   
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
    }else{
        $user_id ='';
        header('location:index.php');
    }

    $select_suppliers = "SELECT * FROM SUPPLIER;";
    $suppliers = $conn->query($select_suppliers);
?>


  
    <div class ="small-container customer-page" style = "margin: 80px auto">
    <h1 class="title">Suppliers</h1>
    <table>
        <tr>
            <th>Name</th>
            <th>Email Address</th>
            <th>Phone Number</th>
            <th style="text-align: center">Address</th>
        </tr>   
        
        <?php 
            while($supplier = mysqli_fetch_assoc($suppliers)):
        ?>   
        <tr>
        
            <?php 
            $name = $supplier['Name'];
            $email = $supplier['Email']; 
            
            if($supplier['Phone_number'] ==""){
                $phone_number = "N/A";
            }else{
                $phone_number = $supplier['Phone_number']; 

            }

            if ($supplier['Street_number'] == "" && $supplier['Street_name'] == "" &&
            $supplier['City'] == "" && $supplier['Province'] == "" && $supplier['Postal_Code'] == "" && $supplier['Country'] == ""){
                $address = "N/A";
            }else{
                $address = $supplier['Street_number']. ', ' .$supplier['Street_name']. ', ' .
                $supplier['City']. ', ' .$supplier['Province']. ', ' .$supplier['Postal_Code']. ', ' .$supplier['Country'];
            }
            ?>
           
            <td> <?= $name?></td>
            <td> <?= $email?></td>
            <td> <?= $phone_number?></td>
            <td style="text-align: center"> <?= $address?></td>

        </tr>
        <?php endwhile; ?>
    </table>
    </div>
</body>
</html>