<?php
try { 
    $pdo = new PDO('mysql:host=localhost;dbname=carRentals;charset=utf8', 'root', ''); 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM Customers';
    $result = $pdo->query($sql); 
?>

    <br><b>A Quick View</b><br><br>
    <table border="1">
        <tr>
            <th>User Id</th>
            <th>First Name</th>
            <th>Actions</th>
        </tr>

<?php 
    while ($row = $result->fetch()) {
?>
        <tr>
            <td><?php echo $row['CustID']; ?></td>
            <td><?php echo $row['Forename']; ?></td>
            <td>
                <a href="MakeRental.php?CustID=<?php echo $row['CustID']; ?>">Make Rental</a> |
                <a href="DeleteRental.html?CustID=<?php echo $row['CustID']; ?>">Cancel Rental</a> |
            </td>
        </tr>
<?php 
    }
?>
    </table>

<?php
} catch (PDOException $e) { 
    $output = 'Unable to connect to the database server: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine(); 
}
?>

