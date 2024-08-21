<?php
include('db.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $sql = "SELECT * FROM Admin WHERE id = $id";
    $result = $con->query($sql);
    $adminData = $result->fetch_assoc();

    $sql2 = "SELECT * FROM Admin2 WHERE quotation_id = $id";
    $result2 = $con->query($sql2);
    $admin2Data = $result2->fetch_all(MYSQLI_ASSOC);
} else {
    echo "Invalid Quotation ID.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
$date = $_POST['date'];
    $quotationNo = $_POST['quotationNo'];
    $quotationTo = $_POST['quotationTo'];
    $quotationAmount = $_POST['quotationAmount'];
    $subtotal = $_POST['subtotal'];
    $profit = $_POST['profit'];
    $loss = $_POST['loss'];
    
    $updateAdminSql = "UPDATE Admin SET date='$date', `quotation No`='$quotationNo', `quotation To`='$quotationTo', `quotation Amount`='$quotationAmount', subtotal='$subtotal', profit='$profit', loss='$loss' WHERE id=$id";
    $con->query($updateAdminSql);

   foreach ($admin2Data as $index => $item) {
        $itemValue = $_POST['item' . ($index + 1)];
        $price = $_POST['price' . ($index + 1)];
        $qty = $_POST['qty' . ($index + 1)];
        $total = $_POST['total' . ($index + 1)];
        
        $updateAdmin2Sql = "UPDATE Admin2 SET item='$itemValue', price='$price', qty='$qty', total='$total' WHERE id=" . $item['id'];
        $con->query($updateAdmin2Sql);
    }

  
    for ($i = count($admin2Data) + 1; isset($_POST['item' . $i]); $i++) {
        $itemValue = $_POST['item' . $i];
        $price = $_POST['price' . $i];
        $qty = $_POST['qty' . $i];
        $total = $_POST['total' . $i];
        
        if ($itemValue) { 
            $insertAdmin2Sql = "INSERT INTO Admin2 (quotation_id, item, price, qty, total) VALUES ($id, '$itemValue', '$price', '$qty', '$total')";
            $con->query($insertAdmin2Sql);
        }
    }

    header("Location: display.php");
    exit;
}
?>

