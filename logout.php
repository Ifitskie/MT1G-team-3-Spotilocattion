<?php

session_start();

unset($_SESSION["spotify_tokens"]);

header( "refresh:5;url=index.php" );

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logout</title>
</head>
<body>

<h1>U bent uitgelogd</h1>


</body>
</html>