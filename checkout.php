<?php

$servername = getenv('IP');

$username = getenv('C9_USER');
$password = "";
$database = "Products";
$dbport = 3306;

//Create connection
$db = new mysqli($servername, $username, $password,$database,$dbport);

//Check Connection
if ($db->connect_error){
    die("Connection failed: " . $db->connect_error);
}


//check for customer in database
$check_customer = "SELECT * FROM Customers WHERE name='".$_POST['name']."' LIMIT 1";
$customer_result= mysqli_query($db,$check_customer);

echo "POST(".$_POST['name'].")";
$r = mysqli_fetch_assoc($customer_result);
echo "DATA(".$r['name'].")";
if($_POST['name'] == $r['name']){
    echo "In database";
}else{
    $query_project = "INSERT INTO Customers VALUES ('".$_POST['name']."','".$_POST['address']."','".$_POST['city']."','".$_POST['province']."','".$_POST['email']."','".$_POST['ccnum']."')";
    mysqli_query($db,$query_project);
    echo "not in data";
}





$items = $_POST['items'];
//remove quotation marks from begining and end, would cause whole thing to be string
$items = substr($items,1,strlen($items)-2);
//delete all '\', wild card cancel out " being interpreted as code
$items = str_replace('\\','',$items);
//JSON.parse(...), true-> convert into arrays, false(default)->convert into objects
$final = json_decode($items,true);

/*


for ($i=0;$i<sizeof($final);$i++){
    $item = $final[$i];
    print $item['itemPrice'];
    print "(".$i.")";
    $insert_query = "INSERT INTO Transactions (customerName,productName,date,price) VALUES ('".$_POST['name']."','".$item["itemDescription"]."','".date("dMY")."','".$item['itemPrice']."')";
    //print $insert_query;
    mysqli_query($db,$insert_query);
    
    
    
    
    
    //good practice? should query the database for price of item, but lazy.
    // $query_project = "SELECT * FROM Products WHERE itemDescription='".$item["itemDescription"]." LIMIT 1'";
    // $qItem = mysqli_query($db,$query_project);
    // while($r = mysqli_fetch_assoc($qItem)){
    // //    echo "R(".$r['itemPrice'].")";
    // }
    //echo $item["itemPrice"];
}
?>
