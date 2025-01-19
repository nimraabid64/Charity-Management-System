<?php
$conn = new mysqli('localhost', 'root', '', 'charity_system');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == 'delete') {
    $volunteer_id = $_GET['id'];
    $delete_sql = "DELETE FROM volunteers WHERE id='$volunteer_id'";
    if ($conn->query($delete_sql) === TRUE) {
        echo "<script>alert('Volunteer deleted successfully.'); window.location.href='volunteer_management.php';</script>";
    }
}

if (isset($_POST['add_volunteer'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $insert_sql = "INSERT INTO volunteers (name, email, phone) VALUES ('$name', '$email', '$phone')";

    if ($conn->query($insert_sql) === TRUE) {
        echo "<script>alert('Volunteer added successfully.'); window.location.href='volunteer_management.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}

$sql = "SELECT * FROM volunteers";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Management - Charity Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eaf4fc;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #00796b;
            color: white;
            padding: 20px;
            text-align: center;
            border-bottom: 4px solid #004d40;
        }
        .nav {
            display: flex;
            justify-content: center;
            background-color: #004d40;
            padding: 10px;
        }
        .nav a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            padding: 10px 20px;
            background-color: #00796b;
            border-radius: 10px;
            font-size: 16px;
            transition: background-color 0.3s, transform 0.3s;
        }
        .nav a:hover {
            background-color: #004d40;
            transform: scale(1.1);
        }
        .content {
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #00796b;
            color: white;
        }
        .add-volunteer {
            display: inline-block;
            padding: 10px 20px;
            background-color: #00796b;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 16px;
        }
        .add-volunteer:hover {
            background-color: #004d40;
        }
        .form-container input, .form-container textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-container button {
            background-color: #00796b;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #004d40;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Volunteer Management</h1>
        <p>Manage volunteers and their schedules.</p>
    </div>

    <div class="nav">
        <a href="dashboard.php">Dashboard</a>
        <a href="donor_management.php">Donor Management</a>
        <a href="donation_tracking.php">Donation Tracking</a>
        <a href="event_management.php">Event Management</a>
        <a href="volunteer_management.php">Volunteer Management</a>
    </div>

    <div class="content">
        <a href="#addVolunteerForm" class="add-volunteer">Add New Volunteer</a>
        
        <form id="addVolunteerForm" class="form-container" method="POST" action="">
            <h3>Add Volunteer</h3>
            <label for="name">Name</label>
            <input type="text" name="name" id="name" placeholder="Volunteer Name" required>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="Email" required>
            <label for="phone">Phone</label>
            <input type="text" name="phone" id="phone" placeholder="Phone Number" required>
            <button type="submit" name="add_volunteer">Add Volunteer</button>
        </form>

        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['phone'] . "</td>";
                    echo "<td><a href='?id=" . $row['id'] . "&action=delete' onclick='return confirm(\"Are you sure you want to delete this volunteer?\")'>Delete</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No volunteers found.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
