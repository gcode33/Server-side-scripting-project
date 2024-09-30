<?php
try { 
$pdo = new PDO('mysql:host=localhost;dbname=CarRentals; charset=utf8', 'root', ''); 
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql="SELECT count(*) FROM Customers WHERE CustID =:cid";

$result = $pdo->prepare($sql);
$result->bindValue(':cid', $_POST['id']); 
$result->execute();
if($result->fetchColumn() > 0) 
{
    $sql = 'SELECT * FROM Customers where CustID = :cid';
    $result = $pdo->prepare($sql); 
    $result->bindValue(':cid', $_POST['id']); 
    $result->execute();

    $row = $result->fetch() ;
     $id = $row['CustID'];
	 $Forename= $row['Forename']; 
	  $Surname=$row['Surname'];
    $Email=$row['Email'];
    $Phone_Num=$row['Phone_Num'];
    $Licence_Num=$row['Licence_Num'];

	  
  
	  
   
}

else {
      print "No rows matched the query. try again click<a href='selectupdate.php'> here</a> to go back";
    }} 
catch (PDOException $e) { 
$output = 'Unable to connect to the database server: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine(); 
}


include 'updatedetails.html';
?>
