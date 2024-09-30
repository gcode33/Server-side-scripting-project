<?php
//find a way to make set the car status to U after the submission
try {
    $pdo = new PDO('mysql:host=localhost;dbname=CarRentals;charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Fetch Type Codes
    $sqlTC = 'SELECT TypeCode FROM CarTypes';
    $resultTC = $pdo->query($sqlTC);
    $typeOptions = '';
    while ($rowTC = $resultTC->fetch()) {
        $TC = $rowTC["TypeCode"];
        echo "<option value='$TC'>" . $rowTC["TypeCode"] . '</option>';
    }
    
    // Fetch Customer IDs
    $sqlCID = 'SELECT CustID FROM Customers';
    $resultCID = $pdo->query($sqlCID);
    $custIdOptions = '';
    while ($rowCID = $resultCID->fetch()) {
        $CID = $rowCID["CustID"];
        echo "<option value='$CID'>" . $rowCID["CustID"] . '</option>';
        }


    // Check if form submitted
    if (isset($_POST['submitdetails'])) {
        $RS = $_POST['RentStart'];
        $RD = $_POST['ReturnDate'];
        $RST = $_POST['RentStartTime'];
        $RET = $_POST['RentEndTime'];
        $CustID = $_POST['CustID'];
        $TypeCode = $_POST['TypeCode'];

        // Check if all required fields are filled
    if ($_POST['TypeCode'] == "" || $_POST['RentStart'] == "" || $_POST['ReturnDate'] == ""  || $_POST['RentStartTime'] == ""  || $_POST['RentEndTime'] == ""  || $_POST['CustID'] == "") {
          echo "Please fill in all required fields.";
        }
        else{


        // Calculate the number of days the customer is renting
        $start = new DateTime($RS);
        $end = new DateTime($RD);
        $interval = $start->diff($end);
        $rentalDays = $interval->days + 1; // Adding 1 to include the last day
        
        // Retrieve the rate for the car type
        $sqlRate = "SELECT Rate FROM CarTypes WHERE TypeCode = :TypeCode";
        $stmtRate = $pdo->prepare($sqlRate);
        $stmtRate->bindValue(':TypeCode', $TypeCode);
        $stmtRate->execute();
        $rate = $stmtRate->fetch();

        // Calculate the amount
        $amount = $rate * $rentalDays;

        // Fetch available registration numbers for the selected car type and dates
        $sqlRN = "SELECT Cars.RegNum, Cars.Car_Make, Cars.Car_Model, Cars.TypeCode, CarTypes.Rate 
                  FROM Cars 
                  INNER JOIN CarTypes ON Cars.TypeCode = CarTypes.TypeCode 
                  WHERE Cars.TypeCode = :TypeCode 
                  AND Cars.RegNum NOT IN (
                      SELECT DISTINCT RegNum 
                      FROM Rentals 
                      WHERE (RentStart <= :endDate AND ReturnDate >= :startDate)
                      OR (RentStart <= :startDate AND ReturnDate >= :startDate)
                      OR (RentStart BETWEEN :startDate AND :endDate)
                      OR (ReturnDate BETWEEN :startDate AND :endDate)
                  )";
        $stmtRN = $pdo->prepare($sqlRN);
        $stmtRN->bindValue(':TypeCode', $TypeCode);
        $stmtRN->bindValue(':startDate', $RS);
        $stmtRN->bindValue(':endDate', $RD);
        $stmtRN->execute();


        // Fetch available cars
        $regNumOptions = '';
        while ($rowRN = $stmtRN->fetch()) {
            $RN = $rowRN["RegNum"];
            echo "<option value='$RN'>" . $rowRN["RegNum"] . '</option>';
        }

        // Insert data into Rentals table
        $sqlInsert = "INSERT INTO Rentals (RentStart, ReturnDate, RentStartTime, RentEndTime, RegNum, TypeCode, CustID, Amount) 
                      VALUES(:RentStart, :ReturnDate, :RentStartTime, :RentEndTime, :RegNum, :TypeCode, :CustID, :Amount)";
        $stmtInsert = $pdo->prepare($sqlInsert);
        $stmtInsert->bindValue(':RentStart', $RS);
        $stmtInsert->bindValue(':ReturnDate', $RD);
        $stmtInsert->bindValue(':RentStartTime', $RST);
        $stmtInsert->bindValue(':RentEndTime', $RET);
        $stmtInsert->bindValue(':RegNum', $_POST['RegNum']);
        $stmtInsert->bindValue(':TypeCode', $TypeCode);
        $stmtInsert->bindValue(':CustID', $CustID);
        $stmtInsert->bindValue(':Amount', $amount);
        $stmtInsert->execute();

        echo "You just made a rental for customer no: $CustID. Click <a href='Rental.php'>here</a> to go back.";
        echo "<br>";
        echo "or Click <a href='index.html'>here</a> to go back to the main page.";
        }
    } 
}
catch (PDOException $e) {
        $output = 'Unable to connect to the database server: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();
} 



include 'MakeRentalForm.html';
?>

