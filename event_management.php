<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'charity_system');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == 'delete') {
    $event_id = $_GET['id'];
    $delete_sql = "DELETE FROM events WHERE id='$event_id'";
    if ($conn->query($delete_sql) === TRUE) {
        echo "<script>alert('Event deleted successfully.'); window.location.href='event_management.php';</script>";
    }
}

if (isset($_POST['add_event'])) {
    $name = $_POST['name'];
    $date = $_POST['date'];
    $location = $_POST['location'];

    $insert_sql = "INSERT INTO events (name, date, location) VALUES ('$name', '$date', '$location')";
    
    if ($conn->query($insert_sql) === TRUE) {
        echo "<script>alert('Event added successfully.'); window.location.href='event_management.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}

$sql = "SELECT * FROM events";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management - Charity Management System</title>
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
        .add-event {
            display: inline-block;
            padding: 10px 20px;
            background-color: #00796b;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 16px;
        }
        .add-event:hover {
            background-color: #004d40;
        }
        .form-container {
            margin-top: 20px;
        }
        .form-container input {
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
        <h1>Event Management</h1>
        <p>Manage charity events and activities.</p>
    </div>

    <div class="nav">
        <a href="dashboard.php">Dashboard</a>
        <a href="donor_management.php">Donor Management</a>
        <a href="donation_tracking.php">Donation Tracking</a>
        <a href="event_management.php">Event Management</a>
        <a href="volunteer_management.php">Volunteer Management</a>
    </div>

    <div class="content">
        <a href="#addEventForm" class="add-event">Add New Event</a>

        <form id="addEventForm" class="form-container" method="POST" action="">
            <h3>Add Event</h3>
            <label for="name">Event Name</label>
            <input type="text" name="name" id="name" placeholder="Event Name" required>
            <label for="date">Date</label>
            <input type="date" name="date" id="date" required>
            <label for="location">Location</label>
            <input type="text" name="location" id="location" placeholder="Event Location" required>
            <button type="submit" name="add_event">Add Event</button>
        </form>

        <table>
            <tr>
                <th>ID</th>
                <th>Event Name</th>
                <th>Date</th>
                <th>Location</th>
                <th>Actions</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['date'] . "</td>";
                    echo "<td>" . $row['location'] . "</td>";
                    echo "<td><a href='?id=" . $row['id'] . "&action=delete' onclick='return confirm(\"Are you sure you want to delete this event?\")'>Delete</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No events found.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
