<?php

$opts = array('http' => array('proxy' => 'www-cache:3128', "request_fulluri" => true));
$context = stream_context_create($opts);

$clientIp = $_SERVER['REMOTE_ADDR'];

$local = simplexml_load_string(file_get_contents("http://ip-api.com/xml/37.168.5.201", false, $context));

$long = $local->lon;
$lat = $local->lat;

echo ("Longitude : ".$long."<br/>"."Lattitude : ".$lat);

$meteo = simplexml_load_string(file_get_contents("https://www.infoclimat.fr/public-api/gfs/xml?_ll=$lat,$long&_auth=ARsDFFIsBCZRfFtsD3lSe1Q8ADUPeVRzBHgFZgtuAH1UMQNgUTNcPlU5VClSfVZkUn8AYVxmVW0Eb1I2WylSLgFgA25SNwRuUT1bPw83UnlUeAB9DzFUcwR4BWMLYwBhVCkDb1EzXCBVOFQoUmNWZlJnAH9cfFVsBGRSPVs1UjEBZwNkUjIEYVE6WyYPIFJjVGUAZg9mVD4EbwVhCzMAMFQzA2JRMlw5VThUKFJiVmtSZQBpXGtVbwRlUjVbKVIuARsDFFIsBCZRfFtsD3lSe1QyAD4PZA%3D%3D&_c=19f3aa7d766b6ba91191c8be71dd1ab2", false, $context));


$xslt = new XSLTProcessor();
$xsl = new DOMDocument();
$xsl->load("meteo/meteo.xsl");
$xslt->importStylesheet($xsl);

echo $xslt->transformToXML($meteo);
//var_dump($meteo->echeance[0]);

?>
