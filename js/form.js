var pin = ageLimit = userid= "";

function setCookie(name,value,days) {
	var expires = "";
	if (days) {
		var date = new Date();
		date.setTime(date.getTime() + (days*24*60*60*1000));
		expires = "; expires=" + date.toUTCString();
	}
	document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}

function parseJSON(txt) {
	if (!txt) {
		return null;
	}
	var startpos = 0,
		endpos = txt.length - 1,
		fchar, lchar;
	while (startpos + 1 < endpos && txt.charCodeAt(startpos) < 33) {
		startpos++;
	}
	while (endpos - 1 > startpos && txt.charCodeAt(endpos) < 33) {
		endpos--;
	}
	fchar = txt.substring(startpos, startpos + 1);
	lchar = txt.substring(endpos, endpos + 1);
	if ((fchar === '[' && lchar === ']') || (fchar === '{' && lchar === '}')) {
		try {
			txt = txt.substring(startpos, endpos + 1);
			return eval('(' + txt + ')');
		} catch (e) {}
	}
	return null;
}

function createHttpRequest(url, callback, options) {
	var req = new XMLHttpRequest();
	//req.timeout = 500;
	if (callback) {
		req.onreadystatechange = function () {
			if (req.readyState !== 4) {
				return;
			}
			if (callback) {
				try {
					if (req.status >= 200 && req.status < 300) {
						callback(req.responseText);
					} else {
						callback(null);
					}
				} catch (e) {
					if (console && console.log ) {
						console.log('Error while processing URL ' + url + ': ' + e + ' - Result was: ' + req.status + '/' + req.responseText);
						console.log(e);
					}
				}
			}
			req.onreadystatechange = null;
			req = null;
		};
	}
	
	try {
		
		
		req.open((options ? options.method : null) || 'GET', url, true);
		if (!options || !options.dosend) {
			req.send(null);
		} else {
			options.dosend(req);
		}
	} catch (e) {
		req.onreadystatechange = null;
		if ( console && console.log ) {
			console.log(["Cannot open URL " + url, e]);
		}
		try {
			callback(null);
		} catch (e2) {}
		req = null;
	}
	return req;
}

function validateEmail(email) {
	const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test(String(email).toLowerCase());
}

function showMsg(msg){
	document.getElementById("msg-info").innerHTML = msg;
}



function edit(){
	var Password = document.getElementById("new-psw").value;
	var oldPass = document.getElementById("old-pass").value;
	var dataedit = "";
	if(document.getElementById("dobEdit")){
		var DoB = document.getElementById("dobEdit").value;
		if(DoB!=""){
			var dateParts = DoB.split("/");
			if (dateParts.length < 2)
				dateParts = DoB.split("-");
			if (dateParts.length < 2)
				dateParts = DoB.split(".");
			if (dateParts.length > 1) {
				// month is 0-based, that's why we need dataParts[1] - 1
				var d = new Date(+dateParts[2], parseInt(dateParts[1]) - 1, +dateParts[0]), birthday = d.addHours(12).toISOString().split('T')[0];
				dataedit += "&birthday="+birthday;
			}
		}
	}
	if(document.getElementById("genderEdit")){
		dataedit += "&gender="+document.getElementById("genderEdit").value;
	}
	if(document.getElementById("day")){
		var day = document.getElementById("day").value;
	    var month = document.getElementById("month").value;
	    var year = document.getElementById("year").value;
	    var gender = document.getElementById("gender").value;
	}

	if (document.getElementById('new-psw').style.display == 'block' && (Password.length < 8 || oldPass.length < 8)) {
		showMsg('To μήκος του κωδικού πρέπει να είναι 8 ή περισσότεροι χαρακτήρες');
		return;
	}
	
	if(document.getElementById("day")){
		var dateval = year +'-'+ month +'-'+ day;
	    var d = new Date(dateval), birthday = d.toISOString().split('T')[0];
		dataedit = "&birthday="+birthday+"gender="+gender;
	}

	var uid = document.getElementById("uid").value;
	
	var add = '';
	if (Password.length && oldPass.length) {
		add = "&password="+encodeURIComponent(Password) +'&oldpass='+ encodeURIComponent(oldPass);
	}
	var url = "http://mega.smart-tv-data.com/dev/users.php?action=update-user&user_id="+ uid  +add + dataedit;
	

	this.req = createHttpRequest(url, function(res) {
		req = null;
		var j = parseJSON(res);
		if(j.success && j.success == true){
			
			var msg = 'Η αλλαγή στοιχείων πραγματοποιήθηκε με επιτυχία.';
			setTimeout(function() {
				location.href = 'index.php?action=edit&msg='+msg;
			}, 100);

		}else if (j.success == false) {
			alert(j.msg);
		}
	})

}


