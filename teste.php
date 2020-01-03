<?php

$clientData = isset($_REQUEST['data']) ? $_REQUEST['data'] : '{"new":[],"updated":[],"deleted":[]}';
$getJSON = '{
	"new":[
	{"title":"title4", "web":"web8", "username":"user8", "password":"password4", "lastUpd":245},
	{"title":"title5", "web":"web9", "username":"user9", "password":"password5", "lastUpd":246},
	{"title":"title6", "web":"web10", "username":"user10", "password":"password6", "lastUpd":247}	
	],
	"updated":[
	{"id":18, "title":"titleNew4", "web":"webNew8", "username":"userNew8", "password":"passwordNew4", "lastUpd":22}
	],
	"deleted":[
	{"id":25,"lastUpd":25},
	{"id":28,"lastUpd":23}
	]
}';

$getJSON2 = '{
	"data":[
	{"action":"new", "title":"title4", "web":"web8", "username":"user8", "password":"password4", "lastUpd":245},
	{"action":"new", "title":"title5", "web":"web9", "username":"user9", "password":"password5", "lastUpd":246},
	{"action":"new", "title":"title6", "web":"web10", "username":"user10", "password":"password6", "lastUpd":247},
	{"action":"upd", "id":18, "title":"titleNew4", "web":"webNew8", "username":"userNew8", "password":"passwordNew4", "lastUpd":22},
	{"action":"del", "id":25,"lastUpd":25},
	{"action":"del", "id":28,"lastUpd":23}
	]
	}';


function connectDB(){
	$dsn = 'mysql:host=localhost;dbname=pegonet_db';
	$user = 'pegonet_admin';
	$password = 'securen3t';
	try {
	    $conn = new PDO($dsn, $user, $password);
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
	    echo $e->getMessage();
	}
	return $conn;
}

function removeModified{

}



$clientVersion = isset($_REQUEST['version']) ? intval ($_REQUEST['version']) : 99999999999999;
$clientHash = isset($_REQUEST['hash']) ? $_REQUEST['hash'] : "";
$clientUser= isset($_REQUEST['user']) ? $_REQUEST['user'] : "";

$credentialsTbl = "mSegredo_credentials";
$usersTbl = "mSegredo_Users";
$updVersion = false;


/*
0 - DEFAULT
100 - OK
200 - NO_AUTH
300 - UPDATED
*/

$phpData = json_decode($getJSON);
$returnInfo = array("msg"=>0); // valor Defeito

$conn = connectDB();
$conn->beginTransaction();
try {


	$stmt = $conn->prepare('Select id, lastUpd from '.$usersTbl.' where username=:user and hash=:hash');
	$stmt->bindValue(':user', $clientUser);
	$stmt->bindValue(':hash', $clientHash);       
	$stmt->execute();
	if ($stmt->rowCount()<1) { 
		$returnInfo["msg"] = 200;   //NO_AUTH login incorrecto       
	} else {
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$userID = $row["id"];
		if ($clientVersion >= intval ($row["lastUpd"])){
			$returnInfo["msg"] = 300; //UPDATED não precisa de atualizacao

		} else {
			$returnInfo["msg"] = 100; //OK efetuar atualizacao
			$data = array(
				"success"=> array("new"=>array(), "updated"=>array(), "deleted"=>array() ), 
				"error"=>array("new"=>array(), "updated"=>array(), "deleted"=>array() ) 
				);

// Obter registos modificados desde a ultima atualizacao
$serverNew= array();
$query = 'Select * from '.$credentialsTbl.' WHERE created>:lastUpd AND deleted=null ';
$stmt = $conn->prepare($query);     
$stmt->bindValue(':lastUpd', $clientVersion);
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	array_push($serverNew,$row);
}
$returnInfo["serverNew"] = $serverNew;

$serverModified= array();
$query = 'Select * from '.$credentialsTbl.' WHERE modified>:lastUpd AND deleted=null ';
$stmt = $conn->prepare($query);     
$stmt->bindValue(':lastUpd', $clientVersion);
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	array_push($serverModified ,$row);
}
$returnInfo["serverNew"] = $serverModified;

$serverDeleted= array();
$query = 'Select * from '.$credentialsTbl.' WHERE deleted>:lastUpd ';
$stmt = $conn->prepare($query);     
$stmt->bindValue(':lastUpd', $clientVersion);
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	array_push($serverDeleted ,$row);
}
$returnInfo["serverNew"] = $serverDeleted;



