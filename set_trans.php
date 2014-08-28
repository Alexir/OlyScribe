<?php
// Update a .trans file when a new (or modded) transcription is entered
// [201205] (air) Started

error_reporting(E_ALL);
ini_set('error_log','phperror.log');

// insert entry into the trans field, but also should write it out

$q=$_GET["q"];
$f=$_GET["f"];

// entry into the trans field (ucase to match decoder output)

// normalize spaces, etc. (weak on puncts!)
$q = implode(" ",preg_split('/[\s,]+/',strtoupper($q)));
$f = urldecode($f);
$ids = str_replace("/","-", str_replace("../","",$f));

// file it
file_put_contents($f.".trans",$q." (".$ids.")\n");
echo htmlentities($q); // return it to web page

exit();

?>
