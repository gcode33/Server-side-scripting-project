<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=CarRentals;charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['makeName'])) {
        $makeName = $_POST['makeName'];
        $sql = 'SELECT * FROM makemodels WHERE Make = :cmake';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':cmake', $makeName);
        $stmt->execute();

        $rowCount = $stmt->rowCount();
        if ($rowCount > 0) {
            echo "<h2>Details of the selected Make: $makeName</h2>";
            echo '<table border="1">';
            echo '<tr><th>Make</th><th>Model</th><th>Fuel Type</th></tr>';

            // Loop through each row and display the details
            while ($row = $stmt->fetch()) {
                echo '<tr>';
                echo '<td>' . $row['Make'] . '</td>';
                echo '<td>' . $row['Model'] . '</td>';
                echo '<td>' . $row['Fuel_Type'] . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo "No rows matched the query.";
        }
    }
} catch (PDOException $e) {
    $output = 'Unable to connect to the database server: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();
}
?>


