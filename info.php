<?php 
$url = 'https://my.vodafone.pt/myvdffo/dispatcher?m=true&amp;ps=false';
//$url = 'http://blog.thiagobelem.net/robots.txt';
$fields_string = "userid=916057771&password=comunica&sru=&fru=";
$cookie_file = "cookie.txt";
//open connection
$ch = curl_init();
$headers = get_headers("http://jhpego.pegonet.com");
//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL,$url);
//curl_setopt($ch,CURLOPT_POST,count($fields));
curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
curl_setopt($ch, CURLOPT_AUTOREFERER, 1); 
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers );

//execute post
$result = curl_exec($ch);

//close connection
curl_close($ch);
echo $result;
?>