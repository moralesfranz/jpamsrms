<?php
require_once("../../includes/initialize.php");

if (!isset($_SESSION['justadmin_ID'])) {
	redirect(WEB_ROOT . "admin/login.php");
}

$thisFile = str_replace('\\', '/', __FILE__);
$docRoot = $_SERVER['DOCUMENT_ROOT'];

$webRoot  = str_replace(array($docRoot, 'config/config.php'), '', $thisFile);
$srvRoot  = str_replace('config/config.php', '', $thisFile);

// Check if WEB_ROOT and SRV_ROOT are already defined
if (!defined('WEB_ROOT')) {
	define('WEB_ROOT', $webRoot);
}

if (!defined('SRV_ROOT')) {
	define('SRV_ROOT', $srvRoot);
}

$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';

switch ($view) {
	case 'list':
		$content    = 'list.php';
		break;
	case 'add':
		$content    = 'add.php';
		break;
	case 'edit':
		$content    = 'edit.php';
		break;
	case 'view':
		$content    = 'view.php';
		break;
	default:
		$content    = 'list.php';
}

define('ADMIN_INDEX_PATH', $_SERVER['SERVER_NAME']);
define('SEP', DIRECTORY_SEPARATOR);


include '../modal.php';
require_once '../themes/backendTemplate.php';
