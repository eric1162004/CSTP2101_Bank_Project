<?php

function isValidInput($inputs)
{
    global $dsn;
    global $username;
    global $password;
    global $options;
    global $errorMsg;
    $errorMsg = '';

    if ($inputs['accNumber'] == "") {
        $errorMsg .= "An Account Number is required </br> ";
    } else {
        try {
            $connection = new PDO($dsn, $username, $password, $options);
        
            $sql = "SELECT * FROM Account WHERE accNumber=:accNumber";
    
            $statement = $connection->prepare($sql);
            $statement->bindParam(":accNumber", $inputs['accNumber'], PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            if (!$result) {
                $errorMsg .= "Invalid account number</br>";
            }
        } catch (PDOException $error) {
            echo $sql . "<br>" . $error->getMessage();
        }
    }

    return $errorMsg == '' ? true : false;
}

function isaccNumberValid($error)
{
    global $errorMsg;
    $errorMsg = '';

    if ($error->getCode() == "23000") {
        $errorMsg .= "Invald account number </br>";
    }
}
