<?php
session_start();
include("database.php");
include("login_register.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>lOGIN</title>
</head>

<body>
    <form action="index.php" method="post">

        <label for="user">Username:</label>
        <input type="text" id="user" name="username"><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password"><br><br>

        <input type="submit" name="login" >

    </form>

    <!-- <form action="index.php" method="post">

        <label for="user">Create New Username:</label>
        <input type="text" id="user" name="username"><br><br>

        <label for="password">Create Password:</label>
        <input type="password" id="password" name="password"><br><br>

        <label for="password">Confirm Password:</label>

        <input type="password" name="confirm_password"><br><br>
        <input type="submit" value="register" name="register">
    </form> -->
</body>

</html>


<?php






require_once 'database.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //  = $_POST['username'];
    //  = $_POST['password'];

    $_SESSION['username'] = isset($_POST['username']) ? trim($_POST['username']) : '';
    $_SESSION['password'] = isset($_POST['password']) ? trim($_POST['password']) : '';

    


    if (empty($_SESSION['username'] ) || empty($_SESSION['password'])) {
        echo "Please enter username and password";
        exit;
    }

    // LOGIN
    if (isset($_POST['login'])) {

        $stmt = $conn->prepare("SELECT * FROM users WHERE user = ?");
        $stmt->bind_param("s", $_SESSION['username'] );
        $stmt->execute();
        $result = $stmt->get_result();

        if ($_SESSION['username']  === 'admin' && $_SESSION['password'] === 'admin') { 
            header("Location: system.php");
            exit();
        }

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();


            if (password_verify($_SESSION['password'], $user['password'])) {
                header("Location: system.php");
                exit();
            } else {
                showError("Incorrect password");
            }
        } else {
            showError("Invalid Credentials");
        }

        $stmt->close();
    }

    // REGISTER
    if (isset($_POST['register'])) {
        if ($_POST['password'] !== $_POST['confirm_password']) {
            showError("Passwords do not match");
            exit;
        }

        $stmt = $conn->prepare("SELECT * FROM users WHERE user = ?");
        $stmt->bind_param("s", $_SESSION['username'] );
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            showError("User does not exist.");
        } else {
            $hashedPassword = password_hash($_SESSION['password'], PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (user, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $_SESSION['username'] , $hashedPassword);
            $stmt->execute();
            echo "Registration successful";
            $stmt->close();
        }
    }
}

function showError($message)
{
    echo "<p style='color:red;'>Error: $message</p>";
    exit(); 
}
?>