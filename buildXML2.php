<!DOCTYPE HTML>
<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Set </title>
  <meta name="description" content="The HTML5 Herald">
  <meta name="author" content="SitePoint">
Database
  <!--<link rel="stylesheet" href="css/styles.css?v=1.0"> -->

  <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  <style>
  #dimmer {position:fixed; top:0; left:0; width:100%; height:100%; display:none; background:rgba(0,0,0,0.8); z-index:1000; }
  #popup {background-color: green; height: 100px; width: 250px; position:absolute; top:100px; left:200px; opacity:1.0; z-index:1001;}
  </style>
</head>

<body>
<div id="dimmer">
<div id="popup" class="pass">
<input  type="password"/>
<input type="button" id="confirmPass" value="OK"/>
</div>
</div>
<input type="button" id="edit" value="EDIT"/>
<input type="button" id="changePass" value="CHANGE PASS"/>
<input type="button" id="delete" value="DEL"/>
<input type="button" id="moveUp" value="UP"/>
<input type="button" id="moveDown" value="DOWN"/>

<table id="credentials"><tr>
<td><a data-position="up" class="position" href="javascript:void(0);">▲</a></td>
<td><input type="text" class="new title" placeholder="Titulo"/></td>
<td><input type="text" class="new web" placeholder="Web"/></td>
<td><input type="text" class="new user" placeholder="Username"/></td>
<td><input type="text" class="new pass"  placeholder="Password"/></td>
<td><input type="button" id="new"  value="Novo"/></td>
</tr>
</table>