function resetPassword(){
	var email = document.getElementById("uname").value;
	
	if(email == "") {
		
		showMsg("Παρακαλώ πληκρολογήστε τη διεύθυνση email σας για να σας αποσταλεί εκεί ο σύνδεσμος ανάκτησης του κωδικού πρόσβασης.");
		return true;
	}
	var url = "http://mega.smart-tv-data.com/dev/users.php?action=resetpsw&email=" +email; 
	
	this.req = createHttpRequest(url, function(res) {
		req = null;
		var j = parseJSON(res);
		if(j.success && j.success == true){
			
			showMsg('Σας έχει σταλεί στη διεύθυνση email σας ένα σύνδεσμος για να ανακτήσετε τον κωδικό πρόσβασης.');

		}else if (j.success == false) {
			showMsg(j.msg);
		}
	});
}

function signup(){
	var Email = document.getElementById("email").value;
	var Password = document.getElementById("psw").value;
	var Tvcode = document.getElementById("tvcode").innerHTML;
	//var day = document.getElementById("day").value;
	//var month = document.getElementById("month").value;
	//var year = document.getElementById("year").value;
	var DoB = document.getElementById("dob").value;
	var gender = document.getElementById("gender").value;
	console.log(DoB);
	if (!document.getElementById("iagree").checked) {
		var errorMsg = document.getElementById("checkMsg");
		if(!errorMsg.classList.contains("show")) errorMsg.classList.add("show");
		return;
	}
	/*
	if (!validateEmail(Email)) {
		showMsg('To email που δώσατε δεν είναι έγκυρο');
		return;

	}
	if (Password.length < 8) {
		showMsg('To μήκος του κωδικού πρέπει να είναι 8 ή περισσότεροι χαρακτήρες');
		return;
	}
	if (day.length == 0 || year.length < 4) {
		showMsg('Δώστε ημερομηνία γέννησης');
		return;
	}*/
	//var dateval = year +'-'+ month +'-'+ day;
	if(DoB!=""){
		var dateParts = DoB.split("/");

	// month is 0-based, that's why we need dataParts[1] - 1

	var d = new Date(+dateParts[2], parseInt(dateParts[1]) - 1, +dateParts[0]), birthday = d.addHours(12).toISOString().split('T')[0];
	//console.log(DoB, dateParts[2]+"-"+(parseInt(dateParts[1]) - 1)+"-"+dateParts[0], d);
	//console.log(dateval);return;
	}else{
		var birthday = "";
	}
	var url = "http://mega.smart-tv-data.com/dev/users.php?action=signup&username="+Email+"&password="+encodeURIComponent(Password) +'&gender='+ gender +'&birthday='+ birthday;
	
	this.req = createHttpRequest(url, function(res) {
		req = null;
		var j = parseJSON(res);
		if(j.success && j.success == true){
			
			//document.getElementById("emailStep3").innerHTML = Email;
			//nextCard();

			setTimeout(function(){codelogin(Tvcode, j.user_id);}, 1000);
			setTimeout(function(){login(true);}, 1000);
		}else if (j.success == false) {
			console.log(j.msg);
			//showMsg(j.msg);
		}
	})

}

