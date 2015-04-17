<?php
session_start();
require_once("Spotilib.php");
require_once("ajaxHelper.php");
require("settings/settings.php");

$spotify = new Spotilib();
$accessToken = $_SESSION["spotify_tokens"]->access_token;
$profile = $spotify->getUserProfileByAccesToken($accessToken);

$userid = $profile->id;

if(isset($_POST['savegeo'])){
    $geo = json_decode($_POST['savegeo']);
    $lat = $geo->lat;
    $long = $geo->long;

    require("settings/settings.php");

    $query = sprintf("UPDATE addplaylist SET latitude='%s', longitude='%s' WHERE user_id='%s' ", $lat, $long, $userid);
    mysqli_query($db, $query) or die (mysqli_error($db));
}

$query = sprintf("SELECT * FROM addplaylist WHERE user_id = '%s'", $userid);
$result = mysqli_query($db, $query) or die (mysqli_error($db));
$client = mysqli_fetch_assoc($result);


$query = sprintf("SELECT * FROM addplaylist WHERE user_id <> '%s'", $userid);
$result = mysqli_query($db, $query) or die (mysqli_error($db));

$playlists = array();
while($row = mysqli_fetch_assoc($result)){
    if(Helper::isInRange($row, $client, $_POST["maxDistance"])){
        $playlist = $spotify->getPlaylistById($accessToken, $row["user_id"], $row["playlist_id"]);
        $playlist->latitude = $row["latitude"];
        $playlist->longitude = $row["longitude"];
        array_push($playlists, $playlist);
    }
}

echo json_encode($playlists);


