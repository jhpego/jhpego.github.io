
$(document).ready(function() {


var defaultName = $("#contactMe #name").val();
var defaultEmail = $("#contactMe #email").val();
var defaultMsg = $("#contactMe #msg").html();


$('a[href^="#"]').bind('click.smoothscroll',function (e) {
    e.preventDefault();
    var target = this.hash,
        $target = $(target);
    $('html, body').stop().animate({
        'scrollTop': $target.offset().top
    }, 500, 'swing', function () {
        window.location.hash = target;
    });
});


$("#enviar").click( function() { 
		$.post("scripts/email.php", $("#contactMe").serialize() , function(data) {
			data = jQuery.parseJSON(data);
			if (data.length==0){
				$("#statusMsg").html("Mensagem Enviada").fadeOut(1000,'easeInQuint',function(){$(this).html("").show()});
				$("#contactMe #name").val(defaultName);
				$("#contactMe #email").val(defaultEmail);
				$("#contactMe #msg").val(defaultMsg);
				$("#statusMsg")
			}
			else {
				$("#statusMsg").html("Verifique os seguintes erros:<br/>");
				for (var i in data)
					$("#statusMsg").append(data[i]+"<br/>");
			}
		});
});





$("#contactMe #name").blur( function() {
	if ($(this).val() == "")
		$(this).val(defaultName);
})
	
$("#contactMe #name").focus( function() {
	if ($(this).val() == defaultName)
		$(this).val("");
})

$("#contactMe #email").blur( function() {
	if ($(this).val() == "")
		$(this).val(defaultEmail);
})
	
$("#contactMe #email").focus( function() {
	if ($(this).val() == defaultEmail)
		$(this).val("");
})

$("#contactMe #msg").blur( function() {
	if ($(this).html() == "")
		$(this).html(defaultMsg);
}).focus( function() {
	if ($(this).html() == defaultMsg)
		$(this).empty();
})

$( "#dialogBox" ).dialog({
			autoOpen: false ,
			modal: true,
			buttons: {
				Ok: function() {
					$( this ).dialog( "close" );
				}
			}
		});


		
$(".showBT").click( function(){
$(this).parent().parent().parent().find(".hidden").toggle();
if ($(this).html() == "Ocultar")
	$(this).html("Ver +");
else
	$(this).html("Ocultar");

});		

});

function forbiden(){
$( "#dialogBox" ).dialog("open");
}