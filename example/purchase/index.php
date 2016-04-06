<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>index</title>
  </head>
  <body>
    <form action="/purchase.php" method="post">
      <div>
        <label>Amount: <input type="text" name="amount" value="1"></label>
      </div>
      <div>
        <label>Order ID: <input type="text" name="orderId" value="<?php echo uniqid(); ?>"></label>
      </div>
      <input type="submit">
    </form>
  </body>
</html>