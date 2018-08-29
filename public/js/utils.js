$(document).ready(function() {
	
	$.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });
	
	$(document).ajaxSend(function(event, request, settings) {
		$("#PopupMask").show();
	});

	$(document).ajaxComplete(function(event, request, settings) {
		$("#PopupMask").hide();
	});

	//Toutes les dates de cette classe ont un date picker
	$(".jqdate").datepicker({"helper":"datePickerup","jQueryParams":{"dateFormat":"yyyy-mm-dd"},"options":[]});
	
	
	//Detection de la touche entree
	$("input.tr").keydown(function(event) {
		/*
		if ( event.which == 13 ) {
			event.preventDefault();
			document.getElementById('formsearch').submit();
		}  
		*/
		
		//Remplace les virgules par des points
		if(event.keyCode == 188){
			event.preventDefault();
			$(this).val($(this).val() + '.');
		}
		//Supprime les espaces
		if(event.keyCode == 32){
			event.preventDefault();
		}
	});
	
	
});

/* Formate les chiffres correctement ex:1000->1 000.00 */
function format(num){
    var n = num.toFixed(2).toString(), p = n.indexOf('.');
    return n.replace(/\d(?=(?:\d{3})+(?:\.|$))/g, function($0, i){
        return p<0 || i<p ? ($0+' ') : $0;
    });
}

/* Formate les chiffres correctement ex:1 000->1000.00 */
function numformat(num){
    return num.toString().replace(' ','');
}