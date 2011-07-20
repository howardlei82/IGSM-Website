<?php
@session_start();
if(!isset($_SESSION['arjunaAdminPanels']))
	$_SESSION['arjunaAdminPanels'] = array();

$_SESSION['arjunaAdminPanels'][$_GET['ID']] = (bool)$_GET['set'];

print '1';
?>