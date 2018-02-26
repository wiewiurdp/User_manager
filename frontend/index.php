<?php
session_start()
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Index</title>
    <link rel="stylesheet" media="screen"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<br>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top:30px;">
        <p class="btn btn-info"><a href="?action=users">Users</a></p>
        <p class="btn btn-info"><a href="?action=profile">My profile</a></p>
        <p id="logout" class="btn btn-info">Logout</p>
        <br><br>
        <p id="error" class="red"></p>
    </div>
</div>
<?php
if (isset($_SESSION['logged']) && $_SESSION['logged'] == 'true') {
    switch ($_GET['action']) {
        case 'users':
            $incFile = __DIR__ . '/pages/users.php';
            break;
        case 'profile':
            $incFile = __DIR__ . '/pages/profile.php';
            break;
    }
} else {
    if (isset($_GET['register'])) {
        $incFile = __DIR__ . '/pages/register.php';
    } else {
        $incFile = __DIR__ . '/pages/authentication.php';
    }
}
include_once $incFile;
?>
<script src="js/scripts.js"></script>
</body>
</html>
