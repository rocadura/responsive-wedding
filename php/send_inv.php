<?php
include('functions.php');

$id = isset($_GET['id']) ? $_GET['id'] : 0;

if ($id >0) {
send_inv($id);
}

header("Location: /php/menu.php");



?>