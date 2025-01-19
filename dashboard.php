<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Charity Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f9ff;
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
            margin: 0 15px;
            padding: 10px 20px;
            background-color: #00796b;
            border-radius: 20px;
            font-size: 16px;
            transition: background-color 0.3s, transform 0.3s;
        }
        .nav a:hover {
            background-color: #004d40;
            transform: scale(1.1);
        }
        .content {
            padding: 40px;
            text-align: center;
            color: #004d40;
        }
        .content h2 {
            font-size: 28px;
            margin-bottom: 20px;
        }
        .content p {
            font-size: 18px;
        }
        .footer {
            background-color: #00796b;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
            border-top: 4px solid #004d40;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Charity Management System</h1>
        <p>Welcome to the central dashboard</p>
    </div>

    <div class="nav">
        <a href="donor_management.php">Donor Management</a>
        <a href="donation_tracking.php">Donation Tracking</a>
        <a href="event_management.php">Event Management</a>
        <a href="volunteer_management.php">Volunteer Management</a>
    </div>

    <div class="content">
        <h2>Dashboard</h2>
        <p>Select an option from the menu to manage the charity system.</p>
    </div>

    <div class="footer">
        <p>&copy; 2025 Charity Management System</p>
    </div>
</body>
</html>
