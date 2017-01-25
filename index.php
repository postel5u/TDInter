<?php

  $clientIp = $_SERVER['REMOTE_ADDR'];

  var_dump($clientIp);

  $local = simplexml_load_string(file_get_contents("http://ip-api.com/xml/37.168.5.201"));

  var_dump($local->query[0]);

  $long = $local->query->lon;
  $lat = $local->query->lat;

  echo ("Longitude : ".$long."<br/>"."Lattitude : ".$lat);

 ?>
