<?php

require "../../config.php";
require "../../common.php";
require "./validateAccountInput.php";

static $errorMsg;
 
if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  if(isValidInput($_POST)){
    try {
      $connection = new PDO($dsn, $username, $password, $options);

      $branch = $_POST['branchNumber'] == '' ?       
      [
      "accNumber"    =>  $_POST['accNumber'],
      "type"     =>  $_POST['type'],
      "balance"        =>  $_POST['balance'] == 0 ? 0 : $_POST['balance']
      ]:
      [
      "accNumber"    =>  $_POST['accNumber'],
      "type"     =>  $_POST['type'],
      "branchNumber"      =>  $_POST['branchNumber'],
      "balance"        =>  $_POST['balance'] == 0 ? 0 : $_POST['balance']
      ];

      $sql = $_POST['branchNumber'] == '' ?
      "UPDATE Account
      SET 
      type = :type,
      balance = :balance
      WHERE accNumber = :accNumber":
      "UPDATE Account
      SET 
      type = :type,
      branchNumber = :branchNumber,
      balance = :balance
      WHERE accNumber = :accNumber";

      $statement = $connection->prepare($sql);
      $statement->execute($branch);

      // Delete all entries in Owns related to the accNumber
      $sql = "DELETE FROM Owns WHERE accNumber = :accNumber";
      $statement = $connection->prepare($sql);
      $statement->bindParam(":accNumber", $_POST['accNumber'], PDO::PARAM_STR);
      $statement->execute();

      // Add back the account owners
      if($_POST["customerID1"] != ''){
        $sql = sprintf(
					"INSERT INTO Owns values (%s,%s)",
					$_POST['customerID1'],
					$_POST['accNumber']
				);
				$statement = $connection->prepare($sql);
				$statement->execute();
      }
      
      if($_POST["customerID2"] != ''){
        $sql = sprintf(
					"INSERT INTO Owns values (%s,%s)",
					$_POST['customerID2'],
					$_POST['accNumber']
				);
				$statement = $connection->prepare($sql);
				$statement->execute();
      }

    } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
      isbranchNumberValid($error);
    }
  }
}

if (isset($_GET['id'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $id = $_GET['id'];

    $sql = "SELECT * FROM Account WHERE accNumber = :id";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();

    $account = $statement->fetch(PDO::FETCH_ASSOC);

    // Get Customer ID from Owns Table
    $sql = "SELECT * FROM Owns WHERE accNumber = :id";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();

    $accountOwners = $statement->fetchAll(PDO::FETCH_ASSOC);
    if($accountOwners){
      if(isset($accountOwners[0])){
        $customerID1 = $accountOwners[0]["customerID"];
      }
      if(isset($accountOwners[1])){
        $customerID2 = $accountOwners[1]["customerID"];
      }
    }

  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
      displayError($error);
  }
} else {
    echo "Something went wrong!";
    exit;
}

function renderInputType($key){
    if ($key == 'accNumber' || $key == 'balance' || $key == 'branchNumber'){
      echo "number";
  } else {
      echo 'text';
  }
}

?>

<?php 
    include "../templates/header.php"; 
    renderHeader("../css/style.css");
?>

<h3>Edit an account</h3>

<?php if (isset($_POST['submit']) && $errorMsg == '' && isset($statement)) { ?>
  Account Number: <?php echo escape($_POST['accNumber']); ?> successfully updated.
<?php } ?>

<?php if ($errorMsg != '') { ?>
	<?php echo "<div class='errorDiv'>" . $errorMsg . "</div>"?>
<?php } ?>

<form method="post">
  <?php foreach ($account as $key => $value) : ?>

    <?php if ($key != "type"): ?>

    <label for="<?php echo $key; ?>">
        <?php echo ucfirst($key); ?>
    </label>

    <input
    type="<?php renderInputType($key) ?>"
    step="<?php if($key == 'balance') echo '0.01' ?>"
    name="<?php echo $key; ?>"
    id="<?php echo $key; ?>"
    value="<?php echo escape($value); ?>">
    <?php echo ($key === 'accNumber' ? '(read-only)' : null); ?>

    <?php else: ?>

    <label for="type">Account Type</label>
    <select name="type" id="type">
        <option value="chequing">chequing</option>
        <option value="saving">saving</option>
        <option value="business">business</option>
    </select>

    <?php endif; ?>

  <?php endforeach; ?>
    
    <label for="customerID1">Account Owner 1 (Enter Customer ID):</label>
    <input 
    type="number" 
    name="customerID1" 
    id="customerID1" 
    value="<?php echo $customerID1 != 0 ? escape($customerID1) : ''; ?>"
    >
    <label for="customerID2">Account Owner 2 (Enter Customer ID):</label>
    <input 
    type="number" 
    name="customerID2" 
    id="customerID2" 
    value="<?php echo $customerID2 != 0 ? escape($customerID2) : ''; ?>"
    >

  <input type="submit" name="submit" value="Submit">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
</form>

<a href="../index.php">Back to home</a>

<?php require "../templates/footer.php"; ?>
