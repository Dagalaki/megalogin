<?php
	if(!isset($_GET['c']) || $_GET['c'] == ""){
		header("location: ./index.php",  true,  301 );
		exit();
	}
	define('USERHASH', "f#h351!gc");

	$urldecoded = urldecode($_GET['c']);
	$dec = base64_decode($urldecoded);
	$dec_arr = explode(",", $dec);
	print_r($dec_arr);


	if($dec_arr[2] == USERHASH){
		setcookie('email', $dec_arr[0], time()+3600);
		//setcookie('userid', $dec_arr[1], time()+3600);
		setcookie('tvcode', $dec_arr[2], time()+3600);
		header("location: ./index.php",  true,  301 );
		exit();
	} else die('Failed');

?>
