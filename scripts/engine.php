<?php
function init()  {
	global $cv; global $referals; global $string; 
	$cv = json_decode( file_get_contents('includes/curriculum.json'));
	$referals = json_decode(file_get_contents("includes/referals.json"));	
	$referal = $_GET['referal'];

	if (isset($referals->{$referal})){
		$_SESSION['referal']= $referal;
		$_SESSION['userType']= $referals->{$referal}[0];
		$_SESSION['lang']= $referals->{$referal}[1];
		$_SESSION['access']= $referals->{$referal}[2];
		$_SESSION['presentation']= $referals->{$referal}[3];
	} else {
		$_SESSION['referal']= "";
		$_SESSION['userType']= "default";
		$_SESSION['lang']= "PT";
		$_SESSION['access']= 0;
		$_SESSION['presentation']= "";
	}
	include("includes/stringsPT.php");
}


function age($birthDate){
          $birthDate = explode("-", $birthDate);
          $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[2], $birthDate[0]))) > date("md") ? ((date("Y")-$birthDate[0])-1):(date("Y")-$birthDate[2]));
		  return $age;
}
	
	
function writeIf($text, $access, $elseText=""){
if ($_SESSION['access']>=$access)
	echo($text);
else
echo ($elseText);
}


function profile($exclusive=false) {
	global $cv, $string;
	echo 
		'<div id ="perfil_" class="ancora"></div>
		<div id ="perfil" >
		<h1 class="title"><a>'.$string['perfil'].'</a></h1>'
		.$_SESSION['presentation'];
		if (!$exclusive) echo $cv->profile;
		echo '</div>';
}


function education($limit=0, $entries=NULL) {
	global $cv, $string;
	$counter =1; $i=0;

	echo '
		<div id ="education_" class="ancora"></div>
		<div id="education" >
		<h1 class="title"><a >'.$string['education'].'</a></h1>
			<table >';
	foreach ($cv->education as $index=>$formation) {	
		echo '<tr class="spacer ';
		if (($limit!=0 && $counter>$limit)||($entries!=NULL && $entries[$i]==$index)) {
			echo 'hidden';
			if (count($entries)<$i) $i++;
		}
		else 
			$counter++;
		echo '
			"><td class="leftCell">',$formation->init,' até ',$formation->end,'</td><td class="rightCell">'.
			$formation->qualification.'<br/>'.
			$formation->school.'<br/>'.
			$formation->grade.
			'</td></tr>';
	}
	if (count($cv->education)>$limit && $limit!=0)
		echo '<tr><td class="leftCell"></td><td class="rightCell">
		<a class="showBT" href="javascript:void(0)">Ver +</a></td></tr>';
	echo '</table></div>';
}


function professional($limit=0, $entries=NULL) {
	global $cv, $string;
	$counter =1; $i=0;
	
	
	
	echo 
		'<div id ="professional_" class="ancora"></div>
		<div id="professional">
		<h1 class="title"><a >'.$string['professional'].'</a></h1>
			<table>';
	foreach ($cv->professional as $index=>$job) {	
			echo'<tr class="spacer ';
			
			
		if (($limit!=0 && $counter>$limit)||($entries!=NULL && $entries[$i]==$index)) {
			echo 'hidden';
			if (count($entries)<$i) $i++;
		}
		else 
			$counter++;
			
			
			
			echo '"><td class="leftCell">'.$job->init.' até '.$job->end.'</td>
			<td class="rightCell">',
			$job->position,'<br/>',
			$job->employer.' - '.$job->sector.'<br/>',
			$job->activity.
			'</td></tr>';
	}

	
	if (count($cv->professional)>$limit && $limit!=0)
		echo '<tr><td class="leftCell"></td><td class="rightCell">
		<a class="showBT" href="javascript:void(0)">Ver +</a></td></tr>'; 
	echo '</table></div>';
}


function skills() {
	global $cv, $string;
	echo
	'<div id ="skills_" class="ancora"></div>
	<div id="skills">
	<h1 class="title"><a >'.$string['skills'].'</a></h1>
	<table>
		<tr class="spacer">
			<td class="leftCell">'.$string['language'].':</td>
			<td class="rightCell">'.$cv->skills->language.'</td>
		</tr>
		<tr class="spacer">
			<td class="leftCell">'.$string['otherlanguage'].':</td>
			<td class="rightCell">';
	foreach ($cv->skills->otherLanguage as $languages){
		echo $languages->language,' ';
		$media = ceil(($languages->knowOral + $languages->knowRead + $languages->speakInteraction + $languages->speakProduction + $languages->write)/5/20);
		for ($i=0 ; $i<$media; $i++)
			echo '&#9733;';
		echo '<br/>';
	}
	echo '</td></tr>';
	echo 
		'<tr class="spacer">
			<td class="leftCell">'.$string['social'].':</td>
			<td class="rightCell">'.$cv->skills->social.'</td>
		</tr>
		<tr class="spacer">
			<td class="leftCell">'.$string['organizational'].':</td>
			<td class="rightCell">'.$cv->skills->organizational.'</td> 
		</tr>
		<tr class="spacer">
			<td class="leftCell">'.$string['computing'].':</td>
			<td class="rightCell">';
	foreach ($cv->skills->computing as $computing){
		echo  $computing->skill,' ';
		for ($i=0 ; $i<ceil($computing->level/20); $i++)
			echo '&#9733;';
		echo '<br/>';
	}
	echo '</td></tr>';	
	echo
		'<tr class="spacer">
			<td class="leftCell">'.$string['driver'].':</td>
			<td class="rightCell">'.$cv->skills->driver.'</td>
		</tr>	
		</table>
		</div>';
}


function contacts() {
	global $cv, $string;
	echo
		'<div id ="contacts_" class="ancora"></div>
		<div id="contacts" >
		<h1 class="title"><a>'.$string['contacts'].'</a></h1>
		<div style="float: right;text-align:right;">	
			<script type="text/javascript" src="http://download.skype.com/share/skypebuttons/js/skypeCheck.js"></script>
			<a href="skype:jhpego?call"><img src="http://mystatus.skype.com/smallclassic/jhpego" style="border: none;"  alt="My status" /></a>
		<div id="statusMsg" style="color:red; width:200px;text-align:left;"></div>
		</div>
		<form id="contactMe" method="post" >
			<input  type="hidden" id="referer" name="referer" value="<?php echo $referer ?>">
			<input  type="text" id="name" name="name" value="Nome">
			<input  type="text" id="email" name="email" value="Email">
			<textarea  id="msg" name="msg">Digite a sua Mensagem...</textarea>
			<input type="button" id="enviar" name="enviar" value="Enviar">
		</form>
		</div>';
}
function dialog() {
	global $string;
	echo
		'<div id="dialogBox" title="Acesso Proibido">
		Envie mensagem para solicitar um acesso
		</div>';
}


	
init();
?>