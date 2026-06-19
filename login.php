<?php 

session_start();
// Starts session to store user login data

include 'db_connection.php';

$error = '';

// Redirecting logged in users away from login
if (isset($_SESSION['user_id'])) {

    header("Location: index.php");

    exit;
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //gets info from form and removes extra spaces
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    
    if ($username === '' || $password === '') {
    
    $error = "Error: Both fields are required.";

    } else {
        // checks if user exists and prepares sql query to find username
        $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
        //binds username to query
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 0) {
            $error = "Error: Username not registered.";

        } else {
        
        $stmt->bind_result($user_id, $hashed_password, $role);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;

            $_SESSION['username'] = $username;

            $_SESSION['role'] = $role;

            header("Location: index.php");

            exit;
        
        } else {

            $error = "Error: Incorrect password.";
            }
    
        }

        $stmt->close();
    }   
}
logActie("MISLUKTE LOGIN", $_POST["gebruikersnaam"] ?? "onbekend");
?>











<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mythos Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="navbar">
        <h1>Mythos</h1>
    </header>

    <main class="login-page-wrapper">

        <div class="login-card">

            <?php if ($error): ?>

                <div class="error-message" style="color:red; margin-bottom:10px">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            
            <form action="login.php" method="POST">
                <div class="input-group">
                    <label for="username">Username</label>

                    <input type="text" id="username" name="username" placeholder="Enter your Username" required>
                </div>

                <div class="input-group">
                    <label for="password">Password</label>

                    <input type="password" id="password" name="password" palceholder="........" required>
                </div>

                <button type="submit" class="login-submit-btn">Login</button>

                <a href="registration.php" class="create-account-btn">Create Account</a>
            </form>
        </div>
    </main>

    <script>
        const params = new URLSearchParams(window.location.search);
        //gets URL parameters
        
        if (params.get("registered") === "1") {

        alert("Account created successfully")
        }

    </script>
</body>
</html>