<?php
$user_id = (isset($_COOKIE['userid']) ? $_COOKIE['userid'] : 0);

if (!$user_id) {
	header('location: index.php');
	exit;
}

header('Access-Control-Allow-Origin: *');
echo ('<?xml version="1.0" encoding="utf-8" ?>');
date_default_timezone_set('Europe/Athens');

if (isset($action) && $action == 'logout') {
	setcookie('userid', '', time()-3600);
	setcookie('userid', '', time()-3600, "/");
	header('location: index.php');
	exit;
}

$res = json_decode(file_get_contents('http://mega.smart-tv-data.com/dev/users.php?action=get-user&user_id='. $user_id), true);
if ($res['success'])
	$username = $res['username'];
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Σύνδεση στην TV - Mega Play</title>
<script type="text/javascript" src="js/form.js?<?php echo rand()?>"></script>
<link rel="stylesheet" href="css/login.css?<?php echo rand()?>" />
</head>
<body>


<div class="outerform">
<!--form action="action_page.php" method="post"-->
  <div class="imgcontainer logo">
    <img src="img/logo.png" alt="Avatar" class="avatar">
  </div>

  <div class="container">
  <div class="code-inner">
    <div id="msg-info"></div>
    <h1>Σύνδεση στην TV</h1>
<p>
Ανοίξτε την εφαρμογή στην TV και επιλέξτε σύνδεση με κωδικό. Εισάγετε τον κωδικό που εμφανίζεται παρακάτω για να συνδεθείτε στην τηλεόρασή σας.
</p>
<?php
for ($i = 0; $i < 6; $i++) {
	echo '<input data-i="'. $i .'" id="code-'. $i .'" type="text" class="codelogin" inputmode="numeric" maxlength="1" value="">';
}
?>
	<input type="hidden" id="uid" value="<?php echo $user_id;?>">
	<input type="hidden" id="action" value="codelogin">
  </div>
  </div>

<div style="text-align: center;">
	<button style="float: none;" id="do-login" type="" onclick="codelogin();">Είσοδος</button>

	<button style="float: none; margin-left: 10px;" id="back" type="" onclick="location.href='index.php';">Επιστροφή</button>
</div>
  
<!--/form-->
</div>

</body>
</html>
