<?php
session_start();
require_once("Spotilib.php");

$spotify = new Spotilib();

$accessToken = $_SESSION["spotify_tokens"]->access_token;
$playlistid = $_GET['playlist_id'];
$userid = $_GET['user_id'];
$user = $_GET['user_id'];
$list = $spotify->getPlaylistById($accessToken, $userid, $playlistid);

$listname = $list->name;
$track = $spotify->getPlaylistTracksByID($accessToken, $userid, $playlistid);
$total = $track->total;


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
                <li><a href="spotify.php">Terug</a></li>
                <li><a href="http://open.spotify.com/user/<?= $user ?>/playlist/
<?= $playlistid ?>"><p>Open lijst in Spotify</p></a></li>
                <li><a href="">
                        <iframe
                            src="https://tools.playlists.net/follow-button/user/<?= $userid ?>/playlist/<?= $playlistid ?>"
                            scrolling="no" frameborder="0" style="border:none; overflow:hidden;"
                            allowtransparency="true" width="154" height="30"></iframe>
                    </a></li>
            </ul>
        </div>
        <!--/.nav-collapse-->
    </div>
</nav>

<div class= "container-fluid frame">
    <h1 style="text-decoration: underline;">Playlist naam: <?=$listname?></h1>
    <?php
    if ($total > 100) {
        echo "<div class='message'>De afspeellijst heeft ".$total." nummmers. De eerste 100 worden weer gegeven</div>";
        $total = 100;

    }

    for ($i = 0; $i < $total; $i++) {
        $item = $track->items[$i];

        $play = "<iframe src='https://embed.spotify.com/?uri=%s' class='col-xs-6 col-md-4 iframe_config'></iframe>";
        echo sprintf($play, $item->track->uri);
    }

    ?>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</body>
</html>