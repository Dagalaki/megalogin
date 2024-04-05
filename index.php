<?php
//header('Content-Type: application/vnd.hbbtv.xhtml+xml; charset=utf-8');
header('Access-Control-Allow-Origin: *');
echo ('<?xml version="1.0" encoding="utf-8" ?>');
date_default_timezone_set('Europe/Athens');
$user_id = (isset($_COOKIE['userid']) ? $_COOKIE['userid'] : 0);
$tvcode = (isset($_COOKIE['tvcode']) ? $_COOKIE['tvcode'] : 0);

$user_email = (isset($_COOKIE['email']) ? $_COOKIE['email'] : "");
$action = (isset($_GET['action']) ? $_GET['action'] : null);
$msg = (isset($_GET['msg']) ? $_GET["msg"] : null);
$username = '';

if ($user_id) {
	if (isset($action) && $action == 'logout') {
		setcookie('userid', '', time()-3600);
		setcookie('userid', '', time()-3600, "/");
		header('location: login.php'. (isset($_GET['fremoval']) ? '?fremoval=1':''));
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
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,shrink-to-fit=no, viewport-fit=cover">
	<script type="text/javascript" src="js/form.js?<?php echo rand()?>"></script>
	<link rel="stylesheet" href="css/form.css?<?php echo rand()?>" />
	<link href=" https://cdn.jsdelivr.net/npm/air-datepicker@3.4.0/air-datepicker.min.css " rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
	<script src=" https://cdn.jsdelivr.net/npm/air-datepicker@3.4.0/air-datepicker.min.js "></script>
<style>
.content-wrap {
	color: #fff;
	font-size: 18px;
	line-height: 1.5;
	max-width: 700px;
	margin: 0 auto;
	padding: 0 15px;
}
	</style>
<script>
function popup(mylink, windowname) {
	if (! window.focus)return true;
	var href;
	if (typeof(mylink) == 'string') href=mylink;
	else href=mylink.href;
	window.open(href, windowname, 'width=780,height=580,scrollbars=yes');
	return false;
}
</script>
</head>
<body>
	<header >
		<a class="logo" href = "https://www.megatv.com/">
			<img src="img/logo2.png" />
		</a>
		<!--a class="signin" href="login.php">Είσοδος</a-->
		<div class="links"><div><a href="login-tv.php">ΕΙΣΟΔΟΣ ΣΤΗΝ ΤΗΛΕΟΡΑΣΗ</a></div><div><a class="active" href="?action=edit">Ο ΛΟΓΑΡΙΑΣΜΟΣ ΜΟΥ</a></div>
		<div>
			
      <svg id="more-options" xmlns="http://www.w3.org/2000/svg" width="25" height="7" viewBox="0 0 25 7">
        <circle id="circle1" data-name="Ellipse 23" cx="3.5" cy="3.5" r="3.5" fill="#fff"></circle>
        <circle id="circle2" data-name="Ellipse 24" cx="3.5" cy="3.5" r="3.5" transform="translate(9)" fill="#fff"></circle>
        <circle id="circle3" data-name="Ellipse 25" cx="3.5" cy="3.5" r="3.5" transform="translate(18)" fill="#fff"></circle>
      </svg>
    	<div id="submenu" style="display: none">
    		
	    <div class="wrap-cols">
	    <div class="cols">
	      <div>
						
							<button id="parent-control-btn" class="a-btn" type="" onclick="handleOptionPress(this, this.id);" class="btn ">Διαχείριση Γονικού Ελέγχου</button>
						</div>
						
						<div><button id="change-pass-btn"  class="a-btn" type="" onclick="handleOptionPress(this, this.id);" class="btn ">Αλλαγή κωδικού</button></div>
						<div><button id="delete-user-btn"  class="a-btn" type="" onclick="handleOptionPress(this, this.id);" class="btn ">Διαγραφή λογαριασμού</button>
						</div>
						<div class="last">
							<button id="disconnect-user-btn"  class="a-btn"  onclick="handleOptionPress(this, this.id);" class="btn ">Αποσύνδεση</button>
							
						</div>
	    </div>
	    </div>
    
    	</div>
		</div>
	</div>

	</header>

	<div class="outerform">
		<?php
		if (isset($action) && $action == 'legal') {
			include('terms.php');
		} else if (isset($action) && $action == 'del-user') {
?>
			<div class="container">
				<div class="step stepEdit active">
					<h2>Διαγραφή λογαριασμού</h2>
					<div class="">
							<ul class="simpleForm">
								<li data-uia="field-password+wrapper" class="nfFormSpace">
			<form id="del-form" action="" method="post">
				<div class="simpleForm">
					<div >
						<input type="password" style="color:black;" autocomplete="password" iconaspectratio="1:1" placeholder="Κωδικός" value="" id="psw" name="psw">
						<span>
							<i class="fa fa-eye" aria-hidden="true" data-id="psw" id="togglePassword"></i>
						</span>
						<div aria-hidden="true" class="default-ltr-cache-emv211 ea3diy32"></div>
					</div>
					<div class="errorMsg pass" id="passMsg">
						<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="e1vkmu651 default-ltr-cache-2zeu8w e1svuwfo1" data-name="CircleX" role="img" aria-hidden="true">'
							<path fill-rule="evenodd" clip-rule="evenodd" d="M14.5 8C14.5 11.5899 11.5899 14.5 8 14.5C4.41015 14.5 1.5 11.5899 1.5 8C1.5 4.41015 4.41015 1.5 8 1.5C11.5899 1.5 14.5 4.41015 14.5 8ZM16 8C16 12.4183 12.4183 16 8 16C3.58172 16 0 12.4183 0 8C0 3.58172 3.58172 0 8 0C12.4183 0 16 3.58172 16 8ZM4.46967 5.53033L6.93934 8L4.46967 10.4697L5.53033 11.5303L8 9.06066L10.4697 11.5303L11.5303 10.4697L9.06066 8L11.5303 5.53033L10.4697 4.46967L8 6.93934L5.53033 4.46967L4.46967 5.53033Z" fill="currentColor"></path>
						</svg>
						Ο κωδικός χρήστη πρέπει να περιέχει τουλάχιστον 8 χαρακτήρες.
					</div>
				</div>
				<input type="hidden" id="uid" value="<?php echo $user_id;?>">
				<button type="" class="btn registerbtn">Διαγραφή</button>
			</form>
						</ul>
					</div>
				</div>
				
			</div>
<?php
		} else if ($user_id) {
			echo '<div class="container">';
			echo '<div class="inner">';
			echo '<p style="color:yellow"> '.$msg.'</p>';
			echo '<p>Έχετε συνδεθεί ως <b>'. $username .'('.$user_id.')</b></p>';
			echo '<div id="msg-info"></div>';
			/*echo '<div class="links"><div><a class="active" href="?action=edit">Ο Λογαριασμός μου</a></div><div><a href="login-tv.php">Είσοδος στην τηλεόραση</a></div><div class="last"><a href="?action=logout">Αποσύνδεση</a></div></div>';*/
			if ($action == 'edit') {
				$a = explode('-', $user['birthday']);
				$day = $a[2];
				$mon = (int)$a[1];
				$year = $a[0];
				$gender = $user["gender"];
				?>
				
				<div class="container" style="margin-top: 20px;">
					<div class="step stepEdit active">
						<div class="">
							<div class="stepHeader-container" data-uia="header">
								<div class="stepHeader" role="status">
									<!--<span id="" class="stepIndicator" data-uia="">ΒΗΜΑ <b>2</b> ΑΠΟ <b>4</b></span>-->
									<!--h1 class="stepTitle" data-uia="stepTitle">Αλλαγή στοιχείων</h1-->
								</div>
								<!--button type="" onclick="showPass(this);" class="btn registerbtn">Αλλαγή κωδικού</button-->
							</div>
							<div style="display: none" id="parentControl-Container" class="section">
								<?php include("parentcontrol.php"); ?>
							</div>
							<div id="change-pass-container">

								<ul class="simpleForm">
									<li data-uia="field-password+wrapper" class="nfFormSpace" id="old-pass-li">
										<div>
											<label class="text" for="old-pass">Παλιός Κωδικός</label>
											<div >
												<input type="password" autocomplete="new-password" iconaspectratio="1:1" placeholder="" value="" id="old-pass" name="old-pass">
												<span>
													<i class="fa fa-eye" aria-hidden="true" data-id="old-pass" id="togglePassword"></i>
												</span>
												<div aria-hidden="true" class="default-ltr-cache-emv211 ea3diy32"></div>
											</div>
											<div class="errorMsg pass" id="old-passMsg">
												<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="e1vkmu651 default-ltr-cache-2zeu8w e1svuwfo1" data-name="CircleX" role="img" aria-hidden="true">'
													<path fill-rule="evenodd" clip-rule="evenodd" d="M14.5 8C14.5 11.5899 11.5899 14.5 8 14.5C4.41015 14.5 1.5 11.5899 1.5 8C1.5 4.41015 4.41015 1.5 8 1.5C11.5899 1.5 14.5 4.41015 14.5 8ZM16 8C16 12.4183 12.4183 16 8 16C3.58172 16 0 12.4183 0 8C0 3.58172 3.58172 0 8 0C12.4183 0 16 3.58172 16 8ZM4.46967 5.53033L6.93934 8L4.46967 10.4697L5.53033 11.5303L8 9.06066L10.4697 11.5303L11.5303 10.4697L9.06066 8L11.5303 5.53033L10.4697 4.46967L8 6.93934L5.53033 4.46967L4.46967 5.53033Z" fill="currentColor"></path>
												</svg>
												Ο κωδικός χρήστη πρέπει να περιέχει τουλάχιστον 8 χαρακτήρες.
											</div>
										</div>
									</li>
									<li data-uia="field-password+wrapper" class="nfFormSpace" id="new-pass-li">
										<div>
											<label class="text" for="new-psw">Κωδικός</label>
											<div >
												<input type="password" autocomplete="new-password" iconaspectratio="1:1" placeholder="" value="" id="new-psw" name="new-psw">
												<span>
													<i class="fa fa-eye" aria-hidden="true" data-id="new-pass" id="togglePassword2"></i>
												</span>
												<div aria-hidden="true" class="default-ltr-cache-emv211 ea3diy32"></div>
											</div>
											<div class="errorMsg pass" id="new-passMsg">
												<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="e1vkmu651 default-ltr-cache-2zeu8w e1svuwfo1" data-name="CircleX" role="img" aria-hidden="true">'
													<path fill-rule="evenodd" clip-rule="evenodd" d="M14.5 8C14.5 11.5899 11.5899 14.5 8 14.5C4.41015 14.5 1.5 11.5899 1.5 8C1.5 4.41015 4.41015 1.5 8 1.5C11.5899 1.5 14.5 4.41015 14.5 8ZM16 8C16 12.4183 12.4183 16 8 16C3.58172 16 0 12.4183 0 8C0 3.58172 3.58172 0 8 0C12.4183 0 16 3.58172 16 8ZM4.46967 5.53033L6.93934 8L4.46967 10.4697L5.53033 11.5303L8 9.06066L10.4697 11.5303L11.5303 10.4697L9.06066 8L11.5303 5.53033L10.4697 4.46967L8 6.93934L5.53033 4.46967L4.46967 5.53033Z" fill="currentColor"></path>
												</svg>
												Ο κωδικός χρήστη πρέπει να περιέχει τουλάχιστον 8 χαρακτήρες.
											</div>
										</div>
									</li>
									<li id="dobli" data-uia="field-dob+wrapper" class="nfFormSpace">
										<div>
											<label class="text active" for="dobEdit">Ημ/νία Γέννησης (προαιρετική)</label>
											<div >
												<input type="text" iconaspectratio="1:1" placeholder="" value="" id="dobEdit" name="dobEdit">
												<div aria-hidden="true" class="default-ltr-cache-emv211 ea3diy32"></div>
											</div>
											<div class="errorMsg dob" id="dateMsg">
												<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="e1vkmu651 default-ltr-cache-2zeu8w e1svuwfo1" data-name="CircleX" role="img" aria-hidden="true">'
													<path fill-rule="evenodd" clip-rule="evenodd" d="M14.5 8C14.5 11.5899 11.5899 14.5 8 14.5C4.41015 14.5 1.5 11.5899 1.5 8C1.5 4.41015 4.41015 1.5 8 1.5C11.5899 1.5 14.5 4.41015 14.5 8ZM16 8C16 12.4183 12.4183 16 8 16C3.58172 16 0 12.4183 0 8C0 3.58172 3.58172 0 8 0C12.4183 0 16 3.58172 16 8ZM4.46967 5.53033L6.93934 8L4.46967 10.4697L5.53033 11.5303L8 9.06066L10.4697 11.5303L11.5303 10.4697L9.06066 8L11.5303 5.53033L10.4697 4.46967L8 6.93934L5.53033 4.46967L4.46967 5.53033Z" fill="currentColor"></path>
												</svg>
												Δώστε ημερομηνία γέννησης
											</div>
										</div>
									</li>
									<script>
										var day = <?php echo $day;?>;
										var month = "<?php echo $mon;?>";
										var year = <?php echo $year;?>;
										var month = month.padStart(2, '0');
										document.getElementById("dobEdit").value = day+"/"+month+"/"+year;
										new AirDatepicker('#dobEdit', {
											locale: localeEl
										});
									</script>	
									<li class="select" id="genderli">
										<label for="genderEdit">Φύλο (προαιρετικό)</label>
										<select name="gender" id="genderEdit" >
											<option value=''></option>
											<option value='F' <?php echo ($gender == "F")? "selected": ""; ?> >Γυναίκα</option>
											<option value='M' <?php echo ($gender == "M")? "selected": ""; ?>>Άνδρας</option>
											<option value='O' <?php echo ($gender == "O")? "selected": ""; ?>>Άλλο</option>
										</select>
									</li>
									<input type="hidden" id="uid" value="<?php echo $user_id;?>">
									


								</ul>
							</div>
						</div>
						
					</div>
					<div class="editBtns" id="edit-buttons">
					
						<div><button type="" onclick="edit();" class="btn registerbtn">Αποθήκευση αλλαγών</button></div>
						<?php

						/*if($_COOKIE["userid"] == "299" || $_COOKIE["userid"] == "290" || $_COOKIE["userid"] == "265" || $_COOKIE["userid"] == "293") {*/ ?>
						
					<!--div><button type="" onclick='location.href="index.php"'; class="btn registerbtn">Επιστροφή</button>
					</div-->
					</div>
					<div class="step stepEditPass">
						<div class="">
							<div class="stepHeader-container" data-uia="header">
								<div class="stepHeader" role="status">
									<!--<span id="" class="stepIndicator" data-uia="">ΒΗΜΑ <b>2</b> ΑΠΟ <b>4</b></span>-->
									<h1 class="stepTitle" data-uia="stepTitle">Αλλαγή στοιχείων</h1>
								</div>
							</div>
							<div>

								<ul class="simpleForm">
									
									
								</ul>
							</div>
						</div>
						<button type="" onclick="signup();" class="btn registerbtn">Αποθήκευση</button>
					</div>

			</div>
					
<?php
}
echo '</div>';
echo '</div>';
} else {
	/*if(!isset($user_id) || $user_id == 0){
		die('<center><h2>You cannot access this page at this time</h2></center></div></body></html>');
	}*/
	?>

	<div class="container flex">
		<div class="step step1 active">
			<div class="stepLogoContainer">
				<span></span>
			</div>
			<div class="stepHeader-container" data-uia="header">
				<div class="stepHeader" role="status">
					<span id="" class="stepIndicator" data-uia="">ΒΗΜΑ <b>2</b> ΑΠΟ <b>2</b></span>
					<h1 class="stepTitle" data-uia="stepTitle">Ολοκληρώστε τη δημιουργία του λογαριασμού σας</h1>
				</div>
			</div>
			<div id="" class="contextBody contextRow" data-uia="regContextBody">Το MegaPlay είναι εξατομικευμένο για εσάς. Δημιουργήστε έναν κωδικό πρόσβασης για να βλέπετε σε οποιαδήποτε συσκευή και οποιαδήποτε στιγμή.</div>
			<button type="" onclick="nextCard()" class="btn nextbtn">Επόμενο</button>
		</div>
		
		<div class="step step2">
			<div class="">
				<div class="stepHeader-container" data-uia="header">
					<div class="stepHeader" role="status">
						<span id="" class="stepIndicator" data-uia="">ΒΗΜΑ <b>2</b> ΑΠΟ <b>2</b></span>
						<h1 class="stepTitle" data-uia="stepTitle">Εγγραφή</h1>
					</div>
				</div>
				<div>
					<div id="" class="contextRow" data-uia="contextRowDone">Παρακαλώ συμπληρώστε τα στοιχεία για να εγγραφείτε ως νέος χρήστης!</div>
					<!--<span id="" class="contextRow" data-uia="contextRowPaperWork">Ο κωδικός χρήστη πρέπει να περιέχει τουλάχιστον 8 χαρακτήρες.</span>-->
					<ul class="simpleForm" id="data-form">
						<li class="nfFormSpace">
							<div class="">
								<label class="text active" for="email">Email</label>
								<div >
									<input type="email" autocomplete="off" placeholder="" name="email" id="email" value="<?php echo $user_email; ?>" >
									<div aria-hidden="true">
									</div>
								</div>
								<div class="errorMsg email" id="emailMsg">
									Email is required.
								</div>
							</div>
						</li>
						<li data-uia="field-password+wrapper" class="nfFormSpace">
							<div>
								<div id="tvcode" style="display: none"><?php echo $tvcode; ?></div>
								<label class="text" for="psw">Προσθήκη κωδικού πρόσβασης</label>
								<div >
									<input type="password" autocomplete="new-password" iconaspectratio="1:1" placeholder="" value="" id="psw" name="psw">
									<div aria-hidden="true" class="default-ltr-cache-emv211 ea3diy32"></div>
								</div>
								<div class="errorMsg pass" id="passMsg">
									<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="e1vkmu651 default-ltr-cache-2zeu8w e1svuwfo1" data-name="CircleX" role="img" aria-hidden="true">'
										<path fill-rule="evenodd" clip-rule="evenodd" d="M14.5 8C14.5 11.5899 11.5899 14.5 8 14.5C4.41015 14.5 1.5 11.5899 1.5 8C1.5 4.41015 4.41015 1.5 8 1.5C11.5899 1.5 14.5 4.41015 14.5 8ZM16 8C16 12.4183 12.4183 16 8 16C3.58172 16 0 12.4183 0 8C0 3.58172 3.58172 0 8 0C12.4183 0 16 3.58172 16 8ZM4.46967 5.53033L6.93934 8L4.46967 10.4697L5.53033 11.5303L8 9.06066L10.4697 11.5303L11.5303 10.4697L9.06066 8L11.5303 5.53033L10.4697 4.46967L8 6.93934L5.53033 4.46967L4.46967 5.53033Z" fill="currentColor"></path>
									</svg>
									Ο κωδικός χρήστη πρέπει να περιέχει τουλάχιστον 8 χαρακτήρες.
								</div>
							</div>
						</li>
						<li data-uia="field-password+wrapper" class="nfFormSpace">
							<div>
								<label class="text" for="phoneno">Αριθμός κινητού τηλεφώνου (προαιρετικός)</label>
								<div >
									<input type="tel" iconaspectratio="1:1" placeholder="" value="" id="phoneno" name="phoneno">
									<div aria-hidden="true" class="default-ltr-cache-emv211 ea3diy32"></div>
								</div>
							</div>
						</li>
						<li data-uia="field-dob+wrapper" class="nfFormSpace">
							<div>
								<label class="text" for="dob">Ημ/νία Γέννησης (προαιρετική)</label>
								<div >
									<input type="text" iconaspectratio="1:1" placeholder="" value="" id="dob" name="dob">
									<div aria-hidden="true" class="default-ltr-cache-emv211 ea3diy32"></div>
								</div>
								<div class="errorMsg dob" id="dateMsg">
									<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="e1vkmu651 default-ltr-cache-2zeu8w e1svuwfo1" data-name="CircleX" role="img" aria-hidden="true">'
										<path fill-rule="evenodd" clip-rule="evenodd" d="M14.5 8C14.5 11.5899 11.5899 14.5 8 14.5C4.41015 14.5 1.5 11.5899 1.5 8C1.5 4.41015 4.41015 1.5 8 1.5C11.5899 1.5 14.5 4.41015 14.5 8ZM16 8C16 12.4183 12.4183 16 8 16C3.58172 16 0 12.4183 0 8C0 3.58172 3.58172 0 8 0C12.4183 0 16 3.58172 16 8ZM4.46967 5.53033L6.93934 8L4.46967 10.4697L5.53033 11.5303L8 9.06066L10.4697 11.5303L11.5303 10.4697L9.06066 8L11.5303 5.53033L10.4697 4.46967L8 6.93934L5.53033 4.46967L4.46967 5.53033Z" fill="currentColor"></path>
									</svg>
									Δώστε ημερομηνία γέννησης
								</div>
							</div>
						</li>
						<li class="select">
							<label for="gender">Φύλο (προαιρετικό)</label>
					<select name="gender" id="gender" >
						<option value='' selected>Χωρίς απάντηση</option>
						<option value='F'>Γυναίκα</option>
						<option value='M'>Άνδρας</option>
						<option value='O'>Άλλο</option>
					</select>
						</li>
						<li class="checkbox">
							<div class="checkbox-wrapper-28">
								<input id="iagree" type="checkbox" class="promoted-input-checkbox"/>
								<svg><use xlink:href="#checkmark-28" /></svg>
								<label for="iagree">
									Συμφωνώ με τους όρους χρήσης.   
								</label>

								<div class="errorMsg check" id="checkMsg">
									<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="e1vkmu651 default-ltr-cache-2zeu8w e1svuwfo1" data-name="CircleX" role="img" aria-hidden="true">
										<path fill-rule="evenodd" clip-rule="evenodd" d="M14.5 8C14.5 11.5899 11.5899 14.5 8 14.5C4.41015 14.5 1.5 11.5899 1.5 8C1.5 4.41015 4.41015 1.5 8 1.5C11.5899 1.5 14.5 4.41015 14.5 8ZM16 8C16 12.4183 12.4183 16 8 16C3.58172 16 0 12.4183 0 8C0 3.58172 3.58172 0 8 0C12.4183 0 16 3.58172 16 8ZM4.46967 5.53033L6.93934 8L4.46967 10.4697L5.53033 11.5303L8 9.06066L10.4697 11.5303L11.5303 10.4697L9.06066 8L11.5303 5.53033L10.4697 4.46967L8 6.93934L5.53033 4.46967L4.46967 5.53033Z" fill="currentColor"></path>
									</svg>
									Θα πρέπει να συμφωνήσετε με τους όρους χρήσης
								</div>
								<svg xmlns="http://www.w3.org/2000/svg" style="display: none">
									<symbol id="checkmark-28" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-miterlimit="10" fill="none"  d="M22.9 3.7l-15.2 16.6-6.6-7.1">
										</path>
									</symbol>
								</svg>
							</div>
						</li>
						<li><a target="_blank" href="?action=legal" onclick="return popup(this, 'terms')">Διαβάστε τους όρους χρήσης.</a></li>
					</ul>
				</div>
			</div>

			


				<button type="" onclick="signup();" class="btn registerbtn">Εγγραφή</button>
			</div>

		<div class="step step3">
			<!--<div class="stepLogoContainer">
				<span></span>
			</div>-->
			<div class="stepHeader-container" data-uia="header">
				<div class="stepHeader" role="status">
					<h1 class="stepTitle" data-uia="stepTitle">Καλώς ορίσατε στο Mega!</h1>
				</div>
			</div>
			<div id="" class="contextBody contextRow" data-uia="regContextBody">Ο λογαριασμός σας είναι έτοιμος. Σε λίγα δευτερόλεπτα θα μπορείτε να συνδεθείτε με την τηλεόραση σας και να απολαύσε τις νέες λειτουργίες!</div>
			<!--<button type="" onclick="nextCard()" class="btn nextbtn">Επόμενο</button>-->
		</div>
		</div>
<?php } ?>
</div>
</body>
</html>
