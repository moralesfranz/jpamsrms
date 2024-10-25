<?php

error_reporting(0);

$arival    = $_SESSION['from'];
$departure = $_SESSION['to'];
$name      = $_SESSION['name'];
$last      = $_SESSION['last'];
$country   = $_SESSION['country'];
$city      = $_SESSION['city'];
$address   = $_SESSION['address'];
$zip       = $_SESSION['zip'];
$phone     = $_SESSION['phone'];
$email     = $_SESSION['email'];
$password  = $_SESSION['pass'];
$_SESSION['pending'] = 'pending';
$stat     = $_SESSION['pending'];
$days     = dateDiff($arival, $departure);
$currDate = date('F-y-j');

if (isset($_POST['btnsubmitbooking'])) {
    $message = $_POST['message'];

    function createRandomPassword()
    {
        $chars = "abcdefghijkmnopqrstuvwxyz023456789";
        srand((float)microtime() * 1000000);

        $i = 0;
        $pass = '';
        while ($i <= 7) {
            $num = rand() % 33;
            $tmp = substr($chars, $num, 1);
            $pass = $pass . $tmp;
            $i++;
        }
        return $pass;
    }
    
    $confirmation = createRandomPassword();
    $_SESSION['confirmation'] = $confirmation;

    // Check guest
    $mydb->setQuery("SELECT * 
                     FROM guest 
                     WHERE phone ='{$phone}' OR email='{$email}'");
    $cur = $mydb->executeQuery();
    $row_count = $mydb->num_rows($cur);

    if ($row_count >= 1) {
        $rows = $mydb->fetch_array($cur);
        $lastguest = $rows['guest_id'];

        $mydb->setQuery("UPDATE guest SET firstname='$name', lastname='$last',
                          country='$country', city='$city', address='$address',
                          zip='$zip', phone='$phone', email='$email', password='$password' 
                          WHERE guest_id='$lastguest'");
        $res = $mydb->executeQuery();
    } else {
        $mydb->setQuery("INSERT INTO guest (firstname, lastname, country, city, address, zip, phone, email, password)
        VALUES ('$name', '$last', '$country', '$city', '$address', '$zip', '$phone', '$email', '$password')");
        $res = $mydb->executeQuery();
        $lastguest = $mydb->insert_id();
    }

    $count_cart = count($_SESSION['magbanua_cart']);
    $roomTypes = array();  // Array to collect room types

    if (isset($_FILES['receipt']) && $_FILES['receipt']['error'] == 0) {
        $fileTmpPath = $_FILES['receipt']['tmp_name'];
        $fileType = $_FILES['receipt']['type'];
    
        $result1 = '';
        for ($i = 0; $i < $count_cart; $i++) {
            
            $imgData = file_get_contents($fileTmpPath);
        
            $roomNo = $mydb->escape_value($_SESSION['magbanua_cart'][$i]['magbanuaroomid']);
            $guestId = $mydb->escape_value($lastguest);
            $arrival = $mydb->escape_value($_SESSION['magbanua_cart'][$i]['magbanuacheckin']);
            $departure = $mydb->escape_value($_SESSION['magbanua_cart'][$i]['magbanuacheckout']);
            $payable = $mydb->escape_value($_SESSION['magbanua_cart'][$i]['magbanuaroomprice']);
            $status = $mydb->escape_value($stat);
            $confirmation = $mydb->escape_value($confirmation);
            $imgType = $mydb->escape_value($fileType);
            $imgDataEscaped = $mydb->escape_value($imgData); 
            $messageData = $mydb->escape_value($message);

            // Get room type and add it to the array
            $mydb->setQuery("SELECT typeName FROM room ro, roomtype rt WHERE ro.typeID = rt.typeID AND roomNo = '$roomNo'");
            $cur = $mydb->executeQuery();
            $roomResult = $mydb->fetch_array($cur);
            if (isset($roomResult['typeName'])) {
                $roomTypes[] = $roomResult['typeName'];
            }

            $sql = "INSERT INTO reservation (roomNo, guest_id, arrival, departure, adults, child, payable, status, booked, confirmation, imgType, imgData, sprequest)
            VALUES ('$roomNo', '$guestId', '$arrival', '$departure', 1, 0, '$payable', '$status', '$currDate' , '$confirmation', '$imgType', '$imgDataEscaped', '$message')";

            $mydb->setQuery($sql);
            $result = $mydb->executeQuery();

            if($result){
                $result1 = "success";
            } else {
                $result1 = "";
            }
        }

        // Concatenate room types into a single string, separating with commas if necessary
        $roomTypesString = implode(', ', $roomTypes);

        // Update the reservation with the concatenated room types
        $mydb->setQuery("UPDATE reservation SET roomType = '$roomTypesString' WHERE confirmation = '$confirmation'");
        $mydb->executeQuery();

        if ($result1) {
            echo "Reservation and receipt uploaded successfully.";
        } else {
            echo "Error in uploading receipt.";
        }
    } else {
        echo "Please upload a valid receipt image.";
    }

    $lastreserv = $mydb->insert_id();
    $mydb->setQuery("INSERT INTO comments (firstname, lastname, email, comment) VALUES('$name', '$last', '$email', '$message')");
    $msg = $mydb->executeQuery();
    message("New [" . $name . "] created successfully!", "success");
    redirect("index.php?view=detail");
}
?>

<div class="container">
    <?php include '../sidebar.php'; ?>

    <div class="col-xs-12 col-sm-9">
        <div class="">
            <div class="panel panel-default">
                <div class="panel-body">
                    <td valign="top" class="body" style="padding-bottom:10px;">
                        <form action="index.php?view=payment" method="post" name="personal" enctype="multipart/form-data">
                            <fieldset>
                                <legend>
                                    <h2>Billing Details</h2>
                                </legend>
                                <p>
                                    <strong>FIRST NAME:</strong> <?php echo $name; ?> <br />
                                    <strong>LAST NAME:</strong> <?php echo $last; ?><br />
                                    <strong>CITY:</strong> <?php echo $city; ?><br />
                                    <strong>ADDRESS:</strong> <?php echo $address; ?><br />
                                    <strong>ZIP CODE:</strong> <?php echo $zip; ?><br />
                                    <strong>CELLPHONE:</strong> <?php echo $phone; ?><br />
                                    <strong>E-MAIL:</strong> <?php echo $email; ?><br />
                                </p>

                                <table class="table table-hover">
                                    <thead>
                                        <tr bgcolor="#999999">
                                            <th width="10">#</th>
                                            <th align="center" width="120">Room Type</th>
                                            <th align="center" width="120">Check In</th>
                                            <th align="center" width="120">Tour Type</th>
                                            <th align="center" width="120">Nights</th>
                                            <th width="120">Price</th>
                                            <th align="center" width="120">Room</th>
                                            <th align="center" width="90">Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count_cart = count($_SESSION['magbanua_cart']);
                                        for ($i = 0; $i < $count_cart; $i++) {
                                            $mydb->setQuery("SELECT *, typeName FROM room ro, roomtype rt WHERE ro.typeID = rt.typeID AND roomNo =" . $_SESSION['magbanua_cart'][$i]['magbanuaroomid']);
                                            $cur = $mydb->loadResultList();

                                            foreach ($cur as $result) {
                                                echo '<tr>';
                                                echo '<td></td>';
                                                echo '<td>' . $result->typeName . '</td>';  // Collect this room type
                                                echo '<td>' . $_SESSION['magbanua_cart'][$i]['magbanuacheckin'] . '</td>';
                                                echo '<td>' . $_SESSION['magbanua_cart'][$i]['magbanuacheckout'] . '</td>';
                                                echo '<td>' . $_SESSION['magbanua_cart'][$i]['magbanuaday'] . '</td>';
                                                echo '<td> &#8369  ' .(($_SESSION['ampm'] == 'Day Tour') ? $result->dayPrice : $result->nightPrice). '</td>';
                                                echo '<td>1</td>';
                                                echo '<td >  '. $result->type.'</td>';
                                                echo '</tr>';
                                            }
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="6" class="qrcode-container">
                                                <img class="qrcode" src="../images/qr.png" alt="payment-qr">
                                            </td>
                                            <td align="right">
                                                <h5><b>Order Total: </b></h5>
                                            <td align="left">
                                                <h5><b> <?php echo ' &#8369 ' . $_SESSION['pay']; ?></b></h5>
                                            </td>
                                        </tr>
                                        <tr>
                                            <!-- Additional actions can be placed here if needed -->
                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="form-group">
                                    <label for="receipt">Upload Receipt:</label>
                                    <input type="file" name="receipt" id="receipt" accept="image/*" required>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="col-md-10">
                                            <b>Special Request</b>
                                            <textarea class="form-control input-sm" name="message" placeholder="What's on your mind?"></textarea>
                                            Some requests might have corresponding charges and are subject to availability. <br />
                                            <br />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="col-md-10">
                                            <button type="submit" class="btn btn-inverse" align="right" name="btnsubmitbooking">Payout</button>
                                        </div>
                                    </div>
                                </div>
                        </form>
                    </td>
                </div>
            </div>
        </div>
    </div>
    <!--/span-->
    <!--Sidebar-->

</div>
<!--/row-->

<style>
.qrcode-container {
  justify-content: center;
  align-items: center;
  padding: 20px;
}

.qrcode {
  width: 200px;
  height: 200px;
  border: 2px solid #000;
}

@media screen and (max-width: 1000px) {
  .qrcode {
    width: 150px;
    height: 150px;
  }
}
</style>
