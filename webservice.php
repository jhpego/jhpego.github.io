<?php
header('Content-Type: application/json');
include("sources.php");


$clientVersion = isset($_REQUEST['version']) ? $_REQUEST['version'] : "9999999999";
$clientPassHash = isset($_REQUEST['hash']) ? $_REQUEST['hash'] : "";
$clientUser= isset($_REQUEST['user']) ? $_REQUEST['user'] : "jhpego";

$credentials = simplexml_load_file($clientUser.'.xml');
$version = (string) $credentials->metadata['version'];
$passHash = (string) $credentials->metadata['passHash'];

if ($passHash!=$clientPassHash) {
	echo "NO_AUTH";
}else {
	if ($version<=$clientVersion) {
		echo "OLD_VERSION";	
	} else {
		$data=array();
		foreach ($credentials->data->credential as $credential) {
			$item = array(
			    'title' => (string) $credential['title'],
			    'web' => (string) $credential['web'],
			    'user' => (string) $credential['user'],
			    'password' => $mcrypt->encrypt(trim($credential))
			);
			array_push($data, $item); 
		}
		
		$post_data = array( "version"=>$version, "credentials" => $data); 
		$post_data = json_encode($post_data );
		echo $post_data ;	
	}
}
?>