<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ATM task</title>
    <link href="dist/css/bootstrap.css" rel="stylesheet">
</head>

<?php include('inc/ViewController.php'); ?>
<body>

<nav class="navbar navbar-default">
    <form class="navbar navbar-default navbar-form" action="" method="get">
        <div class="form-group">
            <div class="input-group summ">
                <span class="input-group-addon">$</span>
                <input type="text" name="summ_requested" class="form-control" value="<?= $ATM->summ_requested ?>">
            </div>
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
    </form>
</nav>

<div class="container main">
    <div class="banknotes"><?= $view_data->get_banknotes() ?></div>
    <div class="alert alert-warning <?= $view_data->error ?>" role="alert">
        <img src="http://drinkclub.spb.ru/sites/default/files/shots/sberbank.jpg">
    </div>
    <div class="result"><?= $steps ?></div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="dist/js/bootstrap.min.js"></script>
</body>
</html>