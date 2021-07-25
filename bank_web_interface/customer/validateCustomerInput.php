<?php

function isValidInput($inputs){
	global $errorMsg;
	$errorMsg = '';

	if($inputs['firstName'] == ""){
		$errorMsg .= "firstName is required </br> ";
	}
	
	if($inputs['lastName'] == ""){
		$errorMsg .= "lastName is required </br> ";
	}

	return $errorMsg == '' ? true : false;
}

?>