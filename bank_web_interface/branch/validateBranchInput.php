<?php

function isValidInput($inputs)
{
    global $errorMsg;
    $errorMsg = '';

    if ($inputs['branchName'] == "") {
        $errorMsg .= "branchName is required </br> ";
    }

    $managerSIN = $inputs['managerSIN'];
    if($managerSIN == ""){
        $errorMsg .= "A branch must have a manager </br>";
    }

    if ($managerSIN != "" && strlen($managerSIN) != 9) {
        $errorMsg .= "managerSIN must be in 9 digits </br>";
    }

    return $errorMsg == '' ? true : false;
}

function isManagerSINValid($error)
{
    global $errorMsg;
    $errorMsg = '';

    if ($error->getCode() == "23000") {
        $errorMsg .= "Invald Manager SIN </br>";
    }
}

function validateForeignContraint($error)
{
    global $errorMsg;
    $errorMsg = '';
    
    if (strpos($error->getMessage(), "foreign key constraint fails") !== false) {
        $errorMsg .= "Cannot delete branch with existing accounts </br>";
    }
}
