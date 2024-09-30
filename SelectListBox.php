<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=carRentals;charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   $sql = 'SELECT DISTINCT Make FROM MakeModels';


    $result = $pdo->query($sql);

    echo '<form action="display.php" method="POST">';
    echo 'Select a make'; 
    echo "<select name='Make'>";
    while ($row = $result->fetch()) {
        $bt = $row["Make"];
        echo "<option value='$bt'>" . $row["Make"] . '</option>';
       
    }
    echo '</select>';
    echo '<input type="submit" name="submitvalue">';
    echo '</form>';

} catch (PDOException | Exception $e) {
    $output = 'Unable to connect to the database server: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();
}
?>

