<!DOCTYPE html>
<head>
<title>Jorge Pego Online</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link href='http://fonts.googleapis.com/css?family=Nunito:700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Nova+Square' rel='stylesheet' type='text/css'>
 <style>
 body{
 background: url(media/apple_texture_pack_1.png) fixed;
font-family: 'Nova Square', cursive;
color: #FFF;
font-size: 12px;
 }
 
 
 body, html {
 height: 100%;
  margin: 0px;
 padding: 0px;
 }


.title {
display: block;
text-transform: uppercase;
	font: 20px "Nunito";
			color: #0050f8;
			text-indent: 50px;
}

 
.leftCell{
	vertical-align:top;
	width:200px;
	text-align:right;
	color: #CCC;
}

.rightCell{
	vertical-align:top;
	width: 400px;
	padding-left: 5px;

}

#aboutMe{
position: absolute;
top:0px;
}

.spacer > td {
padding-bottom: 15px;
}

#header {
    position:absolute; top:0; left:0; right:0;
    height:20px;
    background-color:#000;
}
#content {

    position:absolute; top:20px; bottom:0px; right:0px; left:250px;
    overflow:auto;
}

#inner {
margin: 0 auto;
width:600px;
background-color: #222;
padding: 20px;
border: 1px solid #555;
}

#professional a {
display: block;
background: url(media/icons.png) no-repeat;
background-position:0px 0px;
height: 31px;
}

#education a {
display: block;
background: url(media/icons.png) no-repeat;
background-position:0px -31px;
height: 31px;
}

#skills a {
display: block;
background: url(media/icons.png) no-repeat;
background-position:0px -186px;
height: 31px;
}


 </style>

 
 <?php
 $string['personal'] = "Dados Pessoais";
	$string['name'] = "Nome ou Apelido";
	$string['address'] = "Morada";
	$string['mobile'] = "Telemovel";
	$string['email'] = "Correio Electrónico";
	$string['nationality'] = "Nacionalidade";
	$string['birth'] = "Data de Nascimento";
	$string['gender'] = "Sexo";
$string['professional'] = "Experiência Profissional"; 
	$string['dates'] = "Datas";
	$string['function'] = "Função ou Cargos Ocupado"; 
	$string['activity'] = "Principais Actividades ou responsabilidades"; 
	$string['employer'] = "Nome ou Morada do empregador"; 
	$string['sector'] = "Tipo de Empresa ou sector"; 
$string['education'] = "Educação e formação"; 
	$string['qualification'] = "Designação da qualificação atribuída"; 
	$string['school'] = "Nome e tipo da organização de ensino"; 
	$string['grade'] = "Nível segundo a classificação nacional ou internacional"; 
$string['skills'] = "Aptidões e competências pessoais"; 
	$string['language'] = "Língua(s) materna(s)"; 
	$string['otherlanguage'] = "Outra(s) língua(s)"; 
	$string['social'] = "Aptidões e competências sociais"; 
	$string['organizational'] = "Aptidões e competências de organização"; 
 	$string['computing'] = "Aptidões e competências informáticas"; 
	$string['driver'] = "Carta de condução"; 
	
	
	 if (file_exists('europassCV.xml')) {
	$curriculo = new SimpleXMLElement('europassCV.xml', null, TRUE);
}
 ?>
</head>
 <body>
 

<div class="rightCell" id="aboutMe" >
<span class="title">
Jorge Pego<br/>
online<br/>
</span>
<img height="100" src="media/jhpego.jpg" alt="Jorge Pego photo"/><br/>
<?php



echo '',$curriculo->personal->name,' ',$curriculo->personal->surname,'<br/>';
echo '',$curriculo->personal->nationality,' <br/>';
echo '',$curriculo->personal->birth,' <br/>';
echo '',$curriculo->personal->mobile,' <br/>';
echo '',$curriculo->personal->web,' <br/>';
echo '',$curriculo->personal->email,' <br/>';
?>

