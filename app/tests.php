#!/usr/bin/env php
<?php

// TENGO UNA FECHA CREADA A LA 13 GMT.
// TENGO EL TIMESTAMP. la date en realidad.

// Como se modific ese timestamp?
// Como puedo cambiar a las 13hs PT y luego obtener un nuevo timestamp?
// ya se! 1) cambio DateTimeZone a una nueva DateTimeZone
// 2) me fijo cuanto falta para pasar eso a 13hs (para adelante?)
// 2.5) Ver si esa hora la paso para adelante o para atras!
// 3) En teoria eso , si pido timestamp da una nueva hora ya que tnego que modificar la date!
 
 
$timeZoneGMT = new DateTimeZone('GMT');

//date_default_timezone_set('Europe');
$timeZonePST = new DateTimeZone('PST');

// Creo que esta es LA forma de crear una fecha a las 13hs GMT
$date = \DateTime::createFromFormat('Y-m-d H:i:s', '2009-06-30 13:00:00', $timeZoneGMT);
//gmdate("Y-m-d H:i:s", mktime(13, 0, 0, 6,30,2009))
// creo que estos dos de arriba son iguales. Ver si es asi.

var_dump('unix time date 30-6-2009 13hs GMT: ');
var_dump($date->format('Y-m-d H:i:s e - U'));


$newDate = clone $date;

$newDate->setTimezone($timeZonePST);
var_dump('unix time date 30-6-2009 en PST: ');
var_dump($newDate->format('Y-m-d H:i:s e - U'));

//LISTO, ASI LA MODIFICO
var_dump('modifico para que este a las 13 (en PST)');
$newDate->setTime(13, 0, 0);
var_dump('unix time date 30-6-2009 en PST: ');
var_dump($newDate->format('Y-m-d H:i:s e - U'));

/*
$timestamp = mktime(13, 0, 0, 6,30,2009);
var_dump('unix time mktime created date (6-30-2009 13hs (GMT in theory)): ');
var_dump($timestamp);

var_dump('unix time mktime created date (6-30-2009 13hs in America/Montreal): ');
var_dump($date->format('Y-m-d H:i:s e - U'));

var_dump('unix time mktime created date date (6-30-2009 13hs in America/Montreal) shown in another TimeZone: ');
var_dump($date->setTimezone($timeZoneGMT)->format('Y-m-d H:i:s e - U'));

// NO SE QUE ESTOY HACIENDO EN ESTA PARTE
/*
 var_dump('timestmp formatted normally and then to GMT');
var_dump(date('Y-m-d H:i:s', $timestamp));
var_dump(gmdate('Y-m-d H:i:s', $timestamp));
var_dump(gmdate('Y-m-d H:i:s', $timestamp));
*/
/*
var_dump('date created from timestamp.');
$dateFromTimestamp = new DateTime('@'.$timestamp);
var_dump('Formatted in current timezone');
var_dump($date->format('Y-m-d H:i:s e - U'));

var_dump('Formatted in America/Montreal timezone');
var_dump($date->setTimezone(new DateTimeZone('America/Montreal'))->format('Y-m-d H:i:s e - U'));
*/


/*
 //gmdate(mktime(13, 0, 0, 6,30,2009))
var_dump("----- date formated -----");
//$date->setTimezone($timezone);
var_dump($date);
var_dump('format as text: ');
var_dump($date->format('Y-m-d H:i:sP'));
var_dump('format as timestamp: ');
var_dump($date->format('U'));
/*
$date = new DateTime('@1246406400');
//gmdate("M d Y H:i:s", mktime(0, 0, 0, 1, 1, 1998)
        //$date->setTimezone($timeZone);
        var_dump("date formated: ");
        var_dump($date->format('Y-m-d H:i:sP'));
        var_dump("date: ");
        var_dump($date);
        */

/*
 var_dump("----- my date -----");
$date = new DateTime('@1246366800');
//$date->setTimezone($timezone);
var_dump("date formated: ");
var_dump($date->format('Y-m-d H:i:sP'));
var_dump("date: ");
var_dump($date);
*/

//strtotime($time);

