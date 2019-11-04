<?php
include('functions.php');
$uniquekey = isset($_GET["uniquekey"]) ? $_GET["uniquekey"] : 0;
$found = countGuests($uniquekey);

include('../html/invited.html');


?>