<?php session_start()?>

<!DOCTYPE html>
<html>
<head>
<title>Jorge Pego Online</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<meta name="google-site-verification" content="Rr7Ap42QwRNZxHQtohEGfmxIH8eJhjj8hI6gzYJdZOI" />

<link rel="shortcut icon" href="media/favico.png" type="image/x-icon" />

<?php include("scripts/engine.php");?>

<link href='layouts/style.css' rel='stylesheet' type='text/css'>
<link href='layouts/dark-hive/jquery-ui-1.8.21.custom.css' rel='stylesheet' type='text/css'  media="all">
<link href='http://fonts.googleapis.com/css?family=Nunito:700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Nova+Square' rel='stylesheet' type='text/css'>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="scripts/jquery-ui-1.8.21.custom.min.js"></script>
<script type="text/javascript" src="scripts/javascripts.js"></script>
<script type="text/javascript" src="scripts/gAnalytics.js"></script>

</head>



<body>
	<?php include ("includes/header.php"); ?>
	<div id="content">
		<?php
		include ("layouts/".$_SESSION['userType'].".php");
		?>	
	</div>
</body>
</html>
	
<!-- TAREFAS ========================

	parametro de numero de historico (esconder 5+ items)
	incluir link foto grande ou galeria (se autorizado)
	inserir padrões header e content
	seleccção de linguas
	icones do lado direito
	esconder - importantes?
	verificar validações mensagem
	captcha para formulario
	curriculos automaticos
	
	> verificar calculo estrelas
	> visibilidade ou/e download items por sector	
	> corrigir data inicio fim secundária	
	> google analytics	
	> mensagem enviada fade: campos para default	
	> reescrever cabeçalho dados e idade
	> url para directorias 
	> skills por estrelas
	> caixa de mensagens
	> favico foto sketch?
	> inserir skype button
	> minimizar padrão fundo
	> investigar designs
	
<img height="64" src="media/qrcode.png" alt="" /><br/>
<a href="http://validator.w3.org/check?uri=http%3A%2F%2Fjhpego.pegonet.com%2F" target="_blank">Validate HTML</a>
-->