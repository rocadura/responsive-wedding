o<?php
include('functions.php');

foreach ($_POST as $var => $value){
  	$$var = $value;
}

for ($i=0; $i<$counter ; $i++) {
    $Id = ${'Id_'.$i};
    $Id_Food = is_numeric(${'Food_'.$i}) ? ${'Food_'.$i} : 0;
    $Guest = ${'Guest_'.$i};
    $Accept = ${'Confirm_'.$i};
    if ($Accept ==0){$Id_Food='0';}
    updateGuest($Id, $Id_Food, $Accept);
}

include('../html/confirmation.html');

?>
