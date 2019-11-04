<?php
date_default_timezone_set('Europe/Berlin');
include('turbine_wrapper.php');

define("HOST", "localhost");
define("USER", "root");
define("PSWD", "");
define("DB",   "wedding");

function randomKey($length) {
    $pool = array_merge(range(0,9), range('a', 'z'),range('A', 'Z'));
	$key = "";
    for($i=0; $i < $length; $i++) {
        $key .= $pool[mt_rand(0, count($pool) - 1)];
    }
    return $key;
}

function getHTML_Categories(){
	turbine::open(HOST, USER, PSWD, DB);
	$q = turbine::query('SELECT * FROM `categories`');
	turbine::close();
	$select = "";
	foreach ($q as $key=>$category) {
		$select .= "<option value='".$category['Id']."'>".$category['Name']."</option>";
	}
	return $select;
}

function getHTML_Foods(){
	turbine::open(HOST, USER, PSWD, DB);
	$q = turbine::query('SELECT * FROM `foods`');
	turbine::close();
	$select = "";
	foreach ($q as $key=>$category) {
		$select .= "<option value='".$category['Id']."'>".$category['Name']."</option>";
	}
	return $select;
}

function getHTML_Foods_en(){
	turbine::open(HOST, USER, PSWD, DB);
	$q = turbine::query('SELECT * FROM `foods_en`');
	turbine::close();
	$select = "";
	foreach ($q as $key=>$category) {
		$select .= "<option value='".$category['Id']."'>".$category['Name']."</option>";
	}
	return $select;
}


function set_InvitationGuest($Name, $Email, $UniqueKey, $Guests, $Id_Category){
	turbine::open(HOST, USER, PSWD, DB);
	//$date = date_timestamp_get(date_create());
	$q = turbine::query("INSERT INTO `invitations` (`Name`, `Email`, `UniqueKey` ) VALUES ('$Name', '$Email', '$UniqueKey' )");
	$id = turbine::get_last_id();
	$q = turbine::query("INSERT INTO `guests` (`Id_Invitation`, `Name`, `Id_Category` ) VALUES ('$id', '$Name', '$Id_Category')");

	if (count( $Guests) > 0 ) {
	foreach ($Guests as $Guest_Name){
		$q = turbine::query("INSERT INTO `guests` (`Id_Invitation`, `Name`, `Id_Category` ) VALUES ('$id', '$Guest_Name', '$Id_Category')");
	}
	}
	turbine::close();
	//print_r(turbine::get_log());
	return turbine::get_query_count();
}

function delete_InvitationGuest($Id){
	turbine::open(HOST, USER, PSWD, DB);
	$id_invitation = turbine::query_single("SELECT `Id_Invitation` FROM `guests` WHERE  `Id`=$Id");
	$q = turbine::query("DELETE FROM `guests` WHERE  `Id`=$Id");
	$total = turbine::query_single("SELECT count(Id_Invitation) as Suma FROM `guests` WHERE  `Id_Invitation`=$id_invitation");
	if ($total==0){
		$q = turbine::query("DELETE FROM `invitations` WHERE  `Id`=$id_invitation");
	}
	turbine::close();
	return turbine::get_query_count();
}

function getGuests($UniqueKey){
	turbine::open(HOST, USER, PSWD, DB);
	$q = turbine::query("SELECT Name FROM overview WHERE `UniqueKey`='$UniqueKey'");
	$text = "";
	foreach ($q as $key=>$guest) {
		$text .= "<p>".$guest['Name']."</p>";
	}
	turbine::close();
	return $text;
}

function countGuests($UniqueKey){
	turbine::open(HOST, USER, PSWD, DB);
	$found = turbine::query_single("SELECT count(Name) as Suma FROM overview WHERE `UniqueKey`='$UniqueKey'");
	turbine::close();
	return $found;
}

function updateGuest($Id, $Id_Food, $Accept) {
	turbine::open(HOST, USER, PSWD, DB);
	if ($Id_Food>0){
			$found = turbine::query_single("UPDATE `guests` SET `Id_Food`='$Id_Food', `Accept`='$Accept' WHERE  `Id`=$Id");
    }
	else
	{
 		$found = turbine::query_single("UPDATE `guests` SET `Accept`='$Accept' WHERE  `Id`=$Id");
        nullFood($Id);
    }
	turbine::close();
	return $found;
}

