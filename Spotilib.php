<?php

class Spotilib {
    private $authUrl = "https://accounts.spotify.com";
    private $apiUrl = "https://api.spotify.com";

    private $config = array(
        "clientId" => "",
        "clientSecret" => "",
                 "redirectUrl" => "your_url_here"
    );

    public function getLoginUrl() {
        $params = array(
            "client_id" => $this->config["clientId"],
            "response_type" => "code",
            "redirect_uri" => $this->config["redirectUrl"],
        );

        return $this->authUrl."/authorize?".http_build_query($params);
    }

    public function getUserProfileByAccesToken($accessToken){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_URL, $this->apiUrl."/v1/me");
        curl_setopt($ch,CURLOPT_HTTPHEADER, array('Authorization: Bearer '. $accessToken));
        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result);
    }

    public function getPlaylistsByAccesToken($accessToken, $user){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_URL, $this->apiUrl."/v1/users/". $user . "/playlists");
        curl_setopt($ch,CURLOPT_HTTPHEADER, array('Authorization: Bearer '. $accessToken));
        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result);
    }

    public function getPlaylistById($accessToken, $userid, $playlistid){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_URL, $this->apiUrl."/v1/users/".$userid."/playlists/". $playlistid);
        curl_setopt($ch,CURLOPT_HTTPHEADER, array('Authorization: Bearer '. $accessToken));
        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result);
    }

    public function getPlaylistTracksByID($accessToken, $userid, $playlistid){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_URL, $this->apiUrl."/v1/users/".$userid."/playlists/".$playlistid."/tracks");
        curl_setopt($ch,CURLOPT_HTTPHEADER, array('Authorization: Bearer '. $accessToken));
        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result);
    }

    public function requestAccessToken($code) {
        $params = array(
            "client_id" => $this->config["clientId"],
            "grant_type" => "authorization_code",
            "code" => $code,
            "redirect_uri" => $this->config["redirectUrl"]
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_URL, $this->authUrl."/api/token");
        curl_setopt($ch,CURLOPT_POST, count($params));
        curl_setopt($ch,CURLOPT_POSTFIELDS, http_build_query($params));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $baseEncoded = base64_encode ( $this->config["clientId"].":".$this->config["clientSecret"] );

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Basic '.$baseEncoded
        ));

        $result = curl_exec($ch);

        curl_close($ch);

        $r = json_decode($result);

        if (isset($r->error)) {
            print_r($r); exit;
        }

        $_SESSION["spotify_tokens"] = $r;
    }
}
