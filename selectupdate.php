<?php
try { 
    $pdo = new PDO('mysql:host=localhost;dbname=CarRentals;charset=utf8', 'root', ''); 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM Customers';
    $result = $pdo->query($sql); 
?>

    <b>A Quick View</b><br><br>
    <table border="1">
        <tr>
            <th>User Id</th>
            <th>Name</th>
            <th>Email</th>
        </tr>
  
<?php
    while ($row = $result->fetch()):
?>
        <tr>
            <td><?php echo $row['CustID']; ?></td>
            <td><?php echo $row['Forename'] . ' ' . $row['Surname']; ?></td>
            <td><?php echo $row['Email']; ?></td>
        </tr>
<?php
    endwhile;
?>
    </table>

<?php
} 
catch (PDOException $e) { 
    $output = 'Unable to connect to the database server: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine(); 
}

include 'whotoupdate.html';
?>


