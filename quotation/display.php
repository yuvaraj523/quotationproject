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
    <title>DQMS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: sans-serif;
            background: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #007bff;
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

        .create {
            background-color: #007bff;
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            display: inline-block;
        }

        .create:hover {
            background-color: #0056b3;
        }

        .search-button,
        .viewAll-button {
            background-color: #007bff;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 5px;
            display: inline-flex;
            align-items: center;
        }

        .search-button:hover,
        .viewAll-button:hover {
            background-color: #0056b3;
        }

        .search-button i,
        .viewAll-button i {
            margin-right: 5px;
        }
        
        form #search {
            width: 250px; 
            padding: 8px;
            border: 1px solid #007bff;
            border-radius: 4px;
            font-size: 16px;
        }
        a {
            text-decoration: none;
    
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
            padding: 10px;
        }

        td {
            padding: 10px;
        }

        .action-buttons a {
            color: #007bff;
            margin-right: 10px;
            font-size: 18px;
        }

        .action-buttons a:hover {
            color: #0056b3;
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 20px;
            }
        }
      

.action-buttons a.edit-link {
    color: #28a745; 
}

.action-buttons a.view-link {
    color: #007bff; 
}

.action-buttons a.delete-link {
    color: #dc3545; 
}

.action-buttons a:hover {
    opacity: 0.8; 
}

</style>
</head>
<body>
    <div class="navbar">
        <a href="create.php" class="create"><i class="fas fa-plus-circle"></i> Create New Record</a>
    </div>
    
    <h2>DISPLAY QMS:</h2>
    
    <form method="GET">
        <input type="text" id="search" name="search" placeholder="Search by Name" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
        <button type="submit" class="search-button"><i class="fas fa-search"></i> Search</button>
        <a href="display.php" class="viewAll-button"><i class="fas fa-eye"></i> View All</a>
    </form>
 <?php
    include('db.php');

    if (isset($_GET['delete'])) {
        $id_to_delete = $_GET['delete'];
        $delete_admin2_sql = "DELETE FROM Admin2 WHERE quotation_id = '$id_to_delete'";
        if ($con->query($delete_admin2_sql) === TRUE) {
            $delete_admin_sql = "DELETE FROM Admin WHERE id = '$id_to_delete'";
            if ($con->query($delete_admin_sql) === TRUE) {
        
            } else {
                echo "Error: " . $con->error . "<br>";
            }
        } else {
            echo "Error: " . $con->error . "<br>";
        }
    }

    $search_query = '';
    if (isset($_GET['search'])) {
        $search_query = $_GET['search'];
        $sql = "SELECT * FROM Admin WHERE `quotation To` LIKE '%$search_query%'";
    } else {
        $sql = "SELECT * FROM Admin";
    }

    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Quotation No</th>
                    <th>Quotation To</th>
                    <th>Quotation Amount</th>
                    <th>Total</th>
                   <th>Action</th>
                </tr>";

        while($row = $result->fetch_assoc()) {
            $last_id = $row["id"];
            $sql2 = "SELECT SUM(total) as total_sum FROM Admin2 WHERE quotation_id = '$last_id'";
            $result2 = $con->query($sql2);
            $total_sum = $result2->fetch_assoc()['total_sum'];

            echo "<tr>
                    <td>" . $row["id"] . "</td>
                    <td>" . $row["date"] . "</td>
                    <td>" . $row["quotation No"] . "</td>
                    <td>" . $row["quotation To"] . "</td>
                    <td>" . $row["quotation Amount"] . "</td>
                    <td>" . $total_sum . "</td>
                    <td class='action-buttons'>
                        <a href='edit.php?id=" . $last_id . "' class='edit-link'><i class='fas fa-edit'></i></a>
                        <a href='view.php?id=" . $last_id . "' class='view-link'><i class='fas fa-eye'></i></a>
                        <a href='?delete=" . $last_id . "' onclick='return confirm(\"Are you sure you want to delete this record?\")' class='delete-link'><i class='fas fa-trash'></i></a>
                    </td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "No records found.";
    }

    $con->close();
    ?>

</body>
</html>
