<?php

require "../../config.php";
require "../../common.php";
require "./validateTransactionInput.php";

static $errorMsg;
 
if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  if(isValidInput($_POST)){
    try {
      $connection = new PDO($dsn, $username, $password, $options);

      $transaction = 
      [
      "transNumber"    =>  $_POST['transNumber'],
      "accNumber"     =>  $_POST['accNumber'],
      "amount"        =>  $_POST['amount'] == 0 ? 0 : $_POST['amount']
      ];

      $sql = 
      "UPDATE Transactions
      SET 
      accNumber = :accNumber,
      amount = :amount
      WHERE transNumber = :transNumber";

      $statement = $connection->prepare($sql);
      $statement->execute($transaction);

    } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
      isManagerSINValid($error);
    }
  }
}

if (isset($_GET['id'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $id = $_GET['id'];

    $sql = "SELECT * FROM Transactions WHERE transNumber = :id";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();

    $transaction = $statement->fetch(PDO::FETCH_ASSOC);

  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
      isManagerSINValid($error);
  }
} else {
    echo "Something went wrong!";
    exit;
}

function renderInputType($key){
    if ($key == 'amount'){
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

<h3>Edit a transaction</h3>

<?php if (isset($_POST['submit']) && $errorMsg == '' && isset($statement)) { ?>
  Transaction successfully updated.
<?php } ?>

<?php if ($errorMsg != '') { ?>
	<?php echo "<div class='errorDiv'>" . $errorMsg . "</div>"?>
<?php } ?>

<form method="post">
  <?php foreach ($transaction as $key => $value) : ?>

    <label for="<?php echo $key; ?>">
        <?php echo ucfirst($key); ?>
    </label>

    <input
    type="<?php renderInputType($key) ?>"
    step="<?php if($key == 'amount') echo '0.01' ?>"
    name="<?php echo $key; ?>"
    id="<?php echo $key; ?>"
    value="<?php echo escape($value); ?>">
    <?php echo ($key === 'transNumber' ? '(read-only)' : null); ?>

  <?php endforeach; ?>

  <input type="submit" name="submit" value="Submit">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
</form>

<a href="../index.php">Back to home</a>

<?php require "../templates/footer.php"; ?>
