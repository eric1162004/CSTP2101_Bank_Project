<?php

function isValidInput($inputs){
    global $dsn;
    global $username;
    global $password;
    global $options;
	global $errorMsg;
	$errorMsg = '';

	if($inputs['customerID1'] == "" && $inputs['customerID2'] == "" ){
		$errorMsg .= "At least 1 account owner is required </br> ";
	} else {
        if($inputs['customerID1'] != ""){
            validCustomer($inputs['customerID1']);
        }
        if($inputs['customerID2'] != ""){
            validCustomer($inputs['customerID2']);
        }
    }

    // Check if user has enter the same customer id twice
    if($inputs['customerID1'] == $inputs['customerID2']){
		$errorMsg .= "Duplicated account owner IDs </br> ";
    }

    if($inputs['branchNumber'] != ""){
        try{
            $connection = new PDO($dsn, $username, $password, $options);
        
            $sql = "SELECT * FROM Branch WHERE branchNumber=:branchNumber";
    
            $statement = $connection->prepare($sql);
            $statement->bindParam(":branchNumber", $inputs['branchNumber'], PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            if(!$result){
                $errorMsg .= "Branch Number does not exist</br>";
            }
    
        } catch(PDOException $error){
            echo $sql . "<br>" . $error->getMessage();
        }
    }

	return $errorMsg == '' ? true : false;
}

function validCustomer($customerID){
    global $dsn;
    global $username;
    global $password;
    global $options;
	global $errorMsg;

    try{
        $connection = new PDO($dsn, $username, $password, $options);
    
        $sql = "SELECT * FROM Customer WHERE customerID=:customerID";

        $statement = $connection->prepare($sql);
        $statement->bindParam(":customerID", $customerID, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if(!$result){
            $errorMsg .= "Customer ID $customerID does not exist </br>";
        }

    } catch(PDOException $error){
        echo $sql . "<br>" . $error->getMessage();
    }
}

function displayError($error){
	global $errorMsg;
	$errorMsg = '';

    if($error->getCode() == "23000"){
        $errorMsg .= "Invald Account Number</br>";
    } 
}

?>