<?php

function isValidInput($inputs)
{
    global $errorMsg;
    $errorMsg = '';

    $sin = $inputs['sin'];
    if ($sin == "") {
        $errorMsg .= "SIN is required </br> ";
    } elseif (!is_numeric($sin) || strlen($sin) != 9 || $sin < 0) {
        $errorMsg .= "SIN must be in 9 digits </br> ";
    }

    if ($inputs['firstName'] == "") {
        $errorMsg .= "firstName is required </br> ";
    }

    if ($inputs['lastName'] == "") {
        $errorMsg .= "lastName is required </br> ";
    }

    $branchNumber = $inputs['branchNumber'] == '' ? 0 : $inputs['branchNumber'];
    if (!is_numeric($branchNumber)) {
        $errorMsg .= "branchNumber must be in numeric </br>";
    }

    return $errorMsg == '' ? true : false;
}

function displayError($error)
{
    global $errorMsg;
    $errorMsg = '';

    if (preg_match('/Integrity constraint violation: 1452/', $error)) {
        $errorMsg .= "Invalid Branch Number </br>";
    }
}
