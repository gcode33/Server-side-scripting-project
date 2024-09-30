<?php
if (isset($_POST['submitdetails'])) {
    try {
        // Validate TypeCode
        if ($_POST['TypeCode'] == "" || strlen($_POST['TypeCode']) != 2 || is_numeric($_POST['TypeCode'])) {
            echo "Invalid Type code. Please try again.<br>";
        } else {
            $tc = $_POST['TypeCode'];

            // Validate Type_Description
            if ($_POST['Type_Description'] == "" || strlen($_POST['Type_Description']) > 10|| is_numeric($_POST['Type_Description'])) {
                echo "Invalid Type Description. Please try again.<br>";
            } else {
                $description = $_POST['Type_Description'];

                // Validate Rate
                $rate = $_POST['Rate'];
                if (!is_numeric($rate)) {
                    echo "Invalid Rate. Please try again.<br>";
                } else {
                    // Database connection and insertion code
                    $pdo = new PDO('mysql:host=localhost;dbname=CarRentals; charset=utf8', 'root', '');
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $sql = "INSERT INTO cartypes (TypeCode,Type_Description, Rate) VALUES(:TypeCode, :Type_Description, :Rate)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindValue(':TypeCode', $tc);
                    $stmt->bindValue(':Type_Description', $description);
                    $stmt->bindValue(':Rate', $rate);
                    $stmt->execute();

                    echo "Added a car type. Try adding another.<br>";
                    echo "or click <a href='index.html'>here</a> to go back to the main page";
                }
            }
        }
    } catch (PDOException $e) {
        $output = 'Unable to connect to the database server: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();
    }
}
include 'add_cartype_form.html';
?>



