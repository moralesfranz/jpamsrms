<?php
error_reporting(0);

// Check if a session is already active
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

if (isset($_POST['submit'])) {
	$arival   = $_SESSION['from'];
	$departure = $_SESSION['to'];
	$adults = 1;
	$child = 1;
	$roomid = $_SESSION['roomid'];

	$_SESSION['name']   = $_POST['name'];
	$_SESSION['last']   = $_POST['last'];
	$_SESSION['country']   = $_POST['country'];
	$_SESSION['city']    = $_POST['city'];
	$_SESSION['address'] = $_POST['address'];
	$_SESSION['zip']   = $_POST['zip'];
	$_SESSION['phone']   = $_POST['phone'];
	$_SESSION['email'] = $_POST['email'];
	$_SESSION['pass']  = $_POST['pass'];
	$_SESSION['pending']  = 'pending';

	$name   = $_SESSION['name'];
	$last   = $_SESSION['last'];
	$country = $_SESSION['country'];
	$city   = $_SESSION['city'];
	$address = $_SESSION['address'];
	$zip    =  $_SESSION['zip'];
	$phone  = $_SESSION['phone'];
	$email  = $_SESSION['email'];
	$password = $_SESSION['pass'];

	$days = dateDiff($arival, $departure);

	redirect('index.php?view=payment');
}
?>


