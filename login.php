<?php

session_start();

require_once("Spotilib.php");

$spotify = new Spotilib();

$spotify->requestAccessToken($_GET['code']);

$profile = $spotify->getUserProfileByAccesToken($_SESSION["spotify_tokens"]->access_token);

require("settings/settings.php");

$query = "INSERT INTO addplaylist (user_id) VALUES ('" . $profile->id . "')";
mysqli_query($db, $query);

header('Location: addplaylist.php');

?>