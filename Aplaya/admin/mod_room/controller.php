<?php
require_once("../../includes/initialize.php");
require_once("../../includes/room.php"); // Adjust this line based on the actual path


// Fetch the action from the URL, default to empty if not set
$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : '';

// Define valid actions
$valid_actions = ['add', 'edit', 'editimage', 'delete'];

// Check if the action is valid
if (!in_array($action, $valid_actions)) {
	message("Invalid action!", "error");
	redirect("index.php");
	exit(); // Exit to prevent further execution
}

// Perform action based on the action parameter
switch ($action) {
	case 'add':
		doInsert();
		break;
	case 'edit':
		doEdit();
		break;
	case 'editimage':
		editImg();
		break;
	case 'delete':
		doDelete();
		break;
}

function doInsert()
{
	// Check if the image file is uploaded
	if (!isset($_FILES['image']['tmp_name']) || empty($_FILES['image']['tmp_name'])) {
		message("No Image Selected!", "error");
		redirect("index.php?view=add");
		return;
	}

	$file = $_FILES['image']['tmp_name'];

	// Check for upload errors
	if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
		message("File upload error. Code: " . $_FILES['image']['error'], "error");
		redirect("index.php?view=add");
		return;
	}

	// Get image details
	$image_size = getimagesize($file);
	if ($image_size === false) {
		message("That's not an image!", "error");
		redirect("index.php?view=add");
		return;
	}

	// Prepare image for storage
	$image_name = basename($_FILES['image']['name']);
	$location = "rooms/" . time() . '_' . $image_name;

	// Move the uploaded file to the designated location
	if (!move_uploaded_file($_FILES["image"]["tmp_name"], $location)) {
		message("Failed to move uploaded file. Please try again.", "error");
		redirect("index.php?view=add");
		return;
	}

	// Validate input fields
	if (empty($_POST['name']) || empty($_POST['rmtype']) || empty($_POST['price'])) {
		message("All fields are required!", "error");
		redirect("index.php?view=add");
		return;
	}

	// Create Room object and set attributes
	$room = new Room();
	$room->typeID = $_POST['rmtype'];
	$room->roomName = $_POST['name'];
	$room->price = $_POST['price'];
	$room->Adults = $_POST['adult'];
	$room->Children = $_POST['children'];
	$room->roomImage = $location;

	// Check for existing room name
	if ($room->find_all_room($room->roomName) >= 1) {
		message("Room name already exists!", "error");
		redirect("index.php?view=add");
		return;
	}

	// Attempt to create the room in the database
	if ($room->create()) {
		message("New [" . htmlspecialchars($room->roomName) . "] created successfully!", "success");
		redirect('index.php');
	} else {
		message("Failed to create room. Please try again.", "error");
		redirect("index.php?view=add");
	}
}


//function to modify rooms

function doEdit()
{
	$room = new Room();
	$rm_no			= $_POST['rmNo'];
	$rm_name		= $_POST['name'];
	$rm_type	    = $_POST['rmtype'];
	$rm_price 		= $_POST['price'];
	$rm_adult 		= $_POST['adult'];
	$rm_children 	= $_POST['children'];

	$room->typeID = $rm_type;
	$room->roomName = $rm_name;
	$room->price = $rm_price;
	$room->Adults = $rm_adult;
	$room->Children = $rm_children;

	$room->update($rm_no);

	message("New [" . $rm_name . "] Upadated successfully!", "success");
	unset($_SESSION['id']);
	redirect('index.php');
}

function doDelete()
{
	@$id = $_POST['selector'];
	$key = count($id);
	//multi delete using checkbox as a selector

	for ($i = 0; $i < $key; $i++) {

		$rm = new Room();
		$rm->delete($id[$i]);
	}

	message("Room already Deleted!", "info");
	redirect('index.php');
}

//function to modify picture

function editImg()
{
	if (!isset($_FILES['image']['tmp_name'])) {
		message("No Image Selected!", "error");
		redirect("index.php?view=list");
	} else {
		$file = $_FILES['image']['tmp_name'];
		$image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
		$image_name = addslashes($_FILES['image']['name']);
		$image_size = getimagesize($_FILES['image']['tmp_name']);

		if ($image_size == FALSE) {
			message("That's not an image!");
			redirect("index.php?view=list");
		} else {


			$location = "rooms/" . $_FILES["image"]["name"];


			$rm = new Room();
			$rm_id		= $_POST['id'];

			move_uploaded_file($_FILES["image"]["tmp_name"], "rooms/" . $_FILES["image"]["name"]);

			$rm->roomImage = $location;
			$rm->update($rm_id);

			message("Room Image Upadated successfully!", "success");
			unset($_SESSION['id']);
			redirect("index.php");
		}
	}
}

function _deleteImage($catId)
{
	// we will return the status
	// whether the image deleted successfully
	$deleted = false;

	// get the image(s)
	$sql = "SELECT * 
            FROM room
            WHERE roomNo ";

	if (is_array($catId)) {
		$sql .= " IN (" . implode(',', $catId) . ")";
	} else {
		$sql .= " = {$catId}";
	}

	$result = dbQuery($sql);

	if (dbNumRows($result)) {
		while ($row = dbFetchAssoc($result)) {
			extract($row);
			// delete the image file
			$deleted = @unlink($roomImage);
		}
	}

	return $deleted;
}