function confirmationForm($UniqueKey)
{
	turbine::open(HOST, USER, PSWD, DB);
	$q = turbine::query("SELECT Id, Name, Id_Food, Food, Accept FROM overview WHERE `UniqueKey`='$UniqueKey'");
	$text = "";
	foreach ($q as $key=>$guest)
    {
		$Id = $guest['Id'];
		$Name = $guest['Name'];
		$Id_Food = is_null($guest['Id_Food']) ? 0 : $guest['Id_Food'];
		$Food = ($guest['Food']=="") ? "<select id='food' name='Food_$key'>".getHTML_Foods()."</select>" :
              "<select id='food' name='Food_$key'><option value='$Id_Food' selected='selected'>Actual: ".$guest['Food']."</option>".getHTML_Foods()."</select>";
		$Accept = is_null($guest['Accept']) ? "" : "checked";
        if ($key == 0)
        {
            $text .= <<<html

<script type="text/javascript">function viewfood_$key(){   if($('#option_$key').val()=="1")    {        $("#ask_food_$key").show();    }    else    {  $("#ask_food_$key").hide();}}</script>

                     <div class="column full">
                       <input type='hidden' name='Id_$key' value='$Id' />
                       <input type='hidden' value="$Name" name='Guest_$key' readonly="readonly">
                       <p class="guests">$Name<br/>
                        attending? <select id="option_$key" name='Confirm_$key' onchange="viewfood_$key();"><option value='1'>Si</option><option value='0'>No</option></select><br/>
                      </p>
                      <p id="ask_food_$key" class="guests" style="margin-top:-3%;">Prefered food? $Food</p>
                      </div>
                      <script language="javascript">viewfood_$key();</script>
html;
        }
            else
        {
            $text .= <<<html

<script type="text/javascript">function viewfood_$key(){   if($('#option_$key').val()=="1")    {        $("#ask_food_$key").show();    }    else    {  $("#ask_food_$key").hide();}}</script>

                     <div class="column full">
                     <input type='hidden' name='Id_$key' value='$Id' />
                     <input type='hidden' value="$Name" name='Guest_$key' readonly="readonly">
                     <p class="guests">$Name <br/>
                     asistirás? <select id='option_$key' name='Confirm_$key' onchange="viewfood_$key();"><option value='1'>Si</option><option value='0'>No</option></select><br/>
                     </p>
                     <p id="ask_food_$key" class="guests" style="margin-top:-3%;">Que te gustaría comer? $Food</p>
                     </div>
                     <script language="javascript">viewfood_$key();</script>
html;

			}
	}
	$text .= " <input type='hidden' name='counter' value='".count($q)."' />";


	turbine::close();
	return $text;
}




function confirmationForm_en($UniqueKey){
	turbine::open(HOST, USER, PSWD, DB);
	$q = turbine::query("SELECT Id, Name, Id_Food, Food, Accept FROM overview WHERE `UniqueKey`='$UniqueKey'");
	$text = "";
	foreach ($q as $key=>$guest) {
		$Id = $guest['Id'];
		$Name = $guest['Name'];
		$Id_Food = is_null($guest['Id_Food']) ? 0 : $guest['Id_Food'];
		$Food = ($guest['Food']=="") ? "<select id='food' name='Food_$key'>".getHTML_Foods_en()."</select>" :
              "<select id='food' name='Food_$key'><option value='$Id_Food' selected='selected'>Current: ".$guest['Food']."</option>".getHTML_Foods_en()."</select>";
		$Accept = is_null($guest['Accept']) ? "" : "checked";
        if ($key == 0){
            $text .= <<<html

<script type="text/javascript">function viewfood_$key(){   if($('#option_$key').val()=="1")    {        $("#ask_food_$key").show();    }    else    {  $("#ask_food_$key").hide();}}</script>

							<div class="column full">
                               <input type='hidden' name='Id_$key' value='$Id' />
                               <input type='hidden' value="$Name" name='Guest_$key' readonly="readonly">
                               <p class="guests">$Name <br/>
                                  Are your joining us?
                               <select id='option_$key' name='Confirm_$key' onchange="viewfood_$key();"><option value='1'>Yes</option><option value='0'>No</option></select><br/></p>
                               <p id="ask_food_$key" class="guests" style="margin-top:-3%;">What would you like to eat? $Food</p>
                            </div>
                            <script language="javascript">viewfood_$key();</script>
html;
        }
        else
        {
            $text .= <<<html

<script type="text/javascript">function viewfood_$key(){   if($('#option_$key').val()=="1")    {        $("#ask_food_$key").show();    }    else    {  $("#ask_food_$key").hide();}}</script>
								<div class="column full">
                                    <input type='hidden' name='Id_$key' value='$Id' />
                                    <input type='hidden' value="$Name" name='Guest_$key' readonly="readonly">
							        <p class="guests">$Name <br/>
                                    Are you joining us?
                                    <select id='option_$key' name='Confirm_$key' onchange="viewfood_$key();"><option value='1'>Yes</option><option value='0'>No</option></select><br/></p>
                                    <p id="ask_food_$key" class="guests" style="margin-top:-3%;">What would you like to eat? $Food</p>
							    </div>
                      <script language="javascript">viewfood_$key();</script>
html;

			}
	}
	$text .= " <input type='hidden' name='counter' value='".count($q)."' />";


	turbine::close();
	return $text;
}



