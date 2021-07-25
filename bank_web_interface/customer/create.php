<?php

require "../../config.php";
require "../../common.php";
require "./validateCustomerInput.php";

static $errorMsg;

if (isset($_POST['submit'])){
	
	if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

	if(isValidInput($_POST)){
		try{
			$connection = new PDO($dsn, $username, $password, $options);
	
			$new_customer = array(
				"firstName" => $_POST['firstName'],
				"lastName" => $_POST['lastName'],
				"income" => $_POST['income'],
				"birthDate" => $_POST['birthDate']
			);
			
			if ($_POST['income'] == ''){
				unset($new_customer['income']);
			}
	
			if ($_POST['birthDate'] == ''){
				unset($new_customer['birthDate']);
			}
		
			$sql = sprintf(
				"INSERT INTO %s (%s) values (%s)",
				"Customer",
				implode(", ", array_keys($new_customer)),
				":" . implode(", :", array_keys($new_customer))
			);
	
			$statement = $connection->prepare($sql);
			$statement->execute($new_customer);
	
		} catch(PDOException $error){
			echo $sql . "<br>" . $error->getMessage();
			
		}
	}
}
?>

<?php 
    include "../templates/header.php"; 
    renderHeader("../css/style.css");
?>

<?php if (isset($_POST['submit']) && $errorMsg == '' && isset($statement)) { ?>
  <?php echo escape($_POST['firstName']); ?> successfully added.
<?php } ?>

<?php if ($errorMsg != '') { ?>
	<?php echo "<div class='errorDiv'>" . $errorMsg . "</div>"?>
<?php } ?>

<h3>Add a customer</h3>

<form method="post">
    	<label for="firstName">First Name</label>
    	<input type="text" name="firstName" id="firstName">
    	<label for="lastName">Last Name</label>
    	<input type="text" name="lastName" id="lastName">
    	<label for="income">Income</label>
    	<input type="number" step="0.01" name="income" id="income">
    	<label for="birthDate">Birth Date</label>
    	<input type="date" name="birthDate" id="birthDate">
    	<input type="submit" name="submit" value="Submit">
		<input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
</form>

<a href="../index.php">Back to home</a>

<?php include "../templates/footer.php"; ?>