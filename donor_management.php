<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'charity_system');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == 'delete') {
    $donor_id = $_GET['id'];
    $delete_sql = "DELETE FROM donors WHERE id='$donor_id'";
    if ($conn->query($delete_sql) === TRUE) {
        echo "<script>alert('Donor deleted successfully.'); window.location.href='donor_management.php';</script>";
    }
}

if (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == 'edit') {
    $donor_id = $_GET['id'];
    $sql = "SELECT * FROM donors WHERE id='$donor_id'";
    $result = $conn->query($sql);
    $donor = $result->fetch_assoc();

    if (isset($_POST['update_donor'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $update_sql = "UPDATE donors SET name='$name', email='$email', phone='$phone' WHERE id='$donor_id'";
        if ($conn->query($update_sql) === TRUE) {
            echo "<script>alert('Donor updated successfully.'); window.location.href='donor_management.php';</script>";
        }
    }
}

if (isset($_POST['add_donor'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $sql = "INSERT INTO donors (name, email, phone) VALUES ('$name', '$email', '$phone')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Donor added successfully.'); window.location.href='donor_management.php';</script>";
    }
}

$sql = "SELECT * FROM donors";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Management - Charity Management System</title>
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
        .add-donor {
            display: inline-block;
            padding: 10px 20px;
            background-color: #00796b;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 16px;
        }
        .add-donor:hover {
            background-color: #004d40;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Donor Management</h1>
        <p>Manage donor information and records.</p>
    </div>

    <div class="nav">
        <a href="dashboard.php">Dashboard</a>
        <a href="donor_management.php">Donor Management</a>
        <a href="donation_tracking.php">Donation Tracking</a>
        <a href="event_management.php">Event Management</a>
        <a href="volunteer_management.php">Volunteer Management</a>
    </div>

    <div class="content">
        <?php if (!isset($_GET['id'])): ?>
            <a href="?action=add" class="add-donor">Add New Donor</a>
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
                        echo "<td><a href='?id=" . $row['id'] . "&action=edit'>Edit</a> | <a href='?id=" . $row['id'] . "&action=delete' onclick='return confirm(\"Are you sure you want to delete this donor?\")'>Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No donors found.</td></tr>";
                }
                ?>
            </table>
        <?php endif; ?>

        <?php if (isset($_GET['action']) && $_GET['action'] == 'add' || isset($_GET['action']) && $_GET['action'] == 'edit'): ?>
            <form method="POST">
                <input type="text" name="name" placeholder="Donor Name" value="<?php echo isset($donor) ? $donor['name'] : ''; ?>" required>
                <input type="email" name="email" placeholder="Donor Email" value="<?php echo isset($donor) ? $donor['email'] : ''; ?>" required>
                <input type="text" name="phone" placeholder="Donor Phone" value="<?php echo isset($donor) ? $donor['phone'] : ''; ?>" required>
                <button type="submit" name="add_donor" <?php echo isset($donor) ? 'name="update_donor"' : ''; ?>>
                    <?php echo isset($donor) ? 'Update Donor' : 'Add Donor'; ?>
                </button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
