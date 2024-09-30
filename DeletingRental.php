<?php
try {

$pdo = new PDO('mysql:host=localhost;dbname=CarRentals; charset=utf8', 'root', '');

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = 'DELETE FROM Rentals WHERE Rental_Number = :RN';

$result = $pdo->prepare($sql);

$result->bindValue(':RN', $_POST['RN']);

$result->execute();

echo "You just deleted a rental for the rental no: " . $_POST['RN'] ." \n click<a href='deleteform.html'> here</a> to go back and delete another ";
echo "<br>";
echo "Or click<a href='index.html'> here</a> to go back to the main page ";

}

catch (PDOException $e) {

if ($e->getCode() == 23000) {

echo "ooops couldnt delete as that record is linked to other tables click<a href='deleteform.html'> here</a> to go back ";

}

}


?>