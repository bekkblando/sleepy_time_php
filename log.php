<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
            <div class="row">
              <h1>Sleep Log</h1>
              <hr/>
            </div>
            <div class="row">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Time To Sleep</th>
                      <th>Time To Wake</th>
                      <th>Date To Sleep</th>
                      <th>Time Slept</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                   include 'database.php';
                   $pdo = Database::connect();
                   $sql = 'SELECT * FROM sleep_cycle ORDER BY date_to_sleep DESC';
                   foreach ($pdo->query($sql) as $row) {
                            $time_slept = abs(strtotime($row['time_to_wake']) - strtotime($row['time_to_sleep']));
                            echo '<tr>';
                            echo '<td>'. $row['time_to_sleep'] . '</td>';
                            echo '<td>'. $row['time_to_wake'] . '</td>';
                            echo '<td>'. $row['date_to_sleep'] . '</td>';
                            echo '<td>'. $time_slept/(60*60) . '</td>';
                            echo '<td width=250>';
                            echo '<a class="btn" href="read.php?id='.$row['ID'].'">Read</a>';
                            echo ' ';
                            echo '<a class="btn btn-success" href="update.php?id='.$row['ID'].'">Update</a>';
                            echo ' ';
                            echo '<a class="btn btn-danger" href="delete.php?id='.$row['ID'].'">Delete</a>';
                            echo '</td>';
                            echo '</tr>';
                   }
                   Database::disconnect();
                  ?>
                  </tbody>
            </table>
        </div>
    </div> <!-- /container -->
  </body>
</html>
