<?php
header('Content-Type: application/json');
class MCrypt
{
    private $iv = 'fedcba9876543210'; #Same as in JAVA
    private $key = '0123456789abcdef'; #Same as in JAVA


    function __construct()
    {
    }

    /**
     * @param string $str
     * @param bool $isBinary whether to encrypt as binary or not. Default is: false
     * @return string Encrypted data
     */
    function encrypt($str, $isBinary = false)
    {
        $iv = $this->iv;
        $str = $isBinary ? $str : utf8_decode($str);

        $td = mcrypt_module_open('rijndael-128', ' ', 'cbc', $iv);

        mcrypt_generic_init($td, $this->key, $iv);
        $encrypted = mcrypt_generic($td, $str);

        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);

        return $isBinary ? $encrypted : bin2hex($encrypted);
    }

    /**
     * @param string $code
     * @param bool $isBinary whether to decrypt as binary or not. Default is: false
     * @return string Decrypted data
     */
    function decrypt($code, $isBinary = false)
    {
        $code = $isBinary ? $code : $this->hex2bin($code);
        $iv = $this->iv;

        $td = mcrypt_module_open('rijndael-128', ' ', 'cbc', $iv);

        mcrypt_generic_init($td, $this->key, $iv);
        $decrypted = mdecrypt_generic($td, $code);

        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);

        return $isBinary ? trim($decrypted) : utf8_encode(trim($decrypted));
    }

    protected function hex2bin($hexdata)
    {
        $bindata = '';

        for ($i = 0; $i < strlen($hexdata); $i += 2) {
            $bindata .= chr(hexdec(substr($hexdata, $i, 2)));
        }

        return $bindata;
    }

}


$mcrypt = new MCrypt();

/* Encrypt */

$encrypted = $mcrypt->encrypt("Text to encrypt");

/* Decrypt */

//$decrypted = $mcrypt->decrypt($encrypted);


$credentials = simplexml_load_file('jhpego.xml');
$post_data=array();

foreach ($credentials->credential as $credential) {
	$item = array(
	    'web' => (string) $credential['web'],
	    'user' => (string) $credential['user'],
	    'password' => $mcrypt->encrypt(trim($credential))
	);
	array_push($post_data, $item); 
}
$post_data = array("version"=>1410619999, "credentials" => $post_data); 
$post_data = json_encode($post_data);








echo $post_data;
?>