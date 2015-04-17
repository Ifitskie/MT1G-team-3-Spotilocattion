(function ($, window, document, undefined) {
    var map;

    function initialize() {
        var mapOptions = {
            zoom: 14
        };
        map = new google.maps.Map(document.getElementById('map'),
            mapOptions);

        // Try HTML5 geolocation
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var pos = new google.maps.LatLng(position.coords.latitude,
                    position.coords.longitude);
                ajaxCall(pos, 5);
                addMapMarker(pos, "Jouw positie", "assets/homemarker.png");
                map.setCenter(pos);

            }, function () {
                handleNoGeolocation(true);
            });
        } else {
            // Browser doesn't support Geolocation
            handleNoGeolocation(false);
        }
    }

    function addMapMarker(pos, contentString, icon) {

        var mapMarker = new google.maps.Marker({
            position: pos,
            animation: google.maps.Animation.DROP,
            map: map,
            icon: icon
        });
        var infowindow = new google.maps.InfoWindow({
            content: contentString
        });

        google.maps.event.addListener(mapMarker, 'click', function () {
            if (infowindow) {
                infowindow.close();
            }

            infowindow.open(map, mapMarker);
        });
    }

    $("#calculate").click( function(){
        var distance = $("#maxDistance").val();
        ajaxCall(null, distance);
    });

    function ajaxCall(pos, distance) {
        var data = {};

        if(pos != null && pos != "undefined"){
            data.savegeo = "{ \"lat\":" + pos.lat() + ", \"long\": " + pos.lng() + " }";
        }

        data.maxDistance = distance;
        $.ajax({
            method: "POST",
            url: "ajax.php",
            data: data
        })
            .done(function (msg) {
            console.log(msg);
                var width = $("#map").width();
                map.setZoom(calculateZoomLevel(width, distance));
                var playlists = JSON.parse(msg);
                $.each(playlists, function (index, playlist) {
                    var pos = new google.maps.LatLng(playlist.latitude, playlist.longitude);
                    var link = "<img src='"+playlist.images[0].url+"' class='coverimg' alt=''/> <a href='details.php?user_id=" + playlist.owner.id + "&playlist_id=" + playlist.id + "'>" + playlist.name + "</a>";
                    addMapMarker(pos, link, "assets/listmarker.png");

                    $("#allPlaylists").append("<tr><td><img src='"+playlist.images[0].url+"' class='img-rounded' alt='image'/></td><td><a href='details.php?user_id="+playlist.owner.id+"&playlist_id="+playlist.id+"'>"+ playlist.name+"</a></td><td>"+playlist.followers.total+"</td></tr>");
                });
            });
    }



    function calculateZoomLevel(screenWidth, distance) {
        var equatorLength = 40075004; // in meters
        var widthInPixels = screenWidth;
        var metersPerPixel = equatorLength / 256;
        var zoomLevel = 1;
        while ((metersPerPixel * widthInPixels) > distance*10000) {
            metersPerPixel /= 2;
            ++zoomLevel;
        }
        return zoomLevel;
    }

    function handleNoGeolocation(errorFlag) {
        if (errorFlag) {
            var content = 'Error: The Geolocation service failed.';
        } else {
            var content = 'Error: Your browser doesn\'t support geolocation.';
        }

        var options = {
            map: map,
            position: new google.maps.LatLng(60, 105),
            content: content
        };

        var infowindow = new google.maps.InfoWindow(options);
        map.setCenter(options.position);
    }

    google.maps.event.addDomListener(window, 'load', initialize);

}(jQuery, window, document)
    );

