<?php

require "../../config.php";
require "../../common.php";
require "./validateBranchInput.php";

static $errorMsg;

if (isset($_POST['submit'])){
	
	if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

	if(isValidInput($_POST)){
		try{
			$connection = new PDO($dsn, $username, $password, $options);
	
			$new_branch = array(
				"branchName" => $_POST['branchName'],
				"managerSIN" => $_POST['managerSIN'],
				"budget" => $_POST['budget']
			);
			
			if ($_POST['managerSIN'] == ''){
				unset($new_branch['managerSIN']);
			}
	
			if ($_POST['budget'] == ''){
				unset($new_branch['budget']);
			}
		
			$sql = sprintf(
				"INSERT INTO %s (%s) values (%s)",
				"Branch",
				implode(", ", array_keys($new_branch)),
				":" . implode(", :", array_keys($new_branch))
			);
	
			$statement = $connection->prepare($sql);
			$statement->execute($new_branch);
	
		} catch(PDOException $error){
			// echo $sql . "<br>" . $error->getMessage();
            isManagerSINValid($error);
		}
	}
}
?>

<?php 
    include "../templates/header.php"; 
    renderHeader("../css/style.css");
?>

<?php if (isset($_POST['submit']) && $errorMsg == '' && isset($statement)) { ?>
  <?php echo escape($_POST['branchName']); ?> successfully added.
<?php } ?>

<?php if ($errorMsg != '') { ?>
	<?php echo "<div class='errorDiv'>" . $errorMsg . "</div>"?>
<?php } ?>

<h3>Add a branch</h3>

<form method="post">
    	<label for="branchName">Branch Name</label>
    	<input type="text" name="branchName" id="branchName">
    	<label for="managerSIN">Branch Manager SIN</label>
    	<input type="text" name="managerSIN" id="managerSIN">
    	<label for="budget">Branch Budget</label>
    	<input type="number" step="0.01" name="budget" id="budget">
    	<input type="submit" name="submit" value="Submit">
		<input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
</form>

<a href="../index.php">Back to home</a>

<?php include "../templates/footer.php"; ?>