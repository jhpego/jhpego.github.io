<?php
if(isset($_POST['email'])) {
     
    // EDIT THE 2 LINES BELOW AS REQUIRED
    $email_to = "jhpego@gmail.com";
    $email_subject = "Resposta Curriculo";
     
    $name = $_POST['name']; // required
    $email = $_POST['email']; // required
    $msg = $_POST['msg']; // required    
	$referer = $_POST['referer'];
	
	$error=array();
	$valid=true;
	
	
     
    // validation expected data exists
    if(!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['msg'])) {
		array_push($error,"algum campo não está preenchido");      
    }
     
	if(!preg_match("/^[A-Za-záàãâéèêíìîóòõôúùûçÁÀÃÂÉÈÊÍÌÎÓÒÕÔÚÙÛ ]+$/",$name)) {
		array_push($error,"o campo nome não está valido");  
	}
	 
	if(!preg_match("/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/",$email)) {
		array_push($error,"o campo email não está valido");  
	}
     
	if(!preg_match("/^[A-Za-z0-9áàãâéèêíìîóòõôúùûçÁÀÃÂÉÈÊÍÌÎÓÒÕÔÚÙÛ \-\.\?!]+$/",$msg)) {
		array_push($error,"a mensagem não é valida");  
	}


  if(strlen($msg) < 2) {
    	array_push($error,"o campo mensagem é curto demais");  
  }


     
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
     
	$email_message = "Form details below.\n\n"; 
	$email_message .= "Referer: ".clean_string($referer)."\n";
    $email_message .= "Nome: ".clean_string($name)."\n";
    $email_message .= "Email: ".clean_string($email)."\n";
    $email_message .= "Mensagem: ".clean_string($msg)."\n";
	
     
     
// create email headers
$headers = 'From: '.$email."\r\n".
'Reply-To: '.$email."\r\n" .
'X-Mailer: PHP/' . phpversion();
if (count($error)==0){
	@mail($email_to, $email_subject, $email_message, $headers); 
}
    echo json_encode($error);

}
?>