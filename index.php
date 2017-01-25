<?php

  $opts = array('http' => array('proxy' => 'www-cache:3128', "request_fulluri" => true));
  $context = stream_context_create($opts);

  $clientIp = $_SERVER['REMOTE_ADDR'];

  $local = simplexml_load_string(file_get_contents("http://ip-api.com/xml/37.168.5.201", false, $context));

  $long = $local->lon;
  $lat = $local->lat;

  echo ("Longitude : ".$long."<br/>"."Lattitude : ".$lat);

 ?>
