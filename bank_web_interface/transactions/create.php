<?php

require "../../config.php";
require "../../common.php";
require "./validateTransactionInput.php";

static $errorMsg;

if (isset($_POST['submit'])) {
    if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
        die();
    }

    if (isValidInput($_POST)) {
        try {
            $connection = new PDO($dsn, $username, $password, $options);
    
            $new_transaction = array(
                "accNumber" => $_POST['accNumber'],
                "amount" => $_POST['amount']
            );
    
            if ($_POST['amount'] == '') {
                unset($new_transaction['amount']);
            }
        
            $sql = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "Transactions",
                implode(", ", array_keys($new_transaction)),
                ":" . implode(", :", array_keys($new_transaction))
            );
    
            $statement = $connection->prepare($sql);
            $statement->execute($new_transaction);
            $new_transNumber = $connection->lastInsertId();
        } catch (PDOException $error) {
            echo $sql . "<br>" . $error->getMessage();
            isaccNumberValid($error);
        }
    }
}
?>

<?php
    include "../templates/header.php";
    renderHeader("../css/style.css");
?>

<?php if (isset($_POST['submit']) && $errorMsg == '' && isset($statement)) { ?>
  Transaction #<?php echo $new_transNumber; ?> successfully added.
<?php } ?>

<?php if ($errorMsg != '') { ?>
	<?php echo "<div class='errorDiv'>" . $errorMsg . "</div>"?>
<?php } ?>

<h3>Add a transaction</h3>

<form method="post">
    	<label for="accNumber">Account Number:</label>
    	<input type="number"  name="accNumber" id="accNumber">
    	<label for="amount">Amount amount($CAD)</label>
    	<input type="number" step="0.01" name="amount" id="amount">
    	<input type="submit" name="submit" value="Submit">
		<input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
</form>

<a href="../index.php">Back to home</a>

<?php include "../templates/footer.php"; ?>