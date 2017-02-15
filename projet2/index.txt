<?php

//http://data.nantes.fr/api/getInfoTraficTANTempsReel/1.0/39W9VSNCSASEOGV/?output=json
//https://maps.googleapis.com/maps/api/geocode/json?address=1600+Amphitheatre+Parkway,+Mountain+View,+CA&key=YOUR_API_KEY
//filter={« location » :{« $near » :[<valeur_latitude>, <valeur_longitude>]}}
$urlGoogle = "https://maps.googleapis.com/maps/api/geocode/json?address=Nantes&key=";
$urlLoire = "http://api.loire-atlantique.fr:80/opendata/1.0/traficevents?filter=Tous";
$apikey = "AIzaSyCgkxxGa2F1NwYDgKyRMiJAhMTykrwbgiY";

$opts = array('http' => array('proxy' => 'www-cache:3128', "request_fulluri" => true));
$context = stream_context_create($opts);

$coord = json_decode(file_get_contents($urlGoogle.$apikey, false, $context));
$lat = $coord->results[0]->geometry->location->lat;
$lng = $coord->results[0]->geometry->location->lng;
$infos = json_decode(file_get_contents($urlLoire, false, $context));
//var_dump($infos);


echo <<<END
<!DOCTYPE html>
        <html>
           <head>
             <link href="meteo.css" rel="stylesheet"/>
             <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css" />
             <meta charset='UTF-8'/>
           </head>
           <body>
<h1>Info trafic Nantes</h1>
<div id="mapid"></div>
<script
             src="https://code.jquery.com/jquery-3.1.1.min.js"
			       integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
			       crossorigin="anonymous"></script>
             <script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js"></script>
        <script>
        var apikey = '075bed26690f3fe3dd9e9e46091ed4405277f1ec';
        var mymap = L.map('mapid').setView([$lat,$lng ], 10);
        
        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox.streets',
            accessToken: 'pk.eyJ1IjoibGF1bmF5MTJ1IiwiYSI6ImNpeW4ybTcyaDAwMGkycXBjd2ppemNnbHEifQ.8uPe0vZvhSFFPhPazNHmvQ'
        }).addTo(mymap);

END;

foreach ($infos as $info) {
    echo "var marker = L.marker([$info->latitude, $info->longitude]).addTo(mymap);
          marker.bindPopup(\"<b>$info->ligne1</b><br/><p>$info->ligne2<br/>$info->ligne3 <br/>$info->ligne4</p>\");
          ";
}

echo "</script>
        </body>
         </html>";