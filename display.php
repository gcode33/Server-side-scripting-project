<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=carRentals;charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve all rows for the selected make
    $make = $_POST['Make'];
    $sql = "SELECT * FROM MakeModels WHERE Make = :make";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':make', $make);
    $stmt->execute();

    // Display all rows
    echo '<h2>Details of the selected Make</h2>';
    echo '<table border="1">';
    echo '<tr><th>Make</th><th>Model</th><th>Fuel Type</th></tr>';

    // Fetch and display rows
    while ($row = $stmt->fetch()) {
        echo '<tr>';
        echo '<td>' . $row['Make'] . '</td>';
        echo '<td>' . $row['Model'] . '</td>';
        echo '<td>' . $row['Fuel_Type'] . '</td>';
        echo '</tr>';
    }

    echo '</table>';

    echo "<br>";
    echo "click <a href='SelectListBox.php'>here</a> to go back ";

} catch (PDOException | Exception $e) {
    $output = 'Unable to connect to the database server: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();
}
?>







