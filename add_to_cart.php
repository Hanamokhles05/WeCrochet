<?php
// Zainab Ali Alfaraj 2240006683

session_start();
include("includes/Connection.php");

if (isset($_POST['quick_add'])) {

    $id = (int) $_POST['id'];
    $qty = (int) $_POST['quantity'];

    $result = mysqli_query($conn, "SELECT * FROM products WHERE P_ID = $id");
    $product = mysqli_fetch_assoc($result);

    if ($product && $qty > 0 && $qty <= $product['P_Stock']) {

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        $found = false;

        foreach ($_SESSION['cart'] as &$item) {

            if ($item['id'] == $id) {

                $new_qty = $item['quantity'] + $qty;

                if ($new_qty <= $product['P_Stock']) {
                    $item['quantity'] = $new_qty;
                }

                $found = true;
                break;
            }
        }

        if (!$found) {

            $_SESSION['cart'][] = array(
                'id' => $product['P_ID'],
                'name' => $product['P_Name'],
                'price' => $product['P_Price'],
                'image' => $product['P_Image'],
                'quantity' => $qty,
                'stock' => $product['P_Stock']
            );
        }
    }

    mysqli_close($conn);
    header("Location: products.php");
    exit();
}
?>