function login(auto){
	if(!document.getElementById("uname"))
		var Login = document.getElementById("email").value;
	else var Login = document.getElementById("uname").value;
	var Password = document.getElementById("psw").value;


	var url = "http://mega.smart-tv-data.com/dev/users.php?action=login&username="+Login+"&password="+encodeURIComponent(Password);
	//var url = "http://mega.smart-tv-data.com/dev/users.php?action=login&username="+Login;

	var me =this;
	this.req = createHttpRequest(url, function(res) {
		req = null;
		var j = parseJSON(res);
		if(j.success && j.success == true){
			setCookie('userid', j.user_id, 30);
			setCookie('pin', j.pin, 30);
			setCookie('ageLimit', j.age_limit, 30);
			pin = j.pin;
			ageLimit = j.age_limit;
			userid = j.user_id;
	
			setTimeout(function() {
					location.href = "login-tv.php";
				}, 1000);
			

			//token = j.token;

			//Encrypted is actually an object, but you can call encrypted.toString() to get the string. 
			//var encrypted = CryptoJS.AES.encrypt("Salteddd"+Password+"", token );

			//TODO check if password from database corresponds to password given by user.
			/*var url2 = "http://mega.smart-tv-data.com/dev/users.php?action=verifyuser&username="+Login+"&sessiontoken="+encrypted.toString();
			console.log(url2);
			me.req2 = createHttpRequest(url2, function(res) {
				var j2 = parseJSON(res);
				if(j2.success && j2.success == false) {
					showMsg("Ο κωδικός που δώσατε είναι λανθασμένος");
					return true;	
				}else {
					setTimeout(function() {
					var msg = "Η εγγραφή σας ολοκληρώθηκε με επιτυχία. Μπορείτε να μεταβείτε στην τηλεόραση για να απολαύσετε τις δυνατότητες του Mega Play.";
					msg = (auto === true) ? msg : "";
					location.href = "login-tv.php";
					//showMsg("Η είσοδος πραγματοποιήθηκε με επιτυχία. );
					//location.href = 'login-tv.php?msg=login-success';

				}, 1000);
				}
			});
			*/
			
			//showMsg("Η είσοδος πραγματοποιήθηκε με επιτυχία. Θα μεταφερθείτε στην Αρχική.");
			
			
				
		}else if (j.success == false) {
			if(document.getElementById("email")) {
				setTimeout(function() {
				location.href = 'login.php';
			}, 1500);
				return;
			}
			showMsg(j.msg);
		}
	});
}

function closeParentControl(){
	document.getElementById("parentControl-Container").style.display= "none";
					
	document.getElementById("genderli").style.display = "block";
	document.getElementById("dobli").style.display = "block";
	document.getElementById("edit-buttons").style.display = "block";
}

function activateParentControl(){

	const uid = document.getElementById("uid").value;
	var ageLimit = document.getElementById("ageLimit").value;

	//var playbackLimit = (document.getElementById("playbackLimit").value) ? document.getElementById("playbackLimit").value : "";
var playbackLimit = 0;
	const url = "http://mega.smart-tv-data.com/dev/users.php?action=enable-lock&user_id="+ uid +'&ageLimit='+ ageLimit + "&playbackLimit=" + playbackLimit;
	
	this.req = createHttpRequest(url, function(res) {
				var j = parseJSON(res);
				if(j.success && j.success == true){
					showMsg("Η ενεργοποίηση του κλειδώματος ολοκληρώθηκε με επιτυχία.");
				}else if (j.success == false) {
					showMsg("Παρουσιάστηκε πρόβλημα στην ενεργοποίηση κλειδώματος.");
				}
	});

}

function resetPIN(){
	const uid = document.getElementById("uid").value;
	var pin = document.getElementById("newPin").value;

	const url = "http://mega.smart-tv-data.com/dev/users.php?action=reset-pin&user_id="+ uid +'&pin='+ pin ;
	this.req = createHttpRequest(url, function(res) {
				var j = parseJSON(res);
				if(j.success && j.success == true){

					///document.getElementById("data-form").style.display = "block";
					//document.getElementById("edit-buttons").style.display = "block";
					//document.getElementById("pin-change").style.display = "none"
					showMsg("Η αλλαγή του PIN ολοκληρώθηκε με επιτυχία.");
				}else if (j.success == false) {
					showMsg("Παρουσιάστηκε πρόβλημα στην αλλαγή του PIN.");
				}
	});


	
}

