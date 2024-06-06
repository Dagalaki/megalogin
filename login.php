<?php
//header('Content-Type: application/vnd.hbbtv.xhtml+xml; charset=utf-8');
header('Access-Control-Allow-Origin: *');
echo ('<?xml version="1.0" encoding="utf-8" ?>');
date_default_timezone_set('Europe/Athens');

function cryptoJs_aes_encrypt($data, $key)
{

    $salted = "Salted__";
    $salt = openssl_random_pseudo_bytes(8);

    $keyAndIV = aes_evpKDF($key, $salt);
    $encrypt  = openssl_encrypt(
        $data,
        "aes-256-cbc",
        $keyAndIV["key"],
        OPENSSL_RAW_DATA, // base64 was already decoded
        $keyAndIV["iv"]
    );
    return  base64_encode($salted . $salt . $encrypt);
}

function aes_evpKDF($password, $salt, $keySize = 8, $ivSize = 4, $iterations = 1, $hashAlgorithm = "md5")
{
    $targetKeySize = $keySize + $ivSize;
    $derivedBytes = "";
    $numberOfDerivedWords = 0;
    $block = NULL;
    $hasher = hash_init($hashAlgorithm);
    while ($numberOfDerivedWords < $targetKeySize) {
        if ($block != NULL) {
            hash_update($hasher, $block);
        }
        hash_update($hasher, $password);
        hash_update($hasher, $salt);
        $block = hash_final($hasher, TRUE);
        $hasher = hash_init($hashAlgorithm);

        // Iterations
        for ($i = 1; $i < $iterations; $i++) {
            hash_update($hasher, $block);
            $block = hash_final($hasher, TRUE);
            $hasher = hash_init($hashAlgorithm);
        }

        $derivedBytes .= substr($block, 0, min(strlen($block), ($targetKeySize - $numberOfDerivedWords) * 4));

        $numberOfDerivedWords += strlen($block) / 4;
    }
    return array(
        "key" => substr($derivedBytes, 0, $keySize * 4),
        "iv"  => substr($derivedBytes, $keySize * 4, $ivSize * 4)
    );
}


$msg = '';
if (isset($_GET['fremoval']))
	$msg = 'Ο λογαριασμός σας διαγράφηκε με επιτυχία';
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no, viewport-fit=cover">
<script type="text/javascript" src="js/form.js?<?php echo rand()?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js" integrity="sha256-/H4YS+7aYb9kJ5OKhFYPUjSJdrtV6AeyJOtTkw6X72o=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="css/login.css?<?php echo rand()?>" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
</head>
<body>


<div class="outerform">
<!--form action="action_page.php" method="post"-->
  <div class="imgcontainer logo">
    <img src="img/logo.png" alt="Avatar" class="avatar">
  </div>

  <div class="container">
  <div id="msg-info"><?php echo $msg?></div>
    <h1>Είσοδος</h1>
    <label for="uname"><b>Όνομα Χρήστη</b></label>
    <input type="text" placeholder="Δώσε όνομα χρήστη" name="uname" id="uname" required>

    <label for="psw"><b>Κωδικός</b></label>
    <input type="password" placeholder="Δώσε κωδικό πρόσβασης" name="psw" id="psw" required>
	<span>
		<i class="fa fa-eye" aria-hidden="true" id="togglePassword"></i>
	</span>
    <label class="atag" onclick="resetPassword()">Αν ξεχάσατε τον κωδικό πρόσβασης πατήστε εδώ.</label>

    
    <!--span class="psw">Ξέχασες <a href="#">τον κωδικό?</a></span-->
  </div>

<button type="" onclick="login();">Είσοδος</button>
  
<!--/form-->
</div>

</body>
</html>