function getAllInvitation(){
	turbine::open(HOST, USER, PSWD, DB);
	$q = turbine::query('SELECT * FROM `overview` LIMIT 1000');
	turbine::close();
	$text = "<table border='1'>";
	foreach ($q as $key=>$row) {
		if ($key==0){

			$text .= "<tr>";
			foreach ($row as $index=>$cell) {
				$text .= "<td>$index</td>";
			}
			$text .= "<td>Visitar</td>";
			$text .= "<td>Borrar</td>";
            $text .= "<td>Enviar</td>";
			$text .= "</tr>";
		}

		$text .= "<tr>";
		foreach ($row as $index=>$cell) {
			$text .= "<td>$cell</td>";
		}
		$text .= "<td><a href='../php/invited.php?uniquekey=".$row['UniqueKey']."'>Ir</a></td>";
		$text .= "<td><a href='../php/deleteGuest.php?id=".$row['Id']."'>Borrar</a></td>";
		$text .= "<td><a href='../php/send_inv.php?id=".$row['Id']."'>Enviar</a></td>";
		$text .= "</tr>";
	}
	$text .= "<table>";
	return $text;
}


function getBasicData(){
	turbine::open(HOST, USER, PSWD, DB);
	$q = turbine::query('SELECT * FROM
(SELECT count(Id) as No_Invitations FROM `invitations`) as a,
(SELECT count(Id) as No_Guests FROM `guests`) as b,
(SELECT count(Id) as No_Guests_Accepted FROM `guests` WHERE Accept=1) as c');
	turbine::close();
	$text = "<table border='1'>";
	foreach ($q as $key=>$row) {
		if ($key==0){

			$text .= "<tr>";
			foreach ($row as $index=>$cell) {
				$text .= "<td>$index</td>";
			}
			$text .= "</tr>";
		}

		$text .= "<tr>";
		foreach ($row as $index=>$cell) {
			$text .= "<td>$cell</td>";
		}
		$text .= "</tr>";
	}
	$text .= "<table>";
	return $text;
}

function getFoodData() {
	turbine::open(HOST, USER, PSWD, DB);
	$q = turbine::query('SELECT Food, count(Food) FROM overview GROUP BY Food');
	turbine::close();
	$text = "<table border='1'>";
	foreach ($q as $key=>$row) {
		if ($key==0){

			$text .= "<tr>";
			foreach ($row as $index=>$cell) {
				$text .= "<td>$index</td>";
			}
			$text .= "</tr>";
		}

		$text .= "<tr>";
		foreach ($row as $index=>$cell) {
			$text .= "<td>$cell</td>";
		}
		$text .= "</tr>";
	}
	$text .= "<table>";
	return $text;


}

function guestConfirmation($UniqueKey){
	turbine::open(HOST, USER, PSWD, DB);
	$q = turbine::query("SELECT Id, Name, Id_Food, Food, Accept FROM overview WHERE `UniqueKey`='$UniqueKey'");
    $r = array("Menu 1", "Menu 2", "Vegetarian", "Kids Menu");
	$text = "";
	foreach ($q as $key=>$guest) {
		$Id = $guest['Id'];
		$Name = $guest['Name'];
        $Food = $r[$guest['Id_Food']-1];
        $Accept = $guest['Accept'];
        if ($Accept == 1){
        $text .=<<<html
                          <div class="column full">
                            <p class="guests">The chosen food for $Name was $Food. </p>
                          </div><!--end column-->
html;
        }
            else
        {
            $text .=
                  <<<html
                          <div class="column full">
                            <p class="guests">We are sorry to hear that $Name cannot join us. We know your thoughts are with us.</p>
                          </div><!--end column-->
html;
        }
	}
	turbine::close();
	return $text;
}

function guestConfirmation_en($UniqueKey){
	turbine::open(HOST, USER, PSWD, DB);
	$q = turbine::query("SELECT Id, Name, Id_Food, Food, Accept FROM overview WHERE `UniqueKey`='$UniqueKey'");
    $r = array("Menu 1", "Menu 2", "Vegetarian", "Kids Menu");
	$text = "";
	foreach ($q as $key=>$guest) {
		$Id = $guest['Id'];
		$Name = $guest['Name'];
        $Food = $r[$guest['Id_Food']-1];
        $Accept = $guest['Accept'];
        if ($Accept == 1){
        $text .=<<<html
                          <div class="column full">
                            <p class="guests">The chosen food for $Name was $Food. </p>
                          </div><!--end column-->
html;
        }
            else
        {
            $text .=
                  <<<html
                          <div class="column full">
                            <p class="guests">We are sorry to hear that $Name cannot join us. We know your thoughts are with us.</p>
                          </div><!--end column-->
html;
        }
	}
	turbine::close();
	return $text;
}


function nullFood($Id){
	turbine::open(HOST, USER, PSWD, DB);
	$q = turbine::query_single("UPDATE guests SET Id_Food=NULL WHERE Id='$Id'");
	turbine::close();
}

function send_inv($Id){
	turbine::open(HOST, USER, PSWD, DB);
	// $id_invitation = turbine::query_single("SELECT `Id_Invitation` FROM `guests` WHERE  `Id`=$Id");
	$q = turbine::query("UPDATE overview SET Send=Now() WHERE `Id`=$Id");
	turbine::close();
	return turbine::get_query_count();
}




?>
