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
	var Password = document.getElementById("psw").value;
	var oldPass = document.getElementById("old-pass").value;
	var day = document.getElementById("day").value;
	var month = document.getElementById("month").value;
	var year = document.getElementById("year").value;
	var gender = document.getElementById("gender").value;

	if (document.getElementById('new-pass').style.display == 'block' && (Password.length < 8 || oldPass.length < 8)) {
		showMsg('To μήκος του κωδικού πρέπει να είναι 8 ή περισσότεροι χαρακτήρες');
		return;
	}
	if (day.length == 0 || year.length < 4) {
		showMsg('Δώστε ημερομηνία γέννησης');
		return;
	}
	var uid = document.getElementById("uid").value;
	var dateval = year +'-'+ month +'-'+ day;
	var d = new Date(dateval), birthday = d.toISOString().split('T')[0];
	//console.log(dateval);return;

	var add = '';
	if (Password.length && oldPass.length) {
		add = "&password="+encodeURIComponent(Password) +'&oldpass='+ encodeURIComponent(oldPass);
	}
	var url = "http://mega.smart-tv-data.com/dev/users.php?action=update-user&user_id="+ uid +'&gender='+ gender +'&birthday='+ birthday +add;
	//console.log(url);return;

	this.req = createHttpRequest(url, function(res) {
		req = null;
		var j = parseJSON(res);
		if(j.success && j.success == true){
			
			showMsg('Η αλλαγή στοιχείων πραγματοποιήθηκε με επιτυχία. Θα μεταφερθείτε στην Αρχική.');
			setTimeout(function() {
				location.href = 'index.php';
			}, 2500);

		}else if (j.success == false) {
			showMsg(j.msg);
		}
	})

}
function signup(){
	var Email = document.getElementById("email").value;
	var Password = document.getElementById("psw").value;
	var day = document.getElementById("day").value;
	var month = document.getElementById("month").value;
	var year = document.getElementById("year").value;
	var gender = document.getElementById("gender").value;

	if (!document.getElementById("iagree").checked) {
		showMsg('Θα πρέπει να συμφωνήσετε με τους όρους χρήσης');
		return;
	}
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
	}
	var dateval = year +'-'+ month +'-'+ day;
	var d = new Date(dateval), birthday = d.toISOString().split('T')[0];
	//console.log(dateval);return;

	var url = "http://mega.smart-tv-data.com/dev/users.php?action=signup&username="+Email+"&password="+encodeURIComponent(Password) +'&gender='+ gender +'&birthday='+ birthday;

	this.req = createHttpRequest(url, function(res) {
		req = null;
		var j = parseJSON(res);
		if(j.success && j.success == true){
			
			showMsg('Η εγγραφή πραγματοποιήθηκε με επιτυχία. Θα μεταφερθείτε στην Αρχική.');
			setTimeout(function() {
				location.href = 'index.php';
			}, 1500);

		}else if (j.success == false) {
			showMsg(j.msg);
		}
	})

}

function login(){
	var Login = document.getElementById("uname").value;
	var Password = document.getElementById("psw").value;


	var url = "http://mega.smart-tv-data.com/dev/users.php?action=login&username="+Login+"&password="+encodeURIComponent(Password);

	this.req = createHttpRequest(url, function(res) {
		req = null;
		var j = parseJSON(res);
		if(j.success && j.success == true){
			
			setCookie('userid', j.user_id, 30);
			showMsg("Η είσοδος πραγματοποιήθηκε με επιτυχία. Θα μεταφερθείτε στην Αρχική.");
			setTimeout(function() {
				location.href = 'index.php';
			}, 1500);
			
				
		}else if (j.success == false) {
			showMsg('Λάθος email ή κωδικός χρήστη');
		}
	})
}
function showPass(a) {
	a.style.display='none';
	var el = document.getElementById("new-pass");
	el.style.display='block';
}

window.addEventListener("load", (event) => {
	console.log("page is fully loaded");
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
				console.log(k);
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
function setFocus(el) {
	window.setTimeout(() => el.focus(), 0);
}
function setBlur(el) {
	window.setTimeout(() => el.blur(), 0);
}

function codelogin(){
	var code = '', uid = document.getElementById("uid").value;
	for (var i = 0; i < 6; i++) {
		var v = document.getElementById("code-"+i).value;
		code = code+v;
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
