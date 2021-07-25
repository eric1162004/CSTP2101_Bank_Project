<?php

require "../../config.php";
require "../../common.php";
require "./validateEmployeeInput.php";

static $errorMsg;
 
if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  if(isValidInput($_POST)){
    try {
      $connection = new PDO($dsn, $username, $password, $options);

      $employee =[
        "sin"    =>  $_POST['sin'],
        "firstName"     =>  $_POST['firstName'],
        "lastName"      =>  $_POST['lastName'],
        "salary"        =>  $_POST['salary'] == 0 ? 0 : $_POST['salary'],
        "branchNumber"     =>  $_POST['branchNumber']
      ];

      $sql = $_POST['branchNumber'] == '' ? 
      "UPDATE Employee
      SET 
        firstName = :firstName,
        lastName = :lastName,
        salary = :salary
      WHERE sin = :sin":
      "UPDATE Employee
      SET 
        firstName = :firstName,
        lastName = :lastName,
        salary = :salary,
        branchNumber = :branchNumber
      WHERE sin = :sin";

    $statement = $connection->prepare($sql);
    $statement->execute($employee);

    } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
    }
  }
}

if (isset($_GET['id'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $sin = $_GET['id'];

    $sql = "SELECT * FROM Employee WHERE sin = :sin";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':sin', $sin);
    $statement->execute();

    $employee = $statement->fetch(PDO::FETCH_ASSOC);

  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
} else {
    echo "Something went wrong!";
    exit;
}

function renderInputType($key){
  if ($key == 'sin' || $key == 'salary' || $key == 'branchNumber'){
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

<h3>Edit a employee</h3>

<?php if (isset($_POST['submit']) && $errorMsg == '' && isset($statement)) { ?>
  <?php echo escape($_POST['firstName']); ?> successfully updated.
<?php } ?>

<?php if ($errorMsg != '') { ?>
	<?php echo "<div class='errorDiv'>" . $errorMsg . "</div>"?>
<?php } ?>

<form method="post">
  <?php foreach ($employee as $key => $value) : ?>

    <label for="<?php echo $key; ?>">
        <?php echo ucfirst($key); ?>
    </label>

    <input
    type="<?php renderInputType($key) ?>"
    step="<?php if($key == 'salary') echo '0.01' ?>"
    name="<?php echo $key; ?>"
    id="<?php echo $key; ?>"
    value="<?php echo escape($value); ?>">
    <?php echo ($key === 'sin' ? '(read-only)' : null); ?>

  <?php endforeach; ?>

  <input type="submit" name="submit" value="Submit">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
</form>

<a href="../index.php">Back to home</a>

<?php require "../templates/footer.php"; ?>
