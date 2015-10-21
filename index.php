<!doctype html>
<html lang="en">
<head>
    <!-- META -->
    <meta charset="utf-8">

    <!-- TITLE -->
    <title>Calculate my work duration</title>

    <!-- CSS -->
    <link href='https://fonts.googleapis.com/css?family=Roboto+Mono:400,500,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="assets/css/screen.css">
</head>
<body>


<div class="outer">
    <div class="middle">
        <div class="inner">
            <?php
            include('assets/php/calculate_work_duration.php');
            ?>


            <div class="pick-another">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
                    <input type="text" id="datepicker" name="date">

                    <p><span>Pick another date?</span></p>
                    <input class="submit-button" type="submit">
                </form>
            </div>
        </div>

    </div>
</div>

<!-- SCRIPTS -->
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>