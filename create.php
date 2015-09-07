<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Latest compiled and minified CSS-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!--Latest compiled and minified JavaScript-->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <?php

    require 'database.php';

    if ( !empty($_POST)) {
        // keep track validation errors
        $time_to_sleepError = null;
        $time_to_wakeError = null;
        $date_to_sleepError = null;

        // keep track post values
        $time_to_sleep = $_POST['time_to_sleep'];
        $time_to_wake = $_POST['time_to_wake'];
        $date_to_sleep = $_POST['date_to_sleep'];

        // validate input
        $valid = true;
        if (empty($time_to_sleep)) {
            $timesleepError = 'Please enter the time you went to sleep';
            $valid = false;
        } else if (!strtotime($time_to_sleep)) {
            $timesleepError = 'Please enter the time you went to sleep';
            $valid = false;
            echo "Not Working";
        }


        if (empty($time_to_wake)) {
            $timewakeError = 'Please enter the time you awoke';
            $valid = false;
        } else if (!strtotime($time_to_wake)) {
            $timewakeError = 'Please enter the time you awoke';
            $valid = false;
            echo "Not Working";
        }

        if (empty($date_to_sleep)) {
            $date_to_sleepError = 'Please enter the day you fell asleep';
            $valid = false;
            echo "Not Working date to sleep";
        }

        // insert data
        if ($valid) {
            $pdo = Database::connect();
            echo "Made it here";
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO sleep_cycle (time_to_sleep,time_to_wake,date_to_sleep) values(?, ?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($time_to_sleep,$time_to_wake,$date_to_sleep));
            Database::disconnect();
            header("Location: index.php");
        }
    }
?>
</head>

<body>
    <div class="container">

                <div class="span10 offset1">
                    <div class="row">
                        <h3>Create a Sleep Log</h3>
                    </div>

                    <form class="form-horizontal" action="create.php" method="post">
                      <div class="control-group <?php echo !empty($time_to_sleepError)?'error':'';?>">
                        <label class="control-label">Time To Sleep</label>
                        <div class="controls">
                            <input name="time_to_sleep" type="time"  placeholder="Time To Sleep" value="<?php echo !empty($time_to_sleep)?$time_to_sleep:'';?>">
                            <?php if (!empty($time_to_sleepError)): ?>
                                <span class="help-inline"><?php echo $time_to_sleepError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($time_to_wakeError)?'error':'';?>">
                        <label class="control-label">Time To Wake</label>
                        <div class="controls">
                            <input name="time_to_wake" type="time" placeholder="Time To Wake" value="<?php echo !empty($time_to_wake)?$time_to_wake:'';?>">
                            <?php if (!empty($time_to_wakeError)): ?>
                                <span class="help-inline"><?php echo $time_to_wakeError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($date_to_sleepError)?'error':'';?>">
                        <label class="control-label">Date To Sleep</label>
                        <div class="controls">
                            <input name="date_to_sleep" type="date"  placeholder="Date To Sleep" value="<?php echo !empty($date_to_sleep)?$date_to_sleep:'';?>">
                            <?php if (!empty($date_to_sleepError)): ?>
                                <span class="help-inline"><?php echo $date_to_sleepError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Create</button>
                          <a class="btn" href="index.php">Back</a>
                        </div>
                    </form>
                </div>

    </div>