<div class="container">
	<?php include '../sidebar.php'; ?>

	<div class="col-xs-12 col-sm-9">
		<!--<div class="jumbotron">-->
		<div class="">
			<!--    <div class="panel panel-default">
            <div class="panel-body">   -->

			<?php //include'navigator.php';
			?>


			<td valign="top" class="body" style="padding-bottom:10px;">
				<?php
				if (isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) > 0) {
					echo '<ul class="err">';
					foreach ($_SESSION['ERRMSG_ARR'] as $msg) {
						echo '<li>', $msg, '</li>';
					}
					echo '</ul>';
					unset($_SESSION['ERRMSG_ARR']);
				}
				?>

				<form class="form-horizontal span6" action="index.php?view=info" method="post" name="personal" onsubmit="return personalInfo()" style="margin-left:20px">
					<fieldset>
						<legend>
							<h2>Personal Details</h2>
						</legend>
						<div class="form-group">
							<div class="col-md-8">
								<label class="col-md-4 control-label" for="name">Firstname:</label>
								<div class="col-md-8">
									<input name="name" type="text" class="form-control input-sm" id="name" placeholder="Enter your first name" />
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-8">
								<label class="col-md-4 control-label" for="last">Lastname:</label>
								<div class="col-md-8">
									<input name="last" type="text" class="form-control input-sm" id="last" placeholder="Enter your last name" />
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-8">
								<label class="col-md-4 control-label" for="city">City:</label>
								<div class="col-md-8">
									<input name="city" type="text" class="form-control input-sm" id="city" placeholder="Enter your city" />
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-8">
								<label class="col-md-4 control-label" for="address">Address:</label>
								<div class="col-md-8">
									<input name="address" type="text" class="form-control input-sm" id="address" placeholder="Enter your address" />
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-8">
								<label class="col-md-4 control-label" for="zip">Zip Code:</label>
								<div class="col-md-8">
									<input name="zip" type="text" class="form-control input-sm" id="zip" placeholder="Enter your zip code" />
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-8">
								<label class="col-md-4 control-label" for="phone">Cellpone:</label>
								<div class="col-md-8">
									<input name="phone" type="tel" class="form-control input-sm" id="phone" maxlength="11"
										pattern="\d{10}" title="Please enter a valid 10-digit phone number"
										placeholder="Enter your phone number" />
								</div>
							</div>
						</div>
						<!-- JavaScript to detect the max length and show an alert -->
						<script>
							document.getElementById('phone').addEventListener('input', function(e) {
								const maxLength = 11;
								if (this.value.length === maxLength) {
									alert('You have reached the maximum allowed digits.');
								}
							});
						</script>
						<div class="form-group">
							<div class="col-md-8">
								<label class="col-md-4 control-label" for="email">Email Address:</label>
								<div class="col-md-8">
									<input name="email" type="email" class="form-control input-sm" id="email"
										placeholder="Enter your email address" />
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-8">
								<label class="col-md-4 control-label" for="cemail">Confirm Email Address:</label>
								<div class="col-md-8">
									<input name="cemail" type="email" class="form-control input-sm" id="cemail"
										placeholder="Confirm your email address" />
								</div>
							</div>
						</div>
					</fieldset>
					&nbsp; &nbsp;
					<div class="form-group">
						<div class="col-md-6">
							<p>
								<input type="checkbox" id="condition" name="condition" value="checkbox" />
								<small>
									I Agree with the
									<a href="#" data-toggle="modal" data-target="#termsModal"><b>TERMS AND CONDITION</b></a>
									of this Resort
								</small>
								<br />
								<img src="captcha_code_file.php?rand=<?php echo rand(); ?>" id='captchaimg'>
								<a href='javascript: refreshCaptcha();'>
									<img src="<?php echo WEB_ROOT; ?>images/refresh.png" alt="refresh" border="0" style="margin-top:5px; margin-left:5px;" />
								</a>
								<br />
								<small>If you are a Human Enter the code above here :</small>
								<input id="6_letters_code" name="6_letters_code" type="text" class="form-control input-sm" width="20">
							</p>
							<br />
							<div class="col-md-4">
								<input name="submit" type="submit" value="Confirm" class="btn btn-inverse" id="confirmButton" onclick="return personalInfo();" />
							</div>
						</div>
					</div>

					<!-- Terms and Conditions Modal -->
					<div id="termsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="termsModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<p>Welcome to JPAMS Private Resort. By accessing our online reservation website and using our services, you agree to comply with and be bound by the following terms and conditions of use.</p>

									<h4>Booking and Reservations:</h4>
									<ul>
										<li>All bookings are automated and processed immediately upon payment.</li>
										<li>Once payment is received, your slot is secured and confirmed.</li>
										<li>Our calendar booking system will display available and taken slots.</li>
										<li>At least 50% of the total amount of reservation will be the down payment to secure the slot.</li>
										<li>Remaining balance will be settled upon checkout.</li>
									</ul>

									<h4>Cancellation and Refund Policy:</h4>
									<ul>
										<li>JPAMS Private Resort strictly has a nonrefundable policy.</li>
										<li>Cancellation and rescheduling of reservations will be applicable by request.</li>
										<li>Rebooking a slot incurs a fee of 50% of the original booking cost.</li>
									</ul>

									<h4>Guest Responsibilities:</h4>
									<ul>
										<li>Your personal information is handled in accordance with our Privacy Policy. By using our website, you consent to the collection, use, and disclosure of your information as described therein.</li>
									</ul>

									<h4>Changes to Terms:</h4>
									<ul>
										<li>JPAMS Private Resort reserves the right to update or modify these terms and conditions at any time without prior notice. Continued use of the website after such changes constitutes your acceptance of the new terms.</li>
									</ul>

									<h4>Liability Disclaimer:</h4>
									<ul>
										<li>JPAMS Private Resort is not liable for any loss, damage, injury, or inconvenience arising from your use of our facilities or services.</li>
										<li>By making a booking you are confirming that you are authorised to do so on behalf of all persons named in the booking and you are acknowledging that all members of your party agree to be bound by these Booking Terms & Conditions.</li>
										<li>When your booking has been made, a confirmation can be sent to you by email using the email address that you have supplied, or by post. Booking confirmations are subject to the availability of accommodation at the hotel.</li>
										<li>You should carefully check the details of your confirmation as soon as you receive it. You must contact Aplaya’s beach resort immediately if any of the details are incorrect or incomplete.</li>
										<li>We will always endeavour to rectify any inaccuracies or accommodate any alterations you wish to make to your booking. We cannot accept liability for any inaccuracies that are not brought to our attention within seven days of issuing your confirmation, nor can we accept responsibility for inaccurate information that you have supplied.</li>
									</ul>

									<h4>JPAMS Private Resort Rules and Policies:</h4>
									<ul>
										<li>Proper swimming attire is a must.</li>
										<li>Do not swim if you have infectious or communicable diseases.</li>
										<li>No running, rough play, or excessive noise in the pool and on the pool deck.</li>
										<li>Running, jumping, and diving into the pool are not allowed.</li>
										<li>Swim diapers or plastic pants are required for babies and toddlers.</li>
										<li>No spitting, spouting of water, or blowing of nose in the pool.</li>
										<li>Adults with children 12 years of age and younger in the pool must be supervised by an adult.</li>
										<li>Floating devices must never be replaced in water without adult supervision.</li>
										<li>No pets allowed in the swimming pool.</li>
										<li>No glass or metal articles in or around the pool area.</li>
										<li>During the rainy season, the pool area must be cleared at the first clap of lightning, or any other dangerous weather condition. The management reserves the right to deny use of the pool to anyone currently.</li>
									</ul>

									<p>As we treat our guests with respect and courtesy, we also request our guests to treat our staff and other guests in the same manner. Thank you for choosing JPAMS PRIVATE RESORT.</p>
									<br>
									<br>

									<p>Respectfully yours,</p>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</div>

					<script>
						// Enable or disable the Confirm button based on checkbox state
						document.getElementById("condition").addEventListener("change", function() {
							var confirmButton = document.getElementById("confirmButton");
							confirmButton.disabled = !this.checked; // Enable if checked, disable if unchecked
						});

						function validateForm() {
							var checkbox = document.getElementById("condition");
							if (!checkbox.checked) {
								alert("You must agree to the terms and conditions before proceeding.");
								return false; // Prevent form submission
							}
							alert("Form submitted successfully!"); // Simulate form submission
							document.forms[0].submit(); // Submit the form
						}
					</script>

					<!-- Bootstrap and jQuery JS -->
					<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
					<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
					<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


					<!--  </div>-->
		</div>
		<style>
			.form-group {
				position: relative;
				margin-bottom: 1.5rem;
			}

			.form-control {
				padding: 0.75rem 0.75rem;
			}

			.form-label {
				position: absolute;
				top: 10px;
				left: 15px;
				transition: 0.2s ease all;
				color: #999;
				pointer-events: none;
				/* Prevent interaction with the label */
			}

			.form-control:focus+.form-label,
			.form-control:not(:placeholder-shown)+.form-label {
				top: -10px;
				left: 15px;
				font-size: 12px;
				color: #007bff;
				/* Change to the desired color */
				opacity: 1;
				/* Ensure it's visible */
			}

			.form-control:focus {
				border-color: #007bff;
				/* Change border color on focus */
				box-shadow: 0 0 5px rgba(0, 123, 255, .5);
			}
		</style>
		<!--/span-->
		<!--Sidebar-->

	</div>
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<!--/row-->
	<?php require_once 'terms_condition.php'; ?>