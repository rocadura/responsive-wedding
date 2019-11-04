<?php
include('functions.php');

foreach ($_POST as $var => $value){
  	$$var = $value;
	// echo "$$var<br/>";
}

for ($i=0; $i<$counter ; $i++) {
    $Id = ${'Id_'.$i};
    $Id_Food = is_numeric(${'Food_'.$i}) ? ${'Food_'.$i} : 0;
    $Guest = ${'Guest_'.$i};
    // echo "Guest is $Guest";
    $Accept = ${'Confirm_'.$i};
    // echo "Accept is $Accept";
    if ($Accept ==0){$Id_Food='0';}
    // echo "Id_Food is $Id_Food";;
    updateGuest($Id, $Id_Food, $Accept);
}

include('/home/rocadura/html/html/conf_en.html');



?>
