<?php

//http://data.nantes.fr/api/getInfoTraficTANTempsReel/1.0/39W9VSNCSASEOGV/?output=json
//https://maps.googleapis.com/maps/api/geocode/json?address=1600+Amphitheatre+Parkway,+Mountain+View,+CA&key=YOUR_API_KEY
//filter={« location » :{« $near » :[<valeur_latitude>, <valeur_longitude>]}}
$urlGoogle = "https://maps.googleapis.com/maps/api/geocode/json?address=Nantes&key=";
$urlNante = "http://data.nantes.fr/api/getInfoTraficTANTempsReel/1.0/39W9VSNCSASEOGV/?output=json";
$apikey = "AIzaSyCgkxxGa2F1NwYDgKyRMiJAhMTykrwbgiY";

$opts = array('http' => array('proxy' => 'www-cache:3128', "request_fulluri" => true));
$context = stream_context_create($opts);

$coord = json_decode(file_get_contents($urlGoogle.$apikey, false, $context));
$lat = $coord->results[0]->geometry->location->lat;
$lng = $coord->results[0]->geometry->location->lng;
$infos = json_decode(file_get_contents("https://data.nantes.fr/api/publication/", false, $context));
var_dump($infos);
//$infos = json_decode(file_get_contents($urlNante.'&filter={« location » :{« $near » :['. $lat .', '. $lng .']}}', false, $context));


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
        <script type='text/javascript'>
        var apikey = '075bed26690f3fe3dd9e9e46091ed4405277f1ec';
        var mymap = L.map('mapid').setView([$lat,$lng ], 15);
        
        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox.streets',
            accessToken: 'pk.eyJ1IjoibGF1bmF5MTJ1IiwiYSI6ImNpeW4ybTcyaDAwMGkycXBjd2ppemNnbHEifQ.8uPe0vZvhSFFPhPazNHmvQ'
        }).addTo(mymap);
END;

foreach ($infos->opendata->answer->data->ROOT->LISTE_INFOTRAFICS as $info) {
    //echo "var marker = L.marker([element.position.lat, element.position.lng]).addTo(mymap);
      //              marker.bindPopup(\"<b>\" + element.address + \"</b><br/><p>Vélos disponibles : \" + element.available_bikes +\"<br/>Places disponibles : \" + element.available_bike_stands + \"</p>\")"
}

echo "</script>
        </body>
         </html>";
var_dump($infos->opendata->answer);