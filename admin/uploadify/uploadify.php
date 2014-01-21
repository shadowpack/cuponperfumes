<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/

// Define a destination
include_once('../model/db_core.php');
$targetFolder = '/cuponperfumes/images/product'; // Relative to the root
$db = new db_core();
$verifyToken = md5('unique_salt' . $_POST['timestamp']);

if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
	$in['id_item'] = $_POST['product'];
	$in['source'] = 'images/product/'.$_FILES['Filedata']['name'];
	$in['portrait'] = 0;
	$db->insert('imagenes_productos', $in);
	$targetFile = rtrim($targetPath,'/') . '/' . $_FILES['Filedata']['name'];
	
	// Validate the file type
	$fileTypes = array('jpg','jpeg','gif','png'); // File extensions
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	
	if (in_array($fileParts['extension'],$fileTypes)) {
		move_uploaded_file($tempFile,$targetFile);
		$out['src'] = $in['source'];
		$out['id_image'] = $db->last_id();
		$out['id_item'] = $_POST['product'];
		echo json_encode($out);
	} else {
		echo 'Invalid file type.';
	}
}
?>