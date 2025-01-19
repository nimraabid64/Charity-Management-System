<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'charity_system');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == 'delete') {
    $donation_id = $_GET['id'];
    $delete_sql = "DELETE FROM donations WHERE id='$donation_id'";
    if ($conn->query($delete_sql) === TRUE) {
        echo "<script>alert('Donation deleted successfully.'); window.location.href='donation_tracking.php';</script>";
    }
}

$sql = "SELECT donations.id, donors.name AS donor_name, donations.amount, donations.date 
        FROM donations 
        JOIN donors ON donations.donor_id = donors.id";
$result = $conn->query($sql);

if (isset($_POST['add_donation'])) {
    $donor_id = $_POST['donor_id'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $insert_sql = "INSERT INTO donations (donor_id, amount, date) VALUES ('$donor_id', '$amount', '$date')";
    if ($conn->query($insert_sql) === TRUE) {
        echo "<script>alert('Donation added successfully.'); window.location.href='donation_tracking.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}

$donors_sql = "SELECT * FROM donors";
$donors_result = $conn->query($donors_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Tracking - Charity Management System</title>
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
        .add-donation {
            display: inline-block;
            padding: 10px 20px;
            background-color: #00796b;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 16px;
        }
        .add-donation:hover {
            background-color: #004d40;
        }
        .form-container {
            padding: 20px;
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .form-container input, .form-container select, .form-container button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .form-container button {
            background-color: #00796b;
            color: white;
            border: none;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #004d40;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Donation Tracking</h1>
        <p>Track all donation records.</p>
    </div>

    <div class="nav">
        <a href="dashboard.php">Dashboard</a>
        <a href="donor_management.php">Donor Management</a>
        <a href="donation_tracking.php">Donation Tracking</a>
        <a href="event_management.php">Event Management</a>
        <a href="volunteer_management.php">Volunteer Management</a>
    </div>

    <div class="content">
        <a href="#addDonationForm" class="add-donation">Add New Donation</a>

        <form id="addDonationForm" class="form-container" method="POST" action="">
            <h3>Add Donation</h3>
            <label for="donor_id">Donor</label>
            <select name="donor_id" id="donor_id" required>
                <option value="">Select Donor</option>
                <?php
                if ($donors_result->num_rows > 0) {
                    while ($donor = $donors_result->fetch_assoc()) {
                        echo "<option value='" . $donor['id'] . "'>" . $donor['name'] . "</option>";
                    }
                }
                ?>
            </select>
            <label for="amount">Amount</label>
            <input type="number" name="amount" id="amount" placeholder="Donation Amount" required>
            <label for="date">Date</label>
            <input type="date" name="date" id="date" required>
            <button type="submit" name="add_donation">Add Donation</button>
        </form>

        <table>
            <tr>
                <th>ID</th>
                <th>Donor Name</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['donor_name'] . "</td>";
                    echo "<td>" . $row['amount'] . "</td>";
                    echo "<td>" . $row['date'] . "</td>";
                    echo "<td><a href='?id=" . $row['id'] . "&action=delete' onclick='return confirm(\"Are you sure you want to delete this donation?\")'>Delete</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No donations found.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