function showPinChange(){
	if(document.getElementById("pin-change").style.display == "none") document.getElementById("pin-change").style.display="block";
	else document.getElementById("pin-change").style.display = "none";
}

function showParentControl(a){
	document.getElementById("change-pass-container").style.display = "none";
	document.getElementById("genderli").style.display = "none";
	document.getElementById("dobli").style.display = "none";
	document.getElementById("edit-buttons").style.display = "none";
	
	//a.style.display='none';
	document.getElementById("parentControl-Container").style.display= "block";
	//document.getElementById("data-form").style.display = "none";
	
	var uid = document.getElementById("uid").value;
	const url = "http://mega.smart-tv-data.com/dev/users.php?action=retrieve-triplet&user_id="+ uid;
			
	this.req = createHttpRequest(url, function(res) {
				var j = parseJSON(res);
				
				document.getElementById("ageLimit").value = j.age_limit;
			});

}

function showPass(a) {
	document.getElementById("change-pass-container").style.display = "block";
	document.getElementById("parentControl-Container").style.display = "none";
	
	var el = document.getElementById("new-pass-li");
	el.style.display='block';
	var el = document.getElementById("old-pass-li");
	el.style.display='block';
	document.getElementById("genderli").style.display = "none";
	document.getElementById("dobli").style.display = "none";

}
const localeEl = {
    days: ['Κυριακή', 'Δευτέρα', 'Τρίτη', 'Τετάρτη', 'Πέμπτη', 'Παρασκευή', 'Σάββατο'],
    daysShort: ['Κυρ', 'Δευ', 'Τρί', 'Τετ', 'Πέμ', 'Παρ', 'Σάβ'],
    daysMin: ['Κυ', 'Δε', 'Τρ', 'Τε', 'Πε', 'Πα', 'Σα'],
    months: ['Ιανουάριος', 'Φεβρουάριος', 'Μάρτιος', 'Απρίλιος', 'Μάιος', 'Ιούνιος', 'Ιούλιος', 'Αύγουστος', 'Σεπτέμβριος', 'Οκτώβριος', 'Νοέμβριος', 'Δεκέμβριος'],
    monthsShort: ['Ιαν', 'Φεβ', 'Μαρ', 'Απρ', 'Μάι', 'Ιούν', 'Ιούλ', 'Αύγ', 'Σεπ', 'Οκτ', 'Νοε', 'Δεκ'],
    today: 'Σήμερα',
    clear: 'Καθαρισμός',
    dateFormat: 'dd/MM/yyyy',
    timeFormat: 'hh:mm aa',
    firstDay: 1
};
const errorIcon = '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="e1vkmu651 default-ltr-cache-2zeu8w e1svuwfo1" data-name="CircleX" role="img" aria-hidden="true">'+
				  '<path fill-rule="evenodd" clip-rule="evenodd" d="M14.5 8C14.5 11.5899 11.5899 14.5 8 14.5C4.41015 14.5 1.5 11.5899 1.5 8C1.5 4.41015 4.41015 1.5 8 1.5C11.5899 1.5 14.5 4.41015 14.5 8ZM16 8C16 12.4183 12.4183 16 8 16C3.58172 16 0 12.4183 0 8C0 3.58172 3.58172 0 8 0C12.4183 0 16 3.58172 16 8ZM4.46967 5.53033L6.93934 8L4.46967 10.4697L5.53033 11.5303L8 9.06066L10.4697 11.5303L11.5303 10.4697L9.06066 8L11.5303 5.53033L10.4697 4.46967L8 6.93934L5.53033 4.46967L4.46967 5.53033Z" fill="currentColor"></path>'+
				  '</svg>';
