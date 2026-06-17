<?php 

    include 'db_connection.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $confirm_password = trim($_POST['confirm_password'] ?? '');

        if ($username === '' || $password === '' || $confirm_password === '') {

            die("Error: All fields are required.");
        }

        if ($password !== $confirm_password) {

            die("Error: Passwords do not match");
        }

        if (strlen($password) < 8) {
            
            die("Error: Password must be at least 8 characters");
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $check->bind_param("s", $username);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            die("Error: Username already registered.");
        }

        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashed_password);

        if ($stmt->execute()) {
            header("Location: login.php?registered=1");

            exit;

        } else {
            echo "Database Error: " . $stmt->error;
        }
    }
?>