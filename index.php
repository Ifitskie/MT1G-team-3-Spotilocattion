<?php

session_start();

require_once('Spotilib.php');

$spotify = new Spotilib;


?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Spotify</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css"/>
    <link href='http://fonts.googleapis.com/css?family=Dosis:500' rel='stylesheet' type='text/css'>
</head>
<body>
<div class="container">

    <h1>SpotLocations</h1>

    <div class="col-sm-5 .col-md-6">
        <h2>Nieuw bij SpotLocations? </h2>
        Deze app zorgt dat je afspeellijsten van Spotify kunt bekijken, die in een straal (bijv. 5 km) in je buurt afgespeeld worden. Op deze manier kun jij op elke locatie zien, welke muziek geluisterd wordt. Aanmelden gaat eenvoudig door op de knop hieronder te klikken.
    </div>
    <div class="col-sm-5 .col-sm-offset-2 .col-md-6 .col-md-offset-0">
        <h2>SpotLocations staat voor</h2>
        <ul>
            <li>Snel zien welke muziek in je buurt geluisterd wordt</li>
            <li>Potentieel interessante muziek luisteren</li>
            <li>Ontdekken of nieuwe muziek om je heen geluisterd wordt</li>
            <li>Te leuk voor als je op een nieuwe locatie komt en daar onbekend bent</li>
        </ul>
    </div>

    <div id="login" class="container-fluid">
        <a href="<?= $spotify->getLoginUrl() ?>"><img class="img-responsive" src="assets/spotify-buttons/Log%20in%20with%20Spotify/png/log_in-desktop-large.png" alt="Login" id="login"/></a>
    </div>
</div>

</body>
</html>