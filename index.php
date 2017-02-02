<?php

$opts = array('http' => array('proxy' => 'www-cache:3128', "request_fulluri" => true));
$context = stream_context_create($opts);

$clientIp = $_SERVER['REMOTE_ADDR'];

$local = simplexml_load_string(file_get_contents("http://ip-api.com/xml/$clientIp", false, $context));

$long = $local->lon;
$lat = $local->lat;

$meteo = simplexml_load_string(file_get_contents("https://www.infoclimat.fr/public-api/gfs/xml?_ll=$lat,$long&_auth=ARsDFFIsBCZRfFtsD3lSe1Q8ADUPeVRzBHgFZgtuAH1UMQNgUTNcPlU5VClSfVZkUn8AYVxmVW0Eb1I2WylSLgFgA25SNwRuUT1bPw83UnlUeAB9DzFUcwR4BWMLYwBhVCkDb1EzXCBVOFQoUmNWZlJnAH9cfFVsBGRSPVs1UjEBZwNkUjIEYVE6WyYPIFJjVGUAZg9mVD4EbwVhCzMAMFQzA2JRMlw5VThUKFJiVmtSZQBpXGtVbwRlUjVbKVIuARsDFFIsBCZRfFtsD3lSe1QyAD4PZA%3D%3D&_c=19f3aa7d766b6ba91191c8be71dd1ab2", false, $context));


$xslt = new XSLTProcessor();
$xsl = new DOMDocument();
$xsl->load("meteo/meteo.xsl");
$xslt->importStylesheet($xsl);
echo "<!DOCTYPE html>
        <html>
           <head>
             <link href=\"meteo.css\" rel=\"stylesheet\"/>
             <link rel=\"stylesheet\" href=\"https://unpkg.com/leaflet@1.0.3/dist/leaflet.css\" />
             <meta charset='UTF-8'/>
           </head>
           <body>";
echo "<h1>Météo à $local->city</h1>";
echo $xslt->transformToXML($meteo);
echo "<script
             src=\"https://code.jquery.com/jquery-3.1.1.min.js\"
			       integrity=\"sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=\"
			       crossorigin=\"anonymous\"></script>
             <script src=\"https://unpkg.com/leaflet@1.0.3/dist/leaflet.js\"></script>
        <script type='text/javascript'>
        var apikey = '075bed26690f3fe3dd9e9e46091ed4405277f1ec';
$.ajax( {
    url: 'https://freegeoip.net/json/',
    type: 'GET',
    dataType: 'jsonp',
    success: function(location) {

        var mymap = L.map('mapid').setView([location.latitude ,location.longitude ], 15);
        //var marker = L.marker([location.latitude, location.longitude], {color : 'red'}).addTo(mymap);
        var circle = L.circle([location.latitude, location.longitude], {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: 25
        }).addTo(mymap);

        circle.bindPopup(\"<b>Je suis ici !</b>\").openPopup();

        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href=\"http://openstreetmap.org\">OpenStreetMap</a> contributors, <a href=\"http://creativecommons.org/licenses/by-sa/2.0/\">CC-BY-SA</a>, Imagery © <a href=\"http://mapbox.com\">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox.streets',
            accessToken: 'pk.eyJ1IjoibGF1bmF5MTJ1IiwiYSI6ImNpeW4ybTcyaDAwMGkycXBjd2ppemNnbHEifQ.8uPe0vZvhSFFPhPazNHmvQ'
        }).addTo(mymap);

        $.ajax({
            url: \"https://api.jcdecaux.com/vls/v1/stations?contract=Nancy&apiKey=\"+apikey,
            type: 'GET',
            datatype: 'json',
            success: function(success) {
                success.forEach(function(element){
                    console.log(element);
                    var marker = L.marker([element.position.lat, element.position.lng]).addTo(mymap);
                    marker.bindPopup(\"<b>\" + element.address + \"</b><br/><p>Vélos disponibles : \" + element.available_bikes +\"<br/>Places disponibles : \" + element.available_bike_stands + \"</p>\")
                })
            },
            error: function(e) {
                console.log(e);
            }
        })
    },
    error: function(e){
        console.log(e);
    }
});

        </script>
        </body>
         </html>";

?>
