<?php

function isValidInput($inputs)
{
    global $errorMsg;
    $errorMsg = '';

    if ($inputs['firstName'] == "") {
        $errorMsg .= "firstName is required </br> ";
    }
    
    if ($inputs['lastName'] == "") {
        $errorMsg .= "lastName is required </br> ";
    }

    return $errorMsg == '' ? true : false;
}

function displayError($error)
{
    global $errorMsg;
    $errorMsg = '';

    if (strpos($error->getMessage(), "foreign key constraint fails") !== false) {
        $errorMsg .= "Cannot delete a customer who has existing account(s)</br>";
    }
}