<a href="http://facebook.com/jhpego" target="_blank"><img height="16" src="media/facebook.png" alt="Jorge Pego no Facebook" /> eu no facebook</a><br/>
<a href="#" target="_blank"><img  height="16" src="media/pdf.png" alt="" />Europass CV</a><br/>
<a href="#" target="_blank"><img  height="16" src="media/pdf.png" alt="" />Normal CV</a><br/>

<img height="64" src="media/qrcode.png" alt="" /><br/>
 
<br/><br/>
<a href="http://validator.w3.org/check?uri=http%3A%2F%2Fjhpego.pegonet.com%2F" target="_blank">Validate HTML</a><br/>
investigar designs sites pessoais ou curriculos<br/>
seleccção de linguas<br/>
url parametros para cada empresa ou sector (visibilidade ou/e download)<br/>
skills por estrelas<br/>
facebook  e pdfs na direita?<br/>
expand CV sections hidden class on xml<br/>

</div>
 
	<div id="header">
<a href="index.php#personal">Dados Pessoais</a> | 
<a href="#education">Educação e Formaçao</a> | 
<a href="#professional">Experiência Profissional</a> | 

<a href="#skills">Aptidões e Capacidades</a> | 
<a href="CV_pdf.php">Curriculo PDF</a> | 
<a href="europassCV.php">Europass PDF</a>
</div>



<div id="content">
<div id="inner">
 <?php
 


	


 
 










echo '<table id="education" class="table">';
echo '<tr><td ></td><td class="title"><a>',$string['education'],'</a></td></tr>';
foreach ($curriculo->education->formation as $formation) {	
echo'<tr class="spacer"><td class="leftCell">',$formation['init'],' até ',$formation['end'],'</td><td class="rightCell">',
$formation->qualification,'<br/>',
$formation->school,'<br/>',
$formation->grade,
'</td></tr>';
}
echo '</table>';


echo '<table id="professional" class="table">';
echo '<tr ><td ></td><td class="title professional" ><a >',$string['professional'],'</a></td></tr>';
foreach ($curriculo->professional->job as $job) {	
echo'<tr class="spacer"><td class="leftCell">',$job['init'],' até ',$job['end'],'</td>';
echo '<td class="rightCell">',
$job->position,'<br/>',
$job->employer,' - ',$job->sector,'<br/>',
$job->activity,
'</td></tr>';
}
echo '</table>';





echo '<table id="skills" class="table">';
echo '<tr><td  ></td><td class="title"><a >',$string['skills'],'</ a ></td></tr>';
foreach ($curriculo->skills->item as $item){
	if ((string)$item['type']=='otherlanguage')
		echo '<tr class="spacer"><td class="leftCell">',$string[(string)$item['type']], ':</td><td class="rightCell"> outras</td></tr>';	
	else
		echo '<tr class="spacer"><td class="leftCell">',$string[(string)$item['type']], ':</td><td class="rightCell"> ', $item, '</td></tr>';
}
echo '</table>';






	
	
// echo $movies->movie[1]->plot;

// Accessing elements within an XML document that contain characters not permitted under PHP's naming convention (e.g. the hyphen) can be accomplished by encapsulating the element name within braces and the apostrophe
// echo $movies->movie->{'great-lines'}->line;


//When multiple instances of an element exist as children of a single parent element, normal iteration techniques apply.
// foreach ($movies->movie->characters->character as $character) {
   // echo $character->name, ' played by ', $character->actor, PHP_EOL;
// }


//So far, we have only covered the work of reading element names and their values. SimpleXML can also access element attributes. Access attributes of an element just as you would elements of an array.
// foreach ($movies->movie[0]->rating as $rating) {
    // switch((string) $rating['type']) { // Get attributes as element indices
    // case 'thumbs':
        // echo $rating, ' thumbs up';
        // break;
    // case 'stars':
        // echo $rating, ' stars';
        // break;
    // }
// }


	
	
	
	?>

	
	
	</div>

	</div>
	

	</body>
	</html>