$clientNew = array();
foreach ($phpData->new as $credential) {
	$stmt = $conn->prepare('INSERT INTO '.$credentialsTbl.' (title, web, username, password, lastUpd) VALUES (:title, :web, :username, :password, :lastUpd)');
	$stmt->bindValue(':title', $credential->title);
	$stmt->bindValue(':web', $credential->web);
	$stmt->bindValue(':username', $credential->username);
	$stmt->bindValue(':password', $credential->password);
	$stmt->bindValue(':lastUpd', $credential->lastUpd);            
	$stmt->execute();
	if ($stmt->rowCount()>0) { //build ok/error List
		array_push($clientNew ,(int)$conn->lastInsertId()); 
		$updVersion = true;         
	} else {
		array_push($data["error"]["new"],(int)$conn->lastInsertId());
	}
}



foreach ($phpData->updated as $credential) {
	$query = 'UPDATE '.$credentialsTbl.' SET title=:title, web=:web, username=:username, password=:password, lastUpd=:lastUpd WHERE id = :id and lastUpd < :lastUpd';
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':id', $credential->id);       
        $stmt->bindValue(':lastUpd', $credential->lastUpd);
        $stmt->bindValue(':title', $credential->title);
        $stmt->bindValue(':web', $credential->web);
        $stmt->bindValue(':username', $credential->username);
        $stmt->bindValue(':password', $credential->password);
        $stmt->bindValue(':lastUpd', $credential->lastUpd);   
        $stmt->execute();
        if ($stmt->rowCount()>0) { //build ok/error List
        	array_push($data["success"]["updated"],$credential->id);
        	$updVersion = true;            
        } else {
		array_push($data["error"]["updated"],$credential->id);
        }
 }


foreach ($phpData->deleted as $credential) {
	$stmt = $conn->prepare('DELETE from '.$credentialsTbl.' WHERE id = :id and lastUpd < :lastUpd');
	$stmt->bindValue(':id', $credential->id);       
	$stmt->bindValue(':lastUpd', $credential->lastUpd);      
	$stmt->execute(); 
	if ($stmt->rowCount()>0) { //build ok/error List
		array_push($data["success"]["deleted"],$credential->id);
		$updVersion = true;          
	} else {
		array_push($data["error"]["deleted"],$credential->id);
	}
}


 

 
	 if ($updVersion) {
		$newVersion = number_format(round(microtime(true)*1000),0,"","");
	 	$stmt = $conn->prepare('UPDATE '.$usersTbl.' SET lastUpd=:lastUpd WHERE id=:id');
		$stmt->bindValue(':id', $userID);   
		$stmt->bindValue(':lastUpd',  $newVersion ); 
		$stmt->execute();
		if ($stmt->rowCount()>0) { 
			$returnInfo["lastUpd"] = $newVersion;        
		}
 	}
	
	if ( count($data["success"]["new"]) >0 || count($data["success"]["updated"]) >0 || count($data["success"]["deleted"]) >0 ||
		count($data["error"]["new"]) >0 || count($data["error"]["updated"]) >0 || count($data["error"]["deleted"]) >0) {
 		$returnInfo["data"] = $data;
 	}
 		






 
 }
 }

$conn->commit();
} catch(Exception $e) {
	echo $e->getMessage();
	$conn->rollback();
}
	

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
?>

<pre><?php 
//echo $ip."\n";
//print_r($returnInfo);
$returnInfo = json_encode($returnInfo);
$returnInfo = json_decode($returnInfo);
print_r($returnInfo);

?></pre>