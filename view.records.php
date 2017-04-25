<?php
  namespace Demo;
  require_once('vendor/autoload.php');
  use Demo\IformBuilderApi;

  $formApi = IformBuilderApi::getInstance();
  $data = json_decode($formApi->getData(),true);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>All Records</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>

<div class="container">
  <h2>Records</h2>
  <table class="table">
    <thead>
      <tr>
        <th>Name</th>
        <th>Age</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Email</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      <?php 
        foreach ($data as $key => $value) {
          # code...
          echo '<tr>';
          echo '<td>'.$value['record']['name'].'</td>';
          echo '<td>'.$value['record']['age'].'</td>';
          echo '<td>'.$value['record']['phone'].'</td>';
          echo '<td>'.$value['record']['address'].'</td>';
          echo '<td>'.$value['record']['email'].'</td>';
          echo '<td>'.$value['record']['currdate'].'</td>';
          echo '</tr>';
        }

      ?>

    </tbody>
  </table>
</div>

</body>
</html>
