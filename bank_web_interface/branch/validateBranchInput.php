<?php

function isValidInput($inputs){
	global $errorMsg;
	$errorMsg = '';

	if($inputs['branchName'] == ""){
		$errorMsg .= "branchName is required </br> ";
	}

    $managerSIN = $inputs['managerSIN'];
	if($managerSIN != "" && strlen($managerSIN) != 9){
		$errorMsg .= "managerSIN must be in 9 digits </br>";
	}

	return $errorMsg == '' ? true : false;
}

function isManagerSINValid($error){
	global $errorMsg;
	$errorMsg = '';

    if($error->getCode() == "23000"){
        $errorMsg .= "Invald Manager SIN </br>";
    } 
}

?>