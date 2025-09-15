<?php
session_start();
if (isset($_SESSION['admin'])) { header('Location: products.php'); exit; }
if ($_POST) {
    if ($_POST['user'] == 'admin' && $_POST['pass'] == 'admin123') {
        $_SESSION['admin'] = true;
        header('Location: products.php');
    } else {
        $error = 'Invalid credentials';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Granite Elegance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/granite/admin/css/admin.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
<form method="POST">
    Username: <input type="text" name="user"><br>
    Password: <input type="password" name="pass"><br>
    <button type="submit">Login</button>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
</form>
</body></html>
