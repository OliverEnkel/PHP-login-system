<?php
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($_POST["username"] === "admin" && $_POST["password"] === "admin123") {
        $_SESSION["user"] = "admin";
        header("Location: index.php");
        exit;
    } else {
        $error = "Login fehlgeschlagen";
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body>

<div class="login-box">
    <h2>Login</h2>

    <?php if ($error): ?>
        <p style="color:red"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Benutzername" required><br><br>
        <input type="password" name="password" placeholder="Passwort" required><br><br>
        <button type="submit">Login</button>
    </form>
</div>

</body>

</html> 