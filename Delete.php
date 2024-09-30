<?php
if (isset($_POST['submitdetails'])) {
    try {
        // Database connection
        $pdo = new PDO('mysql:host=localhost;dbname=CarRentals; charset=utf8', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $regNum = $_POST['RN'];
        // Check if RegNum exists in the database
        $sql = 'SELECT * FROM cars where RegNum = :RN';
        $result = $pdo->prepare($sql);
        $result->bindValue(':RN', $regNum);
        $result->execute();

        if ($result->fetchColumn() > 0) {
            // If RegNum exists, display confirmation for deletion
            echo "Are you sure you want to delete this car?<br>";
            

            $sql = 'SELECT * FROM cars where RegNum = :RN';
            $result = $pdo->prepare($sql);
            $result->bindValue(':RN', $regNum);
            $result->execute();

            while ($row = $result->fetch()) {
                echo $row['RegNum'] . ' ' . $row['Car_Make'] . ' ' . $row['Car_Model'] .
                    '<form action="DeletingCars.php" method="post">
                        <input type="hidden" name="RegNum" value="">
                        <input type="submit" value="yes delete" name="delete">
                    </form>';
            }

            // Display message and links only if the "delete" button is clicked
        } else {
            // If RegNum doesn't exist, display an error message
            echo "The provided RegNum does not exist.<br>";
            echo "Click <a href='deleteCar.html'>here</a> to go back and try again.";
        }
    } catch (PDOException $e) {
        $output = 'Unable to connect to the database server: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();
    } 
}
?>


