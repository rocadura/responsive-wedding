$(document).ready(function(){});


function addGuest()
{
	var NoGuest = parseInt($('#GuestNo').val());
	var Input 	= 	'<div class="pure-control-group">' +
					'<label for="GuestNo_' + NoGuest + '">Nombre Invitado Secundario</label>' +
					'<input id="GuestNo_' + NoGuest + '" name="GuestNo_' + NoGuest + '" type="text" placeholder="Nobre Invitado Secundario ' + (NoGuest+1) + '" class="pure-u-1-2">' +
					'</div>';
	$(Input).appendTo("#advanced");
	$('#GuestNo').val(NoGuest+1);
}

function deleteGuest()
{
	var NoGuest = parseInt($('#GuestNo').val());
	NoGuest = NoGuest-1;
	if (NoGuest>=1){
	$( '#GuestNo_' + NoGuest ).closest( "div" ).remove();
	$('#GuestNo').val(NoGuest);
	}
}

function confirmedGuests()
{
        var numberOfChecked =$('input:checkbox:checked').length;
	$('#confirm_btn').html("Confirmar (" + numberOfChecked + ") Personas");
}
