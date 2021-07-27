<?php

require "../../config.php";
require "../../common.php";
require "./validateEmployeeInput.php";

static $errorMsg;

if (isset($_POST['submit'])) {
    if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
        die();
    }

    if (isValidInput($_POST)) {
        try {
            $connection = new PDO($dsn, $username, $password, $options);
    
            $new_employee = array(
                "sin" => $_POST['sin'],
                "firstName" => $_POST['firstName'],
                "lastName" => $_POST['lastName'],
                "salary" => $_POST['salary'],
                "branchNumber" => $_POST['branchNumber']
            );
            
            if ($_POST['salary'] == '') {
                unset($new_employee['salary']);
            }
    
            if ($_POST['branchNumber'] == '') {
                unset($new_employee['branchNumber']);
            }
        
            $sql = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "Employee",
                implode(", ", array_keys($new_employee)),
                ":" . implode(", :", array_keys($new_employee))
            );
    
            $statement = $connection->prepare($sql);
            $statement->execute($new_employee);
        } catch (PDOException $error) {
            // echo $sql . "<br>" . $error->getMessage();
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
  <?php echo escape($_POST['firstName']); ?> successfully added.
<?php } ?>

<?php if ($errorMsg != '') { ?>
	<?php echo "<div class='errorDiv'>" . $errorMsg . "</div>"?>
<?php } ?>

<h3>Add a employee</h3>

<form method="post">
    	<label for="sin">SIN</label>
    	<input type="number" name="sin" id="sin">
    	<label for="firstName">First Name</label>
    	<input type="text" name="firstName" id="firstName">
    	<label for="lastName">Last Name</label>
    	<input type="text" name="lastName" id="lastName">
    	<label for="salary">Salary</label>
    	<input type="number" step="0.01" name="salary" id="salary">
    	<label for="branchNumber">Branch number</label>
    	<input type="number" name="branchNumber" id="branchNumber">
    	<input type="submit" name="submit" value="Submit">
		<input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
</form>

<a href="../index.php">Back to home</a>

<?php include "../templates/footer.php"; ?>