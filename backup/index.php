
<?php
//header('Content-Type: application/vnd.hbbtv.xhtml+xml; charset=utf-8');
header('Access-Control-Allow-Origin: *');
echo ('<?xml version="1.0" encoding="utf-8" ?>');
date_default_timezone_set('Europe/Athens');
$user_id = (isset($_COOKIE['userid']) ? $_COOKIE['userid'] : 0);
$action = (isset($_GET['action']) ? $_GET['action'] : null);
$username = '';

if ($user_id) {
	if (isset($action) && $action == 'logout') {
		setcookie('userid', '', time()-3600);
		setcookie('userid', '', time()-3600, "/");
		header('location: index.php');
		exit;
	}

	$user = json_decode(file_get_contents('http://mega.smart-tv-data.com/dev/users.php?action=get-user&user_id='. $user_id), true);
	if ($user['success'])
		$username = $user['username'];
	else {
		setcookie('userid', '', time()-3600);
		setcookie('userid', '', time()-3600, "/");
		header('location: index.php');
		exit;
	}
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script type="text/javascript" src="js/form.js?<?php echo rand()?>"></script>
  <link rel="stylesheet" href="css/form.css?<?php echo rand()?>" />
</head>
<body>

  <div id="logo">
    <img src="img/logo2.png" />

  </div>  

  <div class="outerform">
<?php
die('<center><h2>Under construction</h2></center></div></body></html>');
if ($user_id) {
	echo '<div class="container">';
	echo '<div class="inner">';
	echo '<p>Έχετε συνδεθεί ως <a href="?action=edit"><b>'. $username .'</b></a></p>';
	echo '<div class="links"><a href="?action=edit">Αλλαγή στοιχείων</a><br><br><a href="login-tv.php">Είσοδος στην τηλεόραση</a> - <a href="?action=logout">Αποσύνδεση</a></div>';
	if ($action == 'edit') {
		$a = explode('-', $user['birthday']);
		$day = $a[2];
		$mon = (int)$a[1];
		$year = $a[0];
?>
    <div class="container">
      
      <div class="inner">
        <div id="msg-info"></div>
        <h2>Αλλαγή στοιχείων</h2>
        
        <div class="form-inputs">

<div>
	<a href="javascript:void(0)" onclick="showPass(this)">Αλλαγή κωδικού</a>
	<div id="new-pass" style="display: none;">
          <label for="psw"><b>Παλιός Κωδικός</b></label>
          <input type="password" placeholder="Δώσε παλιό κωδικό πρόσβασης" name="old-pass" id="old-pass" required>

          <label for="psw"><b>Κωδικός</b></label>
          <input type="password" placeholder="Δώσε κωδικό πρόσβασης" name="psw" id="psw" required>
          <span style="font-size:10px">Ο κωδικός χρήστη πρέπει να περιέχει τουλάχιστον 8 χαρακτήρες.</span>
	<br/>
	<br/>
	</div>
</div>
<br>

          <label for="day"><b>Ημ/νία Γέννησης</b></label>
	<br/>
	<input type="text" style="width: 4em;" placeholder="ΗΗ" name="day" id="day" value="<?php echo $day?>" required>
<select name="month" id="month" >
<?php
setlocale(LC_TIME, 'el_GR.UTF-8'); // set the language to Greek
for ($i = 1; $i <= 12; $i++) {
	$timestamp = mktime(0, 0, 0, $i, 1, 2000); // set the timestamp to the first day of the month
	$name = strftime('%B', $timestamp); // format the month name in Greek
	echo "<option value=\"$i\"". ($mon == $i ? "selected=\"selected\"":"") .">$name</option>\n";
}
?>
</select>
          <input type="text" style="width: 8em;" placeholder="ΕΕΕΕ" name="year" id="year" value="<?php echo $year?>" required>

<br/>
          <label for="gender"><b>Φύλο</b></label>
	<select style="width: 40%" name="gender" id="gender" >
<?php
$genders = ['F' => 'Γυναίκα', 'M'=> 'Άνδρας', 'O'=>'Άλλο'];
foreach ($genders as $k=>$v)
	echo "<option ". ($user['gender'] == $k ? "selected=\"selected\"":"") ." value='$k'>$v</option>";
?>
	</select>

          <br/>
          <br/>
          <br/>
          
        </div>
        
      </div>
	<input type="hidden" id="uid" value="<?php echo $user_id;?>">
      <button type="" onclick="edit();" class="registerbtn">Αποθήκευση</button>
	<button class="registerbtn" style="float: none; margin-left: 10px;" id="back" type="" onclick="location.href='index.php';">Επιστροφή</button>
    </div>
<?php
	}
	echo '</div>';
	echo '</div>';
} else {
?>

    <div class="signin">
      <p>Έχεις ήδη λογαριασμό? <a href="login.php">Είσοδος</a>.</p>
    </div>

    <div class="container">
      
      <div class="inner">
        <div id="msg-info"></div>
        <h2>Εγγραφή</h2>
        <p>Παρακαλώ συμπληρώστε τα στοιχεία για να εγγραφείτε ως νέος χρήστης.</p>
        
        <div class="form-inputs">
          <label for="email"><b>Email</b></label>
          <input type="text" placeholder="Δώσε το email σου" name="email" id="email" required>

          <label for="psw"><b>Κωδικός</b></label>
          <input type="password" placeholder="Δώσε κωδικό πρόσβασης" name="psw" id="psw" required>
          <span style="font-size:10px">Ο κωδικός χρήστη πρέπει να περιέχει τουλάχιστον 8 χαρακτήρες.</span>
	<br/>
	<br/>

          <label for="day"><b>Ημ/νία Γέννησης</b></label>
	<br/>
          <input type="text" style="width: 4em;" placeholder="ΗΗ" name="day" id="day" required>
<select name="month" id="month" >
<?php
setlocale(LC_TIME, 'el_GR.UTF-8'); // set the language to Greek
for ($i = 1; $i <= 12; $i++) {
	$timestamp = mktime(0, 0, 0, $i, 1, 2000); // set the timestamp to the first day of the month
	$name = strftime('%B', $timestamp); // format the month name in Greek
	echo "<option value=\"$i\">$name</option>\n";
}
?>
</select>
          <input type="text" style="width: 8em;" placeholder="ΕΕΕΕ" name="year" id="year" required>

<br/>
          <label for="gender"><b>Φύλο</b></label>
	<select style="width: 40%" name="gender" id="gender" >
	<option value='F'>Γυναίκα</option>
	<option value='M'>Άνδρας</option>
	<option value='O'>Άλλο</option>
	</select>

          <br/>
          <br/>
          <br/>
          <!--label for="psw-repeat"><b>Επανάληψη κωδικού</b></label>
          <input type="password" placeholder="Repeat Password" name="psw-repeat" id="psw-repeat" required-->
          
          <label>
            <input type="checkbox" checked="checked" name="iagree" id="iagree" required> Συμφωνώ με τους όρους χρήσης.
          </label>
          
        </div>
        
      </div>
      <button type="" onclick="signup();" class="registerbtn">Εγγραφή</button>

    </div>
<?php } ?>
  </div>

</body>
</html>
