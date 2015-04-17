<?php


class Helper{

    static function isInRange($location1, $location2, $maxDistance){
        $dist = Helper::getDistance($location1, $location2, "K");
        return $dist < $maxDistance;
    }


    static function getDistance($location1, $location2, $unit){

        $radlat1 = pi() * $location1['latitude']/180;
        $radlat2 = pi() * $location2['latitude']/180;
    //    $radlon1 = Math.PI * $location1['lng']/180;
    //    $radlon2 = Math.PI * $location2['lng']/180;
        $theta = $location1['longitude']-$location2['longitude'];
        $radtheta = pi() * $theta/180;
        $dist = sin($radlat1) * sin($radlat2) + cos($radlat1) * cos($radlat2) * cos($radtheta);

        $dist = acos($dist);
        $dist = $dist * 180/pi();
        $dist = $dist * 60 * 1.1515;

        if ($unit=="K") { $dist = $dist * 1.609344; }
        if ($unit=="N") { $dist = $dist * 0.8684; }

        return $dist;
    }

}