window.addEventListener("load", (event) => {
	console.log("page is fully loaded");


	if(document.getElementById("submenu")) document.getElementById("submenu").addEventListener("mouseout", function(){
		
		document.getElementById("submenu").style.display = "none";
	});
	if(document.getElementById("circles")) document.getElementById("circles").addEventListener("mouseover", function(){
		
		document.getElementById("submenu").style.display = "block";
	});


	if(document.getElementById("circles")) document.getElementById("circles").addEventListener("click", function () {
		openSubMenu();
	});




	if(0 && typeof AirDatepicker != 'undefined'){
		if(document.getElementById("dob")) new AirDatepicker('#dob', {
			locale: localeEl
		});
		if(document.getElementById("dobEdit")) new AirDatepicker('#dobEdit', {
											locale: localeEl
			});
	}else{

		var options = {
			format: 'dd/mm/yyyy',
			todayHighlight: true,
			autoclose: true,
			language: 'el'
		};
		$.datepicker.regional['el'] = {
	                closeText: 'Κλείσιμο',
	                prevText: 'Προηγούμενος',
	                nextText: 'Επόμενος',
	                currentText: 'Τρέχων Μήνας',
	                monthNames: ['Ιανουάριος','Φεβρουάριος','Μάρτιος','Απρίλιος','Μάιος','Ιούνιος',
	                'Ιούλιος','Αύγουστος','Σεπτέμβριος','Οκτώβριος','Νοέμβριος','Δεκέμβριος'],
	                monthNamesShort: ['Ιαν','Φεβ','Μαρ','Απρ','Μαι','Ιουν',
	                'Ιουλ','Αυγ','Σεπ','Οκτ','Νοε','Δεκ'],
	                dayNames: ['Κυριακή','Δευτέρα','Τρίτη','Τετάρτη','Πέμπτη','Παρασκευή','Σάββατο'],
	                dayNamesShort: ['Κυρ','Δευ','Τρι','Τετ','Πεμ','Παρ','Σαβ'],
	                dayNamesMin: ['Κυ','Δε','Τρ','Τε','Πε','Πα','Σα'],
	                weekHeader: 'Εβδ',
	                dateFormat: 'dd/mm/yy',
	                firstDay: 1,
	                isRTL: false,
	                changeMonth: true,
     changeYear: true,
     yearRange: "1930:2010",
	                showMonthAfterYear: false,
	                yearSuffix: ''};
	        $.datepicker.setDefaults($.datepicker.regional['el']);
    if(document.getElementById("dobEdit")) $( "#dobEdit" ).datepicker(options);
    if(document.getElementById("dob")) $( "#dob" ).datepicker(options);
  
}

	const tp = document.getElementById('togglePassword');
	if (tp) {
		var password = document.querySelector("#psw");
		if (!password) {
			const did = tp.getAttribute('data-id');
			password = document.getElementById(did);
		}
		tp.state=false;
		tp.addEventListener("click", function () {
			const type = password.getAttribute("type") === "password" ? "text" : "password";
			password.setAttribute("type", type);

			// toggle the icon
			this.state= !this.state;
			this.style.color= (this.state ? '#5887ef' : '#000');
		});
	}
	const tp2 = document.getElementById('togglePassword2');
	if (tp2) {
		const password = document.querySelector("#new-psw");
		tp2.state=false;
		tp2.addEventListener("click", function () {
			const type = password.getAttribute("type") === "password" ? "text" : "password";
			password.setAttribute("type", type);
			this.state= !this.state;
			this.style.color= (this.state ? '#5887ef' : '#000');
		});
	}
	const form = document.getElementById('del-form');
	if (form) {
		form.addEventListener('submit', (e) => {
			e.preventDefault();
			var errorMsg = document.getElementById("passMsg");
			const inp = document.getElementById('psw');

			if (psw.value.length < 8){
				if (!errorMsg.classList.contains("show"))
					errorMsg.classList.add("show");
				return;
			} else {
				errorMsg.classList.remove("show");
			}
			//check pass
			const uid = document.getElementById("uid").value;
			const url = "http://mega.smart-tv-data.com/dev/users.php?action=check-pass&user_id="+ uid +'&password='+ encodeURIComponent(inp.value);
			this.req = createHttpRequest(url, function(res) {
				var j = parseJSON(res);
				if(j.success && j.success == true){
					if (confirm('Οριστική διαγραφή λογαριασμού;')) {
						const url = "http://mega.smart-tv-data.com/dev/users.php?action=del-user&user_id="+ uid;
						const req = createHttpRequest(url, function(res) {
							var j = parseJSON(res);
							if(j.success && j.success == true){
								alert('Ο λογαριασμός σας διαγράφηκε με επιτυχία');
								setTimeout(function() {
									location = '?action=logout&fremoval=1';
								}, 800);
							}else if (j.success == false) {
								alert(j.msg);
							}
						})
					}
				}else if (j.success == false) {
					alert(j.msg);
				}
			});
		});
	}
	const inputs = document.querySelectorAll("input");
	for (var i = 0; i < inputs.length; i++) {
		if(inputs[i].type=="checkbox") continue;
		var label = document.querySelector('label[for="'+inputs[i].id+'"]');
		if (label) {
			if(!inputs[i].value){
				label.classList.remove("active");
			}else if(!label.classList.contains("active")){
				label.classList.add("active");
			}
		}
		inputs[i].addEventListener("focus", function(e) {
			var label =document.querySelector('label[for="'+e.target.id+'"]');
			if (label && !label.classList.contains("active"))
				document.querySelector('label[for="'+e.target.id+'"]').classList.add("active");
		});
		inputs[i].addEventListener("blur", function(e){
			if(e.target.value==""){
				if (document.querySelector('label[for="'+e.target.id+'"]'))
					document.querySelector('label[for="'+e.target.id+'"]').classList.remove("active");
			}
			if(e.target.id=="email"){
				var errorMsg = document.getElementById("emailMsg");
				if(!validateEmail(e.target.value)){
					errorMsg.innerHTML = errorIcon + 'Το email που δώσατε δεν είναι έγκυρο'
					if(!errorMsg.classList.contains("show")) errorMsg.classList.add("show");
				}else{
					errorMsg.classList.remove("show");
				}
			}
			if(e.target.id=="psw"){
				var errorMsg = document.getElementById("passMsg");
				if(e.target.value.length < 8){
					if(!errorMsg.classList.contains("show")) errorMsg.classList.add("show");
				}else{
					errorMsg.classList.remove("show");
				}
			}
			if(e.target.id=="new-pass"){
				var errorMsg = document.getElementById("new-passMsg");
				if(e.target.value.length < 8){
					if(!errorMsg.classList.contains("show")) errorMsg.classList.add("show");
				}else{
					errorMsg.classList.remove("show");
				}
			}
			if(e.target.id=="old-pass"){
				var errorMsg = document.getElementById("old-passMsg");
				if(e.target.value.length < 8){
					if(!errorMsg.classList.contains("show")) errorMsg.classList.add("show");
				}else{
					errorMsg.classList.remove("show");
				}
			}
			if(e.target.id=="dob"){
				var errorMsg = document.getElementById("dateMsg");
				if(e.target.value != "" && e.target.value.length < 10){
					if(!errorMsg.classList.contains("show")) errorMsg.classList.add("show");
				}else{
					errorMsg.classList.remove("show");
				}
			}
		});
		if(document.getElementById("iagree")){
			document.getElementById("iagree").addEventListener("change", function(e){
				if(e.target.checked == "true"){
					document.getElementById("checkMsg").classList.remove("show");
				}
			})
		}
	}
	var el = document.getElementById("action");
	if (el && el.value == 'codelogin') {

		document.getElementById("code-0").focus();

		for (var i = 0; i < 6; i++) {
			var el = document.getElementById("code-"+i);
			el.addEventListener('focus', (event) => {
				var el = event.target, n = el.getAttribute('data-i'), foc = 10;

				if (!el.value.length) {
					for (var j = n; j >= 0; j--) {
						if (document.getElementById('code-'+ j).value.length) {
							foc = j+1;
							break;
						}
					}
					if (foc == 10) foc = 0;
					
					setFocus(document.getElementById('code-'+ foc));
				}
			});

			el.addEventListener('keyup', (event) => {

				var k = event.keyCode, n = parseInt(event.target.getAttribute('data-i'));
				console.log("code key up event, n : " + n);
				if (k == 0 || k == 229) {
					k = event.target.value.charAt(event.target.selectionStart - 1).charCodeAt();
					
				}

				if (k != 9 && k != 8 && k != 37 && k != 39 && (k < 48 || k > 57) && !(k > 95 && k < 106)) {
					event.target.value = "";
					return ;
				}
				if (k == 8) {
					var v = event.target.value;
					event.target.value = '';
					if (!v.length && n > 0) {
						//document.getElementById('code-'+ (n-1)).value = "";
						setFocus(document.getElementById('code-'+ (n-1)));
					}
				} else if (k == 37 &&  n > 0) {
					setFocus(document.getElementById('code-'+ (n-1)));
				} else if (k == 39 &&  n < 5) {
					setFocus(document.getElementById('code-'+ (n+1)));
				} else {
					if (n < 5) {
						setFocus(document.getElementById('code-'+ (n+1)));
					} else if (k != 9 && event.target.value.length)
						document.getElementById('do-login').focus();
				}
			});
		}
	} else if (el && el.value == 'activate') {
		const queryString = window.location.search;
		const urlParams = new URLSearchParams(queryString);
		const vcode = urlParams.get('c');
		if (!vcode.length)
			showMsg('Παρουσιάστηκε κάποιο πρόβλημα (1)');
		else {
			var url = "http://mega.smart-tv-data.com/dev/users.php?action=v&c="+ encodeURIComponent(vcode);

			this.req = createHttpRequest(url, function(res) {
				req = null;
				var j = parseJSON(res);
				if(j.success && j.success == true){
					showMsg('Η ενεργοποίηση του λογαριασμού σας πραγματοποιήθηκε με επιτυχία. Θα μεταφερθείτε στην Αρχική.');
				}else if (j.success == false) {
					showMsg(j.msg);
				}
				setTimeout(function() {
					location.href = 'index.php';
				}, 2500);
			})
		}
	}
});