<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script>
	function buildTable(data){
		var _html="";		
		$(data).find('credential').each(function() {
			_html += '<tr class="rows"><td class="checked" data-pass="'+$(this).text()+'"><input type="radio" name="checked"></td>';
			_html += '<td class="editable title" data-info="'+$(this).attr("title")+'">'+$(this).attr("title")+'</td>';
			_html += '<td class="editable web" data-info="'+$(this).attr("web")+'">'+$(this).attr("web")+'</td>';
			_html += '<td class="editable user" data-info="'+$(this).attr("user")+'">'+$(this).attr("user")+'</td></tr>';			
		});
		$("table#credentials").append(_html);
	}
	

	$( document ).ready(function() {
	
	var selItem;

	$("body").on( "click", "#confirmPass" ,function() {
		$("#dimmer").fadeOut();
		console.log(selItem);
		console.log($("#credentials  tr.rows"));
		console.log($("#credentials  tr.rows").eq(selItem));
	})


	$("body").on( "click", "#new" ,function() {
	var _html = '<tr class="rows"><td class="checked"><input type="radio" name="checked"></td>';
	_html += '<td class="editable title">'+$("#credentials input.new.title").val()+'</td>';
	_html += '<td class="editable web">'+$("#credentials input.new.web").val()+'</td>';
	_html += '<td class="editable user">'+$("#credentials input.new.user").val()+'</td>';
	_html += '<td class="pass" data-mask="•••••••••••••" data-pass="'+$("#credentials input.new.pass").val()+'">•••••••••••••</td>';
	_html += '</tr>';
	$(this).parents("tr").after( _html);
	$(this).parents("tr").find("td input").val("");
	console.log(_html);
	});
	
	
	$("body").on( "click", "#moveUp" ,function() {
		var curr = $("#credentials  input[name=checked]:checked").parents('tr.rows');
		var idx = curr.index()-1;
		console.log(idx)
		if (idx>0){
		var previous= curr.parents("table").find("tr.rows").get(idx-1);		
		curr.insertBefore(previous);
		}
	});
	
	
	$("body").on( "click", "#moveDown" ,function() {
		console.log("down");
		var curr = $("#credentials  input[name=checked]:checked").parents('tr.rows');
		var idx = curr.index()-1;
		console.log($("table#credentials").find("tr.rows"));
		maxRows = $("table#credentials").find("tr.rows").length;
		console.log("curr:"+idx+"   maxRows: "+maxRows);
		if (idx<maxRows){
			var next= $("table#credentials").find("tr.rows").get(idx+1);		
			curr.insertAfter(next);
		}
			
	});

	$("body").on( "click", "#edit" ,function() {
		console.log("edit");
		var curr = $("#credentials  input[name=checked]:checked").parents('tr.rows');
		curr.find("td.editable").each(function(){
			var content = $(this).text();
			$(this).html('<input type="text" value="'+content+'"/>');
		});
	});
	
	
	$("body").on( "click", "#changePass" ,function() {
		selItem = $("#credentials  input[name=checked]:checked").parents('tr.rows').index();
		$("#dimmer").fadeIn();
		
		
		/*
		console.log("pass");
		var passTD = $("#credentials  input[name=checked]:checked").parents('tr.rows').find("td.pass");
		var content = passTD.data("pass");
		passTD.html('<input type="text" value="'+content+'"/>');
		passTD.find("input").focus().select();
		*/
	});


$('body').on("keydown", "#credentials td.pass input", function(e) {
	        	var defaults = $(this).parents("td").data("mask");
	        	var pass = $(this).parents("td").data("pass");;
        if (e.keyCode == 13) {
	        var changed = confirm("A password vai ser alterada. Deseja Continuar?");
        	if (changed ) {
	        	var newPass = $(this).val();
	        	$(this).parents("td").attr("data-pass", newPass);
	        	$(this).parents("td").text(defaults); 
        	}           	 
        	return false; // prevent the button click from happening
        } else if (e.keyCode == 27) {
	        $(this).parents("td").text(defaults);
        }
	
});



$('body').on("keydown", "#credentials td.editable input", function(e) {
	var info = $(this).parents("td").data("info");
        if (e.keyCode == 13) {
        	$(this).parents("tr").find("td.editable").each(function(){
	        	var newInfo = $(this).find("input").val();
	        	$(this).attr("data-info", newInfo);
	        	$(this).text(newInfo);
	        })  
        
        	var newInfo = $(this).val();
        	$(this).parents("td").attr("data-info", newInfo);
        	$(this).parents("td").text(newInfo);
        	          	 
        	return false; // prevent the button click from happening
        } else if (e.keyCode == 27) {
	        $(this).parents("tr").find("td.editable").each(function(){
	        	var info = $(this).data("info");
	        	$(this).text(info);
	        })       
	}
	
});


	$("body").on( "click", "#delete" ,function() {
		console.log("del");
		var curr = $("#credentials  input[name=checked]:checked").parents('tr.rows');
		if (confirm("Are you sure?")){
			curr.remove();
		}
	});

	  
	$.get( "jhpego.xml", function( data ) {
		buildTable(data);
		//alert( data );
	});
	
	
	$("body").on( "click", "#credentials .del" ,function() {
	if (confirm("Are you sure?")){
		$(this).parents("tr").remove();
	}

	});
	
	
	$("body").on( "click", "#credentials .save" ,function() {
		$(this).removeClass('save').addClass('edit');
		$(this).text("edit");
		$(this).parents("tr").find("td.editable").each(function(){
			var content = $(this).find("input").val();
			$(this).html(content);
		});
		console.log("save");
	});
	
	$("body").on( "click", "#credentials .edit" ,function() {
		$(this).removeClass('edit').addClass('save');
		$(this).text("save");
		$(this).parents("tr").find("td.editable").each(function(){
			var content = $(this).text();
			$(this).html('<input type="text" value="'+content+'"/>');
		});
		console.log();
	});


	$("body").on( "click", "#credentials .up" ,function() {
		var idx = $(this).parents("tr").index();
		if (idx>0){
		var curr = $(this).parents("tr");
		var previous= $(this).parents("table").find("tr").get(idx-1);		
		curr.insertBefore(previous);
		}
	});
	
	$("body").on( "click", "#credentials .down" ,function() {
		var idx = $(this).parents("tr").index();
		maxRows = $(this).parents("table").find("tr").length;
		console.log(maxRows);
		if (idx<maxRows){
		var curr = $(this).parents("tr");
		var next= $(this).parents("table").find("tr").get(idx+1);		
		curr.insertAfter(next);
		}
	});
	  
	  
	});
</script>
</body>
</html>