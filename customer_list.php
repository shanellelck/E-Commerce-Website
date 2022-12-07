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

    $select_customers = "SELECT * FROM CUSTOMER;";
    $customers = $conn->query($select_customers);
?>


  
    <div class ="small-container customer-page" style = "margin: 80px auto">
    <h1 class="title">Customers</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Email Address</th>
            <th>Name</th>
            <th>Phone Number</th>
            <th style="text-align: center">Address</th>
            <th style="text-align: center">Update</th>
        </tr>   
        
        <?php 
            while($customer = mysqli_fetch_assoc($customers)):
        ?>   
        <tr>
        
            <?php 
            $id = $customer['ID'];
            $email = $customer['Email']; 
            $name = $customer['Name']; 
            
            if($customer['Phone_Num'] ==""){
                $phone_number = "N/A";
            }else{
                $phone_number = $customer['Phone_Num']; 

            }

            if ($customer['Street_Num'] == "" && $customer['Street_Name'] == "" &&
            $customer['City'] == "" && $customer['Province'] == "" && $customer['Postal_Code'] == "" && $customer['Country'] == ""){
                $address = "N/A";
            }else{
                $address = $customer['Street_Num']. ', ' .$customer['Street_Name']. ', ' .
                $customer['City']. ', ' .$customer['Province']. ', ' .$customer['Postal_Code']. ', ' .$customer['Country'];
            }
            ?>
           
            <td> <?= $id?></td>
            <td> <?= $email?></td>
            <td> <?= $name?></td>
            <td> <?= $phone_number?></td>
            <td style="text-align: center"> <?= $address?></td>
            <td style="text-align: center"> 
            <a href="update_customer.php?email=<?php echo $email ?>" button type="button" class="btn">Update</button></a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    </div>
</body>
</html>