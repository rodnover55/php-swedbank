<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>index</title>
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.2.3.min.js"></script>
  </head>
  <body>
    <h1 class="js-status">Status </h1>

    <script>
      $(function () {
        setInterval(function () {
          $.get('/status.php?dts_reference=<?php echo $_REQUEST['dts_reference']; ?>', function (data) {
            $('.js-status').html(data);
          });
        }, 5000);
      });
    </script>
  </body>
</html>