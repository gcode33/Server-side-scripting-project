<?php

if (isset($_POST['submitdetails'])) {

    try {
        $pdo = new PDO('mysql:host=localhost;dbname=CarRentals; charset=utf8', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $rentNum = $_POST['RN'];

        $sql = 'SELECT * FROM Rentals where Rental_Number = :RN';
        $result = $pdo->prepare($sql);
        $result->bindValue(':RN', $rentNum); // Corrected field name
        $result->execute();

        if ($result->fetchColumn() > 0) {
            $sql = 'SELECT * FROM Rentals where Rental_Number = :RN';
            $result = $pdo->prepare($sql);
            $result->bindValue(':RN', $rentNum); // Corrected field name
            $result->execute();

            while ($row = $result->fetch()) {
                echo $row['Rental_Number'] . ' ' . $row['RegNum'] . ' ' . $row['RentStart'] . ' ' . $row['ReturnDate'] . '  ' . $row['CustID'] . ' Are you sure you want to delete ??' .

                    '<form action="DeletingRental.php" method="post"> 
                        <input type="hidden" name="Rental_Number" value="'.$row['Rental_Number'].'"> 
                        <input type="submit" value="yes delete" name="delete">
                    </form>';
            }

        } else {
            echo "The provided Rental Number does not exist.<br>";
            echo "Click <a href='DeleteRental.html'>here</a> to go back and try again.";
        }
    } catch (PDOException $e) {
        $output = 'Unable to connect to the database server: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();
    }
}

?>

