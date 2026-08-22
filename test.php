<?php
include("pages/Connection.php");

echo "Connected successfully!<br><br>";

$result = mysqli_query($conn, "SELECT * FROM products");

$count = mysqli_num_rows($result);
echo "Number of products: " . $count . "<br><br>";

while ($row = mysqli_fetch_assoc($result)) {
    echo $row['P_Name'] . " - " . $row['P_Price'] . " SAR<br>";
}
?>