<?php
session_start();
if (!isset($_SESSION['username'])) {
header("Location: index.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: sans-serif;
            background: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #007bff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .navbar a:hover {
            background-color: #0056b3;
        }

        .quotation-form {
            max-width: 900px;
            margin: 40px auto;
            padding: 30px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            position: relative;
        }

        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
            font-size: 2rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .form-group {
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
        }

     .form-group label {
            font-weight: bold;
            margin-bottom: 8px;
            color: #444;
        }

        input[type="date"], input[type="text"], input[type="number"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
            transition: border-color 0.3s, box-shadow 0.3s;
            font-size: 1rem;
        }

        input[type="text"]:focus, input[type="number"]:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.3);
            outline: none;
        }

        table {
            width: 101%;
            border-collapse: collapse;
            margin-bottom: 30px;
            overflow-x: auto; 
        }

        table thead {
            background: #007bff;
            color: #ffffff;
        }

        table th, table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        button[type="button"], button[type="submit"] {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: #ffffff;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
            font-size: 1rem;
            font-weight: bold;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        }

        button[type="button"]:hover, button[type="submit"]:hover {
            background: linear-gradient(135deg, #0056b3 0%, #003d7a 100%);
            transform: translateY(-2px);
        }

        .remove-btn {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        }

        .remove-btn:hover {
            background: linear-gradient(135deg, #c82333 0%, #a71d2a 100%);
        }

        button.add-new-row {
            background: linear-gradient(135deg, #28a745 0%, #218838 100%);
            font-size: 0.875rem;
        }

        button.add-new-row:hover {
            background: linear-gradient(135deg, #218838 0%, #1e7e34 100%);
        }

        .form-group label i {
            margin-right: 8px;
            color: #007bff;
            font-size: 1.2rem;
        }

        @media (max-width: 768px) {
            .quotation-form {
                padding: 20px;
            }

            .form-group {
                flex-direction: column;
            }
        }

        @media (max-width: 576px) {
            .navbar {
                padding: 10px;
                flex-direction: column;
            }

            .navbar a.dashboard {
                padding: 6px 12px;
                font-size: 0.875rem;
            }

            .form-group input,
            .form-group textarea {
                margin-top: 10px;
            }

            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }

            table th, table td {
                white-space: nowrap;
            }
        }

    </style>
</head>
<body>
<div class="navbar">
        <a href="display.php" class="dashboard"><i class="fas fa-eye"></i> View Display</a>
    </div>
</head>
<body>
    <div class="quotation-form">
        <h2>Edit Quotation:</h2>
        <form id="quotationForm" method="POST">
            <div class="form-group">
                <label for="date"><i class="fas fa-calendar-alt"></i>Date:</label>
                <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($adminData['date']); ?>">
            </div>
            <div class="form-group">
                <label for="quotationNo"><i class="fas fa-file-alt"></i>Quotation No:</label>
                <input type="text" id="quotationNo" name="quotationNo" value="<?php echo htmlspecialchars($adminData['quotation No']); ?>">
            </div>
            <div class="form-group">
                <label for="quotationTo"><i class="fas fa-user"></i>Quotation To:</label>
                <input type="text" id="quotationTo" name="quotationTo" value="<?php echo htmlspecialchars($adminData['quotation To']); ?>">
            </div>
            <div class="form-group">
                <label for="quotationAmount"><i class="fa fa-inr" aria-hidden="true"></i>Quotation Amount:</label>
                <input type="number" id="quotationAmount" name="quotationAmount" value="<?php echo htmlspecialchars($adminData['quotation Amount']); ?>" oninput="calculateTotal()">
            </div>

            <table id="AdminTable">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($admin2Data as $index => $item): ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><input type="text" name="item<?php echo $index + 1; ?>" value="<?php echo htmlspecialchars($item['item']); ?>"></td>
                        <td><input type="number" name="price<?php echo $index + 1; ?>" value="<?php echo htmlspecialchars($item['price']); ?>" oninput="calculateTotal()"></td>
                        <td><input type="number" name="qty<?php echo $index + 1; ?>" value="<?php echo htmlspecialchars($item['qty']); ?>" oninput="calculateTotal()"></td>
                        <td><input type="text" name="total<?php echo $index + 1; ?>" value="<?php echo htmlspecialchars($item['total']); ?>" readonly></td>
                        <td><button type="button" class="remove-btn" onclick="removeRow(this)">Remove</button></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <button type="button" onclick="addNewRow()">Add New Row</button><br><br><br>

            <div class="form-group">
                <label>Subtotal:</label>
                <span id="subtotal"><?php echo($adminData['subtotal']); ?></span>
                <input type="hidden" id="subtotalInput" name="subtotal" value="<?php echo ($adminData['subtotal']); ?>">
            </div>
            <div class="form-group">
                <label>Profit:</label>
                <span id="profit"><?php echo ($adminData['profit']); ?></span>
                <input type="hidden" id="profitInput" name="profit" value="<?php echo ($adminData['profit']); ?>">
            </div>
            <div class="form-group">
                <label>Loss:</label>
                <span id="loss"><?php echo ($adminData['loss']); ?></span>
                <input type="hidden" id="lossInput" name="loss" value="<?php echo($adminData['loss']); ?>">
            </div>
            <button type="submit">Update</button>
        </form>
    </div>
    <script>
    function calculateTotal() {
        let table = document.getElementById("AdminTable").getElementsByTagName('tbody')[0];
        let rows = table.getElementsByTagName('tr');
        let subtotal = 0;

        for (let i = 0; i < rows.length; i++) {
            let price = parseFloat(rows[i].querySelector(`[name="price${i + 1}"]`).value) || 0;
            let qty = parseFloat(rows[i].querySelector(`[name="qty${i + 1}"]`).value) || 0;
            let total = price * qty;
            rows[i].querySelector(`[name="total${i + 1}"]`).value = total.toFixed(2);
            subtotal += total;
        }

        document.getElementById('subtotal').innerText = subtotal.toFixed(2);
        document.getElementById('subtotalInput').value = subtotal.toFixed(2);

        let quotationAmount = parseFloat(document.getElementById('quotationAmount').value) || 0;
        let profit = subtotal < quotationAmount ? quotationAmount - subtotal : 0;
        let loss = subtotal > quotationAmount ? subtotal - quotationAmount : 0;

        document.getElementById('profit').innerText = profit.toFixed(2);
        document.getElementById('profitInput').value = profit.toFixed(2);

        document.getElementById('loss').innerText = loss.toFixed(2);
        document.getElementById('lossInput').value = loss.toFixed(2);
    }

    function addNewRow() {
        let table = document.getElementById("AdminTable").getElementsByTagName('tbody')[0];
        let rowCount = table.getElementsByTagName('tr').length + 1;

        let newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>${rowCount}</td>
            <td><input type="text" name="item${rowCount}"></td>
            <td><input type="number" name="price${rowCount}" oninput="calculateTotal()"></td>
            <td><input type="number" name="qty${rowCount}" oninput="calculateTotal()"></td>
            <td><input type="text" name="total${rowCount}" readonly></td>
            <td><button type="button" class="remove-btn" onclick="removeRow(this)">Remove</button></td>
        `;
        table.appendChild(newRow);
    }

    function removeRow(button) {
        let row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
         calculateTotal();
    }
    </script>
</body>
</html>