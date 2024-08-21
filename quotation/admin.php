<?php
include('db.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = isset($_POST['date']) ? $_POST['date'] : '';
    $quotationNo = isset($_POST['quotationNo']) ? $_POST['quotationNo'] : '';
    $quotationTo = isset($_POST['quotationTo']) ? $_POST['quotationTo'] : '';
    $quotationAmount = isset($_POST['quotationAmount']) ? $_POST['quotationAmount'] : '';
    $subtotal = isset($_POST['subtotal']) ? $_POST['subtotal'] : '';
    $profit = isset($_POST['profit']) ? $_POST['profit'] : '';
    $loss = isset($_POST['loss']) ? $_POST['loss'] : '';

$sql = "INSERT INTO Admin (date, `quotation No`, `quotation To`, `quotation Amount`, subtotal, profit, loss)
            VALUES ('$date', '$quotationNo', '$quotationTo', '$quotationAmount', '$subtotal', '$profit', '$loss')";

    if ($con->query($sql) === TRUE) {
        
        header("Location: display.php");
        
    }
    else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
    
    $last_id = $con->insert_id;
    $rows = count($_POST) / 4;

for ($i = 1; $i <= $rows; $i++) {
    $item = isset($_POST["item$i"]) ? $_POST["item$i"] : '';
    $price = isset($_POST["price$i"]) ? $_POST["price$i"] : '';
    $qty = isset($_POST["qty$i"]) ? $_POST["qty$i"] : '';
    $total = isset($_POST["total$i"]) ? $_POST["total$i"] : '';

    if (!empty($item) && !empty($price) && !empty($qty)) {
        
        $sql2 = "INSERT INTO Admin2 (quotation_id, s_no, item, price, qty, total) 
        VALUES ('$last_id', '$i', '$item', '$price', '$qty', '$total')";

        if ($con->query($sql2) === TRUE) {
            
        header("Location: display.php");
        } else {
            echo "Error: " . $sql2 . "<br>" . $con->error;
        }
    }
}

    $con->close();
}
?>