<?php

require "../../config.php";
require "../../common.php";
require "./validateBranchInput.php";

static $errorMsg;
 
if (isset($_POST['submit'])) {
    if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
        die();
    }

    if (isValidInput($_POST)) {
        try {
            $connection = new PDO($dsn, $username, $password, $options);

            $branch = $_POST['managerSIN'] == '' ?
      [
        "branchNumber"    =>  $_POST['branchNumber'],
        "branchName"     =>  $_POST['branchName'],
        "budget"        =>  $_POST['budget'] == 0 ? 0 : $_POST['budget']
      ]:
      [
        "branchNumber"    =>  $_POST['branchNumber'],
        "branchName"     =>  $_POST['branchName'],
        "managerSIN"      =>  $_POST['managerSIN'],
        "budget"        =>  $_POST['budget'] == 0 ? 0 : $_POST['budget']
      ];

            $sql = $_POST['managerSIN'] == '' ?
    "UPDATE Branch
    SET 
    branchName = :branchName,
    budget = :budget
    WHERE branchNumber = :branchNumber":
    "UPDATE Branch
    SET 
    branchName = :branchName,
    managerSIN = :managerSIN,
    budget = :budget
    WHERE branchNumber = :branchNumber";

            $statement = $connection->prepare($sql);
            $statement->execute($branch);
        } catch (PDOException $error) {
            echo $sql . "<br>" . $error->getMessage();
            isManagerSINValid($error);
        }
    }
}

if (isset($_GET['id'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);
        $id = $_GET['id'];

        $sql = "SELECT * FROM Branch WHERE branchNumber = :id";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();

        $branch = $statement->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
        isManagerSINValid($error);
    }
} else {
    echo "Something went wrong!";
    exit;
}

function renderInputType($key)
{
    if ($key == 'budget') {
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

<h3>Edit a branch</h3>

<?php if (isset($_POST['submit']) && $errorMsg == '' && isset($statement)) { ?>
  <?php echo escape($_POST['branchName']); ?> successfully updated.
<?php } ?>

<?php if ($errorMsg != '') { ?>
	<?php echo "<div class='errorDiv'>" . $errorMsg . "</div>"?>
<?php } ?>

<form method="post">
  <?php foreach ($branch as $key => $value) : ?>

    <label for="<?php echo $key; ?>">
        <?php echo ucfirst($key); ?>
    </label>

    <input
    type="<?php renderInputType($key) ?>"
    step="<?php if ($key == 'budget') {
    echo '0.01';
} ?>"
    name="<?php echo $key; ?>"
    id="<?php echo $key; ?>"
    value="<?php echo escape($value); ?>">
    <?php echo($key === 'branchNumber' ? '(read-only)' : null); ?>

  <?php endforeach; ?>

  <input type="submit" name="submit" value="Submit">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
</form>

<a href="../index.php">Back to home</a>

<?php require "../templates/footer.php"; ?>
