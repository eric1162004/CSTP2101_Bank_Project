<?php

require "../../config.php";
require "../../common.php";
require "./validateAccountInput.php";

static $errorMsg;

if (isset($_POST['submit'])){
	
	if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

	if(isValidInput($_POST)){
		try{
			$connection = new PDO($dsn, $username, $password, $options);
	
			$new_account = array(
				"type" => $_POST['type'],
				"balance" => $_POST['balance'],
				"branchNumber" => $_POST['branchNumber']
			);
			
			if ($_POST['balance'] == ''){
				unset($new_account['balance']);
			}
	
			if ($_POST['branchNumber'] == ''){
				unset($new_account['branchNumber']);
			}
		
			$sql = sprintf(
				"INSERT INTO %s (%s) values (%s)",
				"Account",
				implode(", ", array_keys($new_account)),
				":" . implode(", :", array_keys($new_account))
			);
			$statement = $connection->prepare($sql);
			$statement->execute($new_account);
            $new_accNumber = $connection->lastInsertId();
            
            // insert a record into the Owns table
			if(isset($_POST['customerID1'])){
				$sql2 = sprintf(
					"INSERT INTO Owns values (%s,%s)",
					$_POST['customerID1'],
					$new_accNumber 
				);
				$statement = $connection->prepare($sql2);
				$statement->execute($new_account);
			}

			if(isset($_POST['customerID2'])){
				$sql2 = sprintf(
					"INSERT INTO Owns values (%s,%s)",
					$_POST['customerID2'],
					$new_accNumber 
				);
				$statement = $connection->prepare($sql2);
				$statement->execute($new_account);
			}
	
		} catch(PDOException $error){
			echo $sql . "<br>" . $error->getMessage();
            displayError($error);
		}
	}
}
?>

<?php 
    include "../templates/header.php"; 
    renderHeader("../css/style.css");
?>

<?php if (isset($_POST['submit']) && $errorMsg == '' && isset($statement)) { ?>
  <?php echo escape($_POST['type']); ?> successfully added.
<?php } ?>

<?php if ($errorMsg != '') { ?>
	<?php echo "<div class='errorDiv'>" . $errorMsg . "</div>"?>
<?php } ?>

<h3>Add an account</h3>

<form method="post">
        <label for="type">Account Type</label>
        <select name="type" id="type">
            <option value="chequing">chequing</option>
            <option value="saving">saving</option>
            <option value="business">business</option>
        </select>
    	<label for="balance">Balance</label>
    	<input type="number" step="0.01" name="balance" id="balance">
        <label for="branchNumber">Branch Number</label>
    	<input type="number" name="branchNumber" id="branchNumber">
		<label for="customerID1">Account Owner 1 (Enter Customer ID):</label>
        <input type="number" name="customerID1" id="customerID1">
        <label for="customerID2">Account Owner 2 (Enter Customer ID):</label>
        <input type="number" name="customerID2" id="customerID2">
    	<input type="submit" name="submit" value="Submit">
		<input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
</form>

<a href="../index.php">Back to home</a>

<?php include "../templates/footer.php"; ?>