<?php

// $arrival = '';
// $departure = '';
// if (isset($_SESSION['from'])) {
// 	$arrival = $_SESSION['from'];
// 	$departure = $_SESSION['to'];
// }
// if (isset($_POST['btnbook'])) {

// 	if (!isset($_SESSION['from']) || !isset($_SESSION['to'])) {
// 		message("Please Choose check in Date and Check out Out date to continue reservation!", "error");
// 		redirect("index.php?page=5");
// 	}
// 	if (isset($_POST['roomid'])) {
// 		$days = dateDiff($arrival, $departure);
// 		$totalprice = $_POST['roomprice'] * $days;
// 		addtocart($_POST['roomid'], $days, $totalprice, $arrival, $departure);


// 		// $count_cart = count($_SESSION['magbanua_cart']);

// 		//                             for ($i=0; $i < $count_cart  ; $i++) { 
// 		//                             	echo $_SESSION['magbanua_cart'][$i]['magbanuaroomid'].'<br/>';
// 		//                             	echo $_SESSION['magbanua_cart'][$i]['magbanuaday'].'<br/>';
// 		//                             	echo $_SESSION['magbanua_cart'][$i]['magbanuaroomprice'].'<br/>';

// 		//                             }



// 		redirect(WEB_ROOT . 'booking/');
// 	}
// }

$arrival = '';
$departure = '';

if (isset($_SESSION['from'])) {
    $arrival = $_SESSION['from'];
}

// echo '<script>alert(localStorage.getItem("ampm"))</script>';

// Update the logic to get departure from the session
if (isset($_SESSION['to'])) {
    $departure = $_SESSION['to']; // This will be either "Day Tour" or "Night Tour"
}

if (isset($_POST['btnbook'])) {
    // Check for arrival and departure values
    if (!isset($_SESSION['from']) || !isset($_SESSION['to'])) {
        message("Please choose check-in date and tour option to continue reservation!", "error");
        redirect("index.php?page=6");
    }
    
    if (isset($_POST['roomid'])) {
        // Assuming you want to calculate days based on the type of tour
        // Set days based on the selected tour
        $days = ($departure === 'Day Tour') ? 1 : 1; // Assuming each tour lasts 1 day for this example
        $totalprice = $_POST['roomprice'] * $days;
        
        // Call your function to add to cart
        addtocart($_POST['roomid'], $days, $totalprice, $arrival, $departure);
        
        redirect(WEB_ROOT . 'booking/');
    }
}


/*if(!isset($_POST['adults'])){
    message("Choose from Adults!", "error");	
    redirect(".WEB_ROOT. 'booking/");
   	//exit;
 }*/
/* if(isset($_POST['adults'])&&isset($_POST['child'])){
    $_SESSION['roomid']=$_POST['roomid'];
	$_SESSION['adults'] = $_POST['adults'];
	$_SESSION['child']  = $_POST['child'];
   */
//	$_SESSION['roomid']=$_POST['roomid'];

//exit;
//} 
//}

?>
<!--End of Header-->
<div class="container">
	<div class="col-xs-12 col-sm-9">
		<!--<div class="jumbotron">-->
		<div class="">
			<!-- 		<div class="panel panel-default">
						<div class="panel-body">	 -->
			<fieldset>
				<p class="bg-warning">

					<?php
					echo '<div class="alert alert-info" ><strong>From:' . $arrival . ' To: ' . $departure . '</strong>  </div>';
					?></p>


				<legend>
					<h2 class="text-left">Select Extra Room</h2>
				</legend>

				<?php
				$mydb->setQuery("SELECT *,typeName FROM room ro, roomtype rt WHERE ro.typeID = rt.typeID AND ro.type = 'Room' ");
				$cur = $mydb->loadResultList();


				foreach ($cur as $result) {
					$mydb->setQuery("SELECT STATUS FROM reservation
												WHERE ((
												'$arrival' >= arrival
												AND  '$arrival' <= departure
												)
												OR (
												'$departure' >= arrival
												AND  '$departure' <= departure
												)
												OR (
												arrival >=  '$arrival'
												AND arrival <=  '$departure'
												)
												)
												AND roomNo =" . $result->roomNo);

					$stats = $mydb->executeQuery();
					$rows = $mydb->loadSingleResult($stats);
					

					$image = WEB_ROOT . 'admin/mod_room/' . $result->roomImage;
					echo '<div style="float:left; width:370px; margin-left:10px;">';
					echo '<div style="float:left; width:70px; margin-bottom:10px;">';
					echo '<img src="' . $image . '" width="180px" height="150px" style="-webkit-border-radius:5px; -moz-border-radius:5px;"title="' . $result->roomName . '"/>';
					echo '</div>';

					echo '<div style="float:right; height:125px; width:180px; margin:0px; color:#000033;">';
					echo '<form name="book"  method="POST" action="' . WEB_ROOT . 'index.php?page=5">';
					//'. $result->typeName.'<br/>'. $result->price.'<br/>'. $result->Adults.'<br/>
					echo '<input type="hidden" name="roomid" value="' . $result->roomNo . '"/>
						<input type="hidden" name="roomprice" value="' . (($_SESSION['ampm'] == 'Day Tour') ? $result->dayPrice : $result->nightPrice) . '"/>';
						echo '<p><strong>Room: ' . $result->typeName . '<br/>
						<strong>Capacity: ' . $result->Adults . '<br/>
						<strong>Rate (' . $_SESSION['ampm'] . '): </strong> &#8369 ' . 
						(($_SESSION['ampm'] == 'Day Tour') ? $result->dayPrice : $result->nightPrice) . ' </p>';
					$status = isset($rows->STATUS) ? $rows->STATUS : '';
					if ($status == 'pending') {
						echo '<div style="margin-top:10px; color: rgba(0,0,0,1); font-size:16px;"><strong>Reserve!</strong></div><br>';
					} elseif ($status == 'Confirmed') {
						echo '<div style="margin-top:10px; color: rgba(0,0,0,1); font-size:16px;"><strong>Book!</strong></div><br>';
					} elseif ($status == 'Checkedin') {
						echo '<div style="margin-top:10px; color: rgba(0,0,0,1); font-size:16px;"><strong>Book!</strong></div><br>';
					} else {
						echo '
								  	 <div class="form-group">
							            	<div class="row">
						            			<div class="col-xs-12 col-sm-12">
						            				<input type="submit" class="btn btn-inverse btn-sm" name="btnbook" onclick="return validateBook();" value="Add Room"/>
																           				     
							           			 </div>
							            	</div>
							            </div>';
					}


					echo '</form>';
					echo '</div>';
					echo '</div>';
				}
				

				?>



			</fieldset>
			<!-- 	</div>
					</div>	 -->

		</div>
		<!--	</div>-->
	</div>
	<!--/span-->
	<!--Sidebar-->

	<?php include 'sidebar.php'; ?>

</div>
<!--/row-->
<script>

</script>