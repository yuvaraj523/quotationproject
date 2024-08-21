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
<title>Quotation Details</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    body {
    font-family: sans-serif;
    background: #f4f4f4;
    color: #333;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 1200px;
    margin: 40px auto;
    padding: 20px;
    background: rgba(255, 255, 255, 0.9); 
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    transform: scale(1.02);
}

h2{
    text-align: center;
}


h3 {
    color: #333;
    font-size: 1.5rem;
    margin-top: 30px;
    border-bottom: 1px solid #ddd;
    padding-bottom: 10px;
}

p {
    font-size: 1rem;
    line-height: 1.6;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
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

table th {
    text-transform: uppercase;
    font-size: 0.875rem;
}

table tr:nth-child(even) {
    background-color: #f9f9f9;
}

table tr:hover {
    background-color: #f1f1f1;
}



table td {
    font-size: 0.875rem;
}

table td:last-child {
    text-align: center;
}

@media (max-width: 768px) {
    .container {
        padding: 10px;
    }
}

@media (max-width: 576px) {
    table th, table td {
        font-size: 0.7rem;
        padding: 6px;
    }

    .container {
        margin: 20px;
    }

    h2 {
        font-size: 1.25rem;
    }

    h3 {
        font-size: 1rem;
    }
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
</style>
<div class="navbar">
        <a href="display.php" class="dashboard"><i class="fas fa-eye"></i> View Display</a>
        </div>
</head>
<body>
    <div class="container">
        <?php
        include('db.php');
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "SELECT * FROM Admin WHERE id = '$id'";
            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "<h2>Details for Quotation : ". "</h2>";
                echo "<p>Date: " . ($row['date']) . "</p>";
                echo "<p>Quotation No: " . ($row['quotation No']) . "</p>";
                echo "<p>Quotation To: " . ($row['quotation To']) . "</p>";
                echo "<p>Quotation Amount: " . ($row['quotation Amount']) . "</p>";

                $sql2 = "SELECT * FROM Admin2 WHERE quotation_id = '$id'";
                $result2 = $con->query($sql2);

                if ($result2->num_rows > 0) {
                    
                    $overallTotal = 0;
                    $overallSubtotal = 0;
                    $overallProfit = 0;
                    $overallLoss = 0;

                    echo "<h3>ITEMS:</h3>";
                    echo "<table>
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Item</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>";
                    while ($row2 = $result2->fetch_assoc()) {
                        $total = $row2['price'] * $row2['qty'];
                        $overallTotal += $total;

                        echo "<tr>
                                <td>" . ($row2['s_no']) . "</td>
                                <td>" . ($row2['item']) . "</td>
                                <td>" . ($row2['price']) . "</td>
                                <td>" .($row2['qty']) . "</td>
                                <td>" . ($total) . "</td> 
                            </tr>";
                    }
                    echo "</tbody>";
                    
                    echo "<tfoot>
                            <tr>
                                <td colspan='4'><strong>Overall Total:</strong></td>
                                <td>" . ($overallTotal) . "</td>
                            </tr>
                            <tr>
                                <td colspan='4'><strong>Overall Subtotal:</strong></td>
                                <td>" . ($row['subtotal']) . "</td>
                            </tr>
                            <tr>
                                <td colspan='4'><strong>Overall Profit:</strong></td>
                                <td>" . ($row['profit']) . "</td>
                            </tr>
                            <tr>
                                <td colspan='4'><strong>Overall Loss:</strong></td>
                                <td>" . ($row['loss']) . "</td>
                            </tr>
                        </tfoot>
                    </table>";
                } else {
                    echo "<p>No items found.</p>";
                }
            } else {
                echo "No details found.";
            }
        } else {
            echo "No ID provided.";
        }

        $con->close();
        ?>
    </div>
</body>
</html>
