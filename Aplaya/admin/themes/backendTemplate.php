<?php
//require_once("../includes/initialize.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>JPAMS</title>


	<link href="<?php echo WEB_ROOT; ?>admin/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo WEB_ROOT; ?>admin/css/dataTables.bootstrap.css" rel="stylesheet" media="screen">
	<link rel="stylesheet" type="text/css" href="<?php echo WEB_ROOT; ?>admin/css/jquery.dataTables.css">
	<link href="<?php echo WEB_ROOT; ?>admin/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
	<script type="text/javascript" language="javascript" src="<?php echo WEB_ROOT; ?>admin/js/jquery.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo WEB_ROOT; ?>admin/js/jquery.dataTables.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo WEB_ROOT; ?>admin/js/bootstrap.min.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo WEB_ROOT; ?>admin/js/bootstrap-modal.js"></script>
	<script type="text/javascript" src="<?php echo WEB_ROOT; ?>admin/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
	<script type="text/javascript" src="<?php echo WEB_ROOT; ?>admin/js/locales/bootstrap-datetimepicker.uk.js" charset="UTF-8"></script>
</head>
<script type="text/javascript">
	//execute if all html elemen has been completely loaded
	$(document).ready(function() {

				//specify class name of a specific element. click event listener--
				$('.cls_btn').click(function() {
					//access the id of the specific element that has been click	
					var id = $(this).attr('id');
					//to debug every value of element,variable, object ect...
					console.log($(this).attr('id'));

					//execute a php file without reloading the page and manipulate the php responce data
					$.ajax({

							type: "POST",
							//the php file that contain a mysql query
							url: "some.php",
							//submit parameter
							data: {
								id: id,
								name: 'kevin'
							}
						})
						//.done means will execute if the php file has done all the processing(ex: query)
						.done(function(msg) {
							//decode JSON from PHP file response
							var result = JSON.parse(msg);

							// 	console.log(this);

							// 	//apply the value to each element
							//   $('#display #infoid').html(result[0].member_id);
							//   $('#display #infoname').html(result[0].fName+" "+result[0].lName);
							//   $('#display #Email').html(result[0].email);
							//   $('#display #Gender').html(result[0].gender);
							//   $('#display #bday').html(result[0].bday);
							//     });

						});

				});
</script>
<script type="text/javascript" charset="utf-8">
	$(document).on("click", ".get-id", function() {
		var p_id = $(this).data('id');
		$(".modal-body #infoid").val(p_id);

	});
</script>


<script type="text/javascript">
	$(document).ready(function() {
		$('.toggle-modal').click(function() {
			$('#logout').modal('toggle');
		});
	});
</script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.toggle-modal-reserve').click(function() {
			$('#reservation').modal('toggle');
		});
	});
</script>


<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		var t = $('#example').DataTable({
			"columnDefs": [{
				"searchable": false,
				"orderable": false,
				"targets": 1
			}],
			//vertical scroll
			// "scrollY":        "300px",
			// "scrollCollapse": true,
			//ordering start at column 2
			"order": [
				[1, 'desc']
			]
		});

		t.on('order.dt search.dt', function() {
			t.column(0, {
				search: 'applied',
				order: 'applied'
			}).nodes().each(function(cell, i) {
				cell.innerHTML = i + 1;
			});
		}).draw();
	});


	$(document).ready(function() {
		var t = $('#table').DataTable({
			"columnDefs": [{
				"searchable": false,
				"orderable": false,
				"targets": 0
			}],
			//vertical scroll
			"scrollY": "300px",
			"scrollCollapse": true,
			//ordering start at column 2
			"order": [
				[7, 'desc']
			]
		});

		t.on('order.dt search.dt', function() {
			t.column(0, {
				search: 'applied',
				order: 'applied'
			}).nodes().each(function(cell, i) {
				cell.innerHTML = i + 1;
			});
		}).draw();
	});
</script>
<link href="<?php echo WEB_ROOT; ?>admin/css/offcanvas.css" rel="stylesheet">
<?php

//define('ADMIN_INDEX_PATH', $_SERVER['SERVER_NAME']);
//define('SEP', DIRECTORY_SEPARATOR);

admin_logged_in();
?>

<body>
	<!--Header-->

	<div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?php echo WEB_ROOT; ?>index.php">JPAMS</a>
			</div>
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li class="<?php echo (currentpage() == 'index.php') ? "active" : false; ?>"><a href="<?php echo WEB_ROOT; ?>admin/index.php">Home</a></li>
					<li class="<?php echo (currentpage() == 'mod_room') ? "active" : false; ?>"><a href="<?php echo WEB_ROOT; ?>admin/mod_room/index.php">Rooms</a></li>
					<li class="<?php echo (currentpage() == 'mod_roomtype') ? "active" : false; ?>"><a href="<?php echo WEB_ROOT; ?>admin/mod_roomtype/index.php">Room Types</a></li>
					<li class="<?php echo (currentpage() == 'mod_reservation') ? "active" : false; ?>"><a href="<?php echo WEB_ROOT; ?>admin/mod_reservation/index.php">Reservation</a></li>
					<li class="<?php echo (currentpage() == 'mod_comments') ? "active" : false; ?>"><a href="<?php echo WEB_ROOT; ?>admin/mod_comments/index.php">Comments</a></li>
					<li class="<?php echo (currentpage() == 'mod_reports') ? "active" : false; ?>"><a href="<?php echo WEB_ROOT; ?>admin/mod_reports/index.php">Reports</a></li>
					<?php if ($_SESSION['admin_ACCOUNT_TYPE'] == "Administrator") { ?>
						<li class="<?php echo (currentpage() == 'mod_users') ? "active" : false; ?>"><a href="<?php echo WEB_ROOT; ?>admin/mod_users/index.php">Users</a></li>
						<li class="<?php echo (currentpage() == 'mod_settings') ? "active" : false; ?>"><a href="<?php echo WEB_ROOT; ?>admin/mod_settings/index.php">Settings</a></li>
					<?php } ?>
					<li class="<?php echo (currentpage() == 'logout.php') ? "active" : false; ?>"><a class="toggle-modal" href="#logout">Logout</a></li>
				</ul>

			</div><!-- /.nav-collapse -->
		</div><!-- /.container -->
	</div><!-- /.navbar -->

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="well">
					<img width="1100px" hieght="100px" class="img-rounded" />
					<div class="media">
						<a class="pull-left" href="#">
							<img class="media-object" src="../img/banner.png" alt="...">
						</a>
					</div>
				</div>
			</div>
		</div>


	</div>

	<!--End of Header-->

	<div class="container">

		<?php check_message(); ?>
		<?php require_once $content; ?>
		<!--/row-->

		<hr>
		<footer>
			<p>&copy; JPAMS </p>


			<script>
				textInputs.forEach((input) => {
				input.addEventListener('input', function() {
					checkText(this);
				});
				});
				});
			</script>
			<script type="text/javascript">
				$('.start').datetimepicker({
					language: 'en',
					weekStart: 1,
					todayBtn: 1,
					autoclose: 1,
					todayHighlight: 1,
					startView: 2,
					minView: 2,
					forceParse: 0
				});
				$('.end').datetimepicker({
					language: 'en',
					weekStart: 1,
					todayBtn: 1,
					autoclose: 1,
					todayHighlight: 1,
					startView: 2,
					minView: 2,
					forceParse: 0
				});
			</script>

		</footer>
	</div>
	<!--/.container-->
</body>

</html>