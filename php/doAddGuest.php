<?php
include('functions.php');

foreach ($_POST as $var => $value)
{
	$$var = $value;
	echo "$$var<br/>";
}

$Guests = array();

if ($GuestNo>1)
{
	for ($i=0; $i<$GuestNo ; $i++)
    {
		if (!is_null(${'GuestNo_'.$i}) && ${'GuestNo_'.$i}!=="")
        {
			$Guests[] = ${'GuestNo_'.$i};
		}
	}
}

echo set_InvitationGuest($Name, $Email, $UniqueKey, $Guests, $Id_Category);

header("Location: menu.php");

?>
