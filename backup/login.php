<?php
//header('Content-Type: application/vnd.hbbtv.xhtml+xml; charset=utf-8');
header('Access-Control-Allow-Origin: *');
echo ('<?xml version="1.0" encoding="utf-8" ?>');
date_default_timezone_set('Europe/Athens');
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
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
    <div id="msg-info"></div>
    <h1>Είσοδος</h1>
    <label for="uname"><b>Όνομα Χρήστη</b></label>
    <input type="text" placeholder="Δώσε όνομα χρήστη" name="uname" id="uname" required>

    <label for="psw"><b>Κωδικός</b></label>
    <input type="password" placeholder="Δώσε κωδικό πρόσβασης" name="psw" id="psw" required>

    
    <!--span class="psw">Ξέχασες <a href="#">τον κωδικό?</a></span-->
  </div>

<button type="" onclick="login();">Είσοδος</button>
  
<!--/form-->
</div>

</body>
</html>