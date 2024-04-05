<!DOCTYPE html>
<html>
<!--head>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,shrink-to-fit=no, viewport-fit=cover">
	<script type="text/javascript" src="js/form.js?<?php echo rand()?>"></script>
	<link rel="stylesheet" href="css/form.css?<?php echo rand()?>" />
	<link href=" https://cdn.jsdelivr.net/npm/air-datepicker@3.4.0/air-datepicker.min.css " rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
	<script src=" https://cdn.jsdelivr.net/npm/air-datepicker@3.4.0/air-datepicker.min.js "></script>
</head-->
<body>
	<div>
		<h3>PIN</h3>
		<div>
			<div>
				<p>Αλλάξτε το PIN σας. Ο κωδικός είναι απαραίτητος για την επιβεβαίωση του γονικού ελέγχου. To αρχικό PIN είναι: 1234
					<br/>
					<a style="text-decoration: underline; color:rgba(208, 0, 61, 0.9)" onclick="showPinChange()" type="button" data-test="button-change-pin-trigger">Αλλαγή PIN
					</a>
				</p>
				<form id="pin-change" style="display: none">
					<div>
						<div data-test="change-pin-form-old-pin-label">
							<!--label for="oldPin">Παλιό PIN</label>
							<div>
								<input type="password" id="oldPin" name="oldPin" placeholder="" required="" value="" style="display: block;">
								<input type="text" id="_oldPin" name="" class="" placeholder="" required="" value="" style="display: none;">
								<a class="show-pass" href="" tabindex="-1">Show</a>
							</div-->
							<span>To αρχικό PIN είναι: 1234</span>
						</div>
						<div data-test="change-pin-form-new-pin-label">
							<label for="newPin">Νέο PIN</label>
							<div>
								<input type="password" id="newPin" name="newPin" class="" placeholder="" required="" value="" style="display: block;color:black; width:150px">
								<input type="text" id="_newPin" name="" class="" placeholder="" required="" value="" style="display: none;">
								
							</div>
							<span>Το PIN αποτελείται από 4 ψηφία</span>
						</div>
					</div>
					<div>
						<button onclick="resetPIN()" class="btn registerbtn" type="submit" data-test="button-change-pin-submit">Αποθήκευση αλλαγών
						</button>
						<button onclick="showPinChange()" class="btn registerbtn" type="button" data-test="button-change-pin-cancel">
							Ακύρωση
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>


	<div>
		<div >
			<h2 >Κλειδωμένο περιεχόμενο</h2>
			<div>
				<div>
					<div>
						<h3>Γονικός έλεγχος</h3>
						<form>
							<p>Ορίστε ηλικιακό όριο για το προστατευόμενο περιεχόμενο. Το PIN θα είναι απαραίτητο για παρακολούθηση του περιεχομένου με βάση την ηλικία που επιλέχθηκε.</p>
							<div>
								<div data-test="parental-control-form-fieldset">
									<div data-test="parental-control-form-age-limit">
										<select id="ageLimit" data-test="playback-limit-fieldset">
										<option value="1">Κατάλληλο για όλους</option>
										<option value="2" data-test="playback-limit-option">8 ετών</option>
										<option value="3" data-test="playback-limit-option">12 ετών</option>
										<option value="4" data-test="playback-limit-option">16 ετών</option>
										<option value="5" data-test="playback-limit-option">18 ετών</option>
									</select>
										
									</div>
									
								</div>
							</div>
						</form>
					</div>
				</div>
				<!--div>
					<h3>Όριο αναπαραγωγής</h3>
					<form>
						<p data-test="playback-limit-introduction">Ορίστε ημερήσιο όριο αναπαραγωγής για αυτήν τη συσκευή. Το PIN σας είναι απαραίτητο για την παρακολούθηση περιεχομένου που υπερβαίνει το όριο. </p>
						<div>
							<select id="playbackLimit" data-test="playback-limit-fieldset">
								<option value="">Χωρίς όριο</option>
								<option value="15" data-test="playback-limit-option">15 λεπ.</option>
								<option value="30" data-test="playback-limit-option">30 λεπ.</option>
								<option value="60" data-test="playback-limit-option">60 λεπ.</option>
								<option value="120" data-test="playback-limit-option">120 λεπ.</option>
							</select>
						</div>
					</form>
				</div>
			</div-->
			<div>
				<button onclick="activateParentControl()" type="button" class="btn registerbtn" style="width:270px">
					Ενεργοποίηση κλειδώματος
				</button>
				
			</div>
		</div>
	</div>
</div>
</body>
</html>
