<?php

date_default_timezone_set('Asia/Manila');
$fulldateTom = date('Y-m-d', strtotime('+1 day'));

if (isset($_POST['login'])) {
	$email = $_POST['log_email'];
	$pass  = $_POST['log_pword'];
	if ($email == '' or $pass == '') {
		message("Invalid Username and Password!", "error");
		redirect("index.php");
	} else {
		$guest = new Guest();
		$res = $guest->guest_login($email, $pass);
		if ($res == true) {
			redirect("index.php");
		} else {
			message("Username or Password Not Registered! Contact Your administrator.", "error");
			redirect("index.php");
		}
	}
}
?>
<!--Side bar-->
<div class="row row-offcanvas row-offcanvas-right">
	<div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
		<div class="sidebar-nav">
			<div class="panel panel-inverse">
				<div class="panel-heading">Book a Room</div>
				<div class="panel-body">
					<form method="POST" action="#.php">
						<div class="col-xs-12 col-sm-12">
							<div class="form-group">
								<div class="row">
									<div class="col-xs-12 col-sm-12">
										<label class="control-label" for="from">Select Date</label>
										<input class="form-control" type="date" value="<?php echo isset($_SESSION['from']) ? $_SESSION['from'] : $fulldateTom; ?>" min="<?php echo $fulldateTom; ?>" name="from" id="from">
											<input type="hidden" id="sessDate" value="<?php echo isset($_SESSION['from']) ? $_SESSION['from'] : $fulldateTom; ?>" />
											<!-- echo  -->
										<!-- <input class="form-control from" type="date" size="11"
											value="<?php //echo (isset($_SESSION['from'])) ? $_SESSION['from'] : ''; ?>"
											data-date="" min="<?php //echo $fulldateTom ?>" data-date-format="yyyy-mm-dd" data-link-field="any"
											data-link-format="yyyy-mm-dd" value="" name="from" id="from" autocomplete="off"> -->
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-xs-12 col-sm-12">
										<label class="control-label" for="to">Select Tour</label>
										<select class="form-control" name="to" id="to" required>
											<option value="" selected disabled>Select Tour</option>
											<option value="Day Tour" <?php echo (isset($_SESSION['to']) && $_SESSION['to'] == 'Day Tour') ? 'selected' : ''; ?>>Day Tour</option>
											<option value="Night Tour" <?php echo (isset($_SESSION['to']) && $_SESSION['to'] == 'Night Tour') ? 'selected' : ''; ?>>Night Tour</option>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-xs-12 col-sm-12">
										<button type="submit" class="btn btn-inverse" align="right" name="avail">Check Availability</button>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			<form name="clock">
				<input class="form-control" id="trans" type="label" name="face" value="" disabled>
			</form>
			<hr>
		</div>
		<!--/.well -->
	</div>
	<!--/span-->
	<!--End of Side bar-->


<script>

document.getElementById("to").onchange = function() {
        var selectedValue = this.value;
		var sessdate = document.getElementById("sessDate").value;
		$.ajax({
			url: 'store_ampm.php',
			method: 'POST',
			data: { ampm: selectedValue, from: sessdate },
			success: function(response) {
				console.log('Value sent to PHP successfully:', response);
			},
			error: function(error) {
				console.log('Error sending value:', error);
			}
		});
		
    };
	document.getElementById("from").onchange = function() {
        const dateInput = document.getElementById('from').value;
        document.getElementById('sessDate').value = dateInput;
    };
</script>