<?php
try { 
$pdo = new PDO('mysql:host=localhost;dbname=CarRentals; charset=utf8', 'root', ''); 
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'update Customers set Forename =:Forename, Surname =:Surname, Email =:Email WHERE CustID = :cid';
$result = $pdo->prepare($sql);
$result->bindValue(':cid', $_POST['ud_id']); 
$result->bindValue(':Forename', $_POST['ud_name']); 
$result->bindValue(':Surname', $_POST['ud_surname']); 
$result->bindValue(':Email', $_POST['ud_email']); 
$result->execute();
     
//For most databases, PDOStatement::rowCount() does not return the number of rows affected by a SELECT statement.
     
$count = $result->rowCount();
if ($count > 0)
{
echo "You just updated customers no: " . $_POST['ud_id'] ."  click<a href='selectupdate.php'> here</a> to go back or";
echo "<br>";
echo "click<a href='index.html'> here</a> to go back to the main page";
}
else
{
echo "nothing updated click<a href='selectupdate.php'> here</a> to go back and edit again or ";
echo "<br>";
echo "click<a href='index.html'> here</a> to go back to the main page";
}
}
 
catch (PDOException $e) { 

$output = 'Unable to process query sorry : ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine(); 

}
include 'updatedetails.html';
?>  
