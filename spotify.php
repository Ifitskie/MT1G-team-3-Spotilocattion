<?php

session_start();
require("settings/settings.php");
require("ajaxHelper.php");
require_once("Spotilib.php");
$spotify = new Spotilib();

$profile = $spotify->getUserProfileByAccesToken($_SESSION["spotify_tokens"]->access_token);
$gebruiker = $profile->id;
$gebruikernaam = $profile->display_name;
$image = $profile->images[0]->url;
$accessToken = $_SESSION["spotify_tokens"]->access_token;


$query = "SELECT user_id, playlist_id FROM addplaylist WHERE user_id <> '" . $gebruiker . "'";

$result = mysqli_query($db, $query);
$numrows = mysqli_num_rows($result);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Spotify</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css"/>
</head>
<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="spotify.php">Spotilocation</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#"><img src="<?= $image ?>" alt="profile picture"
                                                    class="profile"/><?= $gebruikernaam ?></a></li>
                <li class="special"> Straal: <input type="text" id="maxDistance"> Km <input type="button" id="calculate" value="ververs"></li>
                <!--                <input type="text" id="maxDistance"><input type="button" id="calculate" value="calculate">-->
                <li><a href="addplaylist.php">Playlist veranderen</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
        <!--/.nav-collapse-->
    </div>
</nav>
<div id="map" class="container-fluid img-rounded"></div>

<br/>
<br/>
<table class="table">
    <thead>
    <tr>
        <th>Cover</th>
        <th> Titel</th>
        <th>Followers</th>
    </tr>
    </thead>
    <tbody id="allPlaylists">

    </tbody>
</table>

<footer class="jumbotron">
    <h1>spotilocation</h1>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="js/main.js"></script>
<script type="text/javascript" src="js/playlist.js"></script>
</body>
</html>