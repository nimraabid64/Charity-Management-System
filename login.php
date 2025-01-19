<?php

session_start();


$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'charity_system';

$conn = new mysqli($host, $user, $pass, $db);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = isset($_POST['username']) ? $conn->real_escape_string($_POST['username']) : '';
    $password = isset($_POST['password']) ? $conn->real_escape_string($_POST['password']) : '';
    $role = isset($_POST['role']) ? $conn->real_escape_string($_POST['role']) : '';
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    if ($action == "login") {
        
        $query = "SELECT * FROM users WHERE username='$username' AND password='$password' AND role='$role'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;
           
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<p style='color:red;'>Invalid credentials. Please try again.</p>";
        }
    } elseif ($action == "register") {
    
        $check_query = "SELECT * FROM users WHERE username='$username'";
        $check_result = $conn->query($check_query);

        if ($check_result->num_rows > 0) {
            echo "<p style='color:red;'>Username already exists. Please choose another.</p>";
        } else {
            $register_query = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
            if ($conn->query($register_query) === TRUE) {
                echo "<p style='color:green;'>Registration successful! You can now log in.</p>";
                header("Location: login_register.php"); // Refresh the page for login
                exit();
            } else {
                echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
            }
        }
    }
}


$conn->close();

if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register - Charity Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e0f7fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }
        .container h1 {
            color: #00796b;
            margin-bottom: 20px;
        }
        .container input, 
        .container select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #b2dfdb;
            border-radius: 5px;
        }
        .container button {
            background-color: #00796b;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        .container button:hover {
            background-color: #004d40;
        }
        .toggle-link {
            margin-top: 15px;
            display: inline-block;
            font-size: 14px;
            color: #00796b;
            cursor: pointer;
        }
        .toggle-link:hover {
            text-decoration: underline;
        }
    </style>
    <script>
        function toggleForm(isRegistering) {
            const title = document.getElementById('form-title');
            const toggleText = document.getElementById('toggle-text');
            const submitButton = document.getElementById('submit-button');
            const formAction = document.getElementById('form-action');

            if (isRegistering) {
                title.textContent = "Register";
                toggleText.textContent = "Already have an account? Login";
                submitButton.textContent = "Register";
                formAction.value = "register";
            } else {
                title.textContent = "Login";
                toggleText.textContent = "Don't have an account? Register";
                submitButton.textContent = "Login";
                formAction.value = "login";
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1 id="form-title">Login</h1>
        <form action="" method="POST">
            <input type="hidden" name="action" id="form-action" value="login">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="role" required>
                <option value="" disabled selected>Select Role</option>
                <option value="admin">Admin</option>
                <option value="manager">Manager</option>
                <option value="volunteer">Volunteer</option>
                <option value="donor">Donor</option>
            </select>
            <button type="submit" id="submit-button">Login</button>
        </form>
        <span class="toggle-link" id="toggle-text" onclick="toggleForm(document.getElementById('form-action').value === 'login')">
            Don't have an account? Register
        </span>
    </div>
</body>
</html>
