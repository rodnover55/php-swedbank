<?php
session_id($_REQUEST['dts_reference']);
session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>title</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>
<form action="/authorization-post.php" method="post">
    <input type="hidden" name="dts_reference" value="<?php echo $_REQUEST['dts_reference']; ?>">
    <input type="hidden" name="amount" value="<?php echo $_SESSION['amount']; ?>">
    <input type="hidden" name="orderId" value="<?php echo $_SESSION['orderId']; ?>">
    <div>
        <label>E-mail: <input type="text" name="email" value="test@example.com"></label>
    </div>
    <div>
        <label>First name: <input type="text" name="firstName" value="<?php echo uniqid(); ?>"></label>
    </div>
    <div>
        <label>Surname: <input type="text" name="surname" value="<?php echo uniqid(); ?>"></label>
    </div>
    <input type="submit">
</form>
</body>
</html>
