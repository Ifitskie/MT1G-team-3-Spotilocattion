<?php

session_start();

require_once("Spotilib.php");
$spotify = new Spotilib();

$profile = $spotify->getUserProfileByAccesToken($_SESSION["spotify_tokens"]->access_token);
$user = $profile->id;

if (isset($_GET['playlist'])) {
    require("settings/settings.php");

    $query = sprintf("UPDATE addplaylist SET playlist_id='%s' WHERE user_id='%s' ", $_GET['playlist'], $user);
    mysqli_query($db, $query);

    header('Location: spotify.php');
}
$gebruikernaam = $profile->display_name;
$image = $profile->images[0]->url;
$accessToken = $_SESSION["spotify_tokens"]->access_token;

$playlist = $spotify->getPlaylistsByAccesToken($_SESSION["spotify_tokens"]->access_token, $user);
$playlists = $playlist->items;
$total = $playlist->total;


?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>add Playlist</title>
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
                <li><a href="#">Straal:</a></li>
                <!--                <input type="text" id="maxDistance"><input type="button" id="calculate" value="calculate">-->
                <li><a href="addplaylist.php">Playlist veranderen</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
        <!--/.nav-collapse-->
    </div>
</nav>

<h3>KIES JOUW FAVORIETE PLAYLIST</h3>
<?php
if  ($total > 20){
    echo "<div class='message'>U heeft ".$total." afspeellijsten. De eerste 20 worden weer gegeven.</div>";
    $total = 20;
}
?>
<table class="table table-bordered container-fluid cover">
    <thead>
    <tr>
        <th>Cover foto</th>
        <th> Playlist Naam</th>
        <th>Kies je playlist</th>
    </tr>
    </thead>
    <tbody>
    <?php

    for($i=0; $i < $total-1; $i++){
        $item = $playlist->items[$i];

        if ($item->id!="" && $item->owner->id == $user){
            $html = "<tr>
<td><img src='%s' alt='img' class='coverimg'/></td>
<td>%s</td>
<td><button id='%s' class='playlist btn btn-xs'>Kies playlist</button></td>

</tr>";
            echo sprintf($html, $item->images[0]->url, $item->name, $item->id);
        }
    }
    ?>
    </tbody>
</table>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="js/playlist.js"></script>
</body>
</html>