function handleOptionPress(elem, id){
	
	switch(id){
		case "parent-control-btn":
			document.getElementById("submenu").style.display= "none";
			
			showParentControl(elem, id);
			break;
		case "change-pass-btn":
			document.getElementById("submenu").style.display= "none";
			
			showPass(elem, id);
			break;
		case "delete-user-btn":
			setTimeout(function() {
				window.location.href='?action=del-user';
			}, 100);
			break;
		case "disconnect-user-btn":
			setTimeout(function() {
				window.location.href='?action=logout';
			}, 100);
			break;
		default:
			break;
	}
}

function openSubMenu(){
	document.getElementById("submenu").style.display ="block";
}

function setFocus(el) {
	console.log("set focus");
	console.log(el);
	window.setTimeout(() => el.focus(), 0);
}
function setBlur(el) {
	window.setTimeout(() => el.blur(), 0);
}

function codelogin(code, uid){
	if(!code && !uid){
		var code = '', uid = document.getElementById("uid").value;
		for (var i = 0; i < 6; i++) {
			var v = document.getElementById("code-"+i).value;
			code = code+v;
		}
	}
	var url = "http://mega.smart-tv-data.com/dev/users.php?action=set-code&user_id="+ uid +"&code="+ code;

	this.req = createHttpRequest(url, function(res) {
		req = null;
		var j = parseJSON(res);
		if(j.success && j.success == true){
			showMsg('Η σύνδεση με την συσκευή "'+ j.device +' πραγματοποιήθηκε με επιτυχία.');
		}else if (j.success == false) {
			showMsg('Λάθος κωδικός');
		}
	})
}

function nextCard() {
	var cards = document.querySelectorAll(".step");
	for (var i = 0; i < cards.length; i++){
		if(cards[i].classList.contains("active")){
			cards[i].classList.remove("active");
			cards[i+1].classList.add("active");
			break;
		}
		/*if(i == cards.length-1){
			setTimeout(function(){alert("Please wait.");login();}, 1000);
		}*/
	}
}
function prevCard() {
	var cards = document.querySelectorAll(".step");
	for (var i = cards.length; i > 0; i--){
		if(cards[i].classList.contains("active")){
			cards[i].classList.remove("active");
			cards[i-1].classList.add("active");
			break;
		}
	}
}

Date.prototype.addHours = function(h) {
  this.setTime(this.getTime() + (h*60*60*1000));
  return this;
}
