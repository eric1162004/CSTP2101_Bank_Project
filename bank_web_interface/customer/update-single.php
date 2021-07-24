<?php

require "../../config.php";
require "../../common.php";

function renderInputType($key){
    if($key == 'birthDate'){
        echo 'date';
    } else if ($key == 'income'){
        echo "number";
    } else {
        echo 'text';
    }
}

if (isset($_POST['submit'])) {
    try {
      $connection = new PDO($dsn, $username, $password, $options);

      $customer =[
        "customerID"    =>  $_POST['customerID'],
        "firstName"     =>  $_POST['firstName'],
        "lastName"      =>  $_POST['lastName'],
        "income"        =>  $_POST['income'],
        "birthDate"     =>  $_POST['birthDate']
      ];

      $sql = "UPDATE Customer
      SET 
        firstName = :firstName,
        lastName = :lastName,
        income = :income,
        birthDate = :birthDate
      WHERE customerID = :customerID";

    $statement = $connection->prepare($sql);
    $statement->execute($customer);

    } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
    }
}

if (isset($_GET['id'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $id = $_GET['id'];

    $sql = "SELECT * FROM Customer WHERE customerID = :id";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();

    $customer = $statement->fetch(PDO::FETCH_ASSOC);

  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
} else {
    echo "Something went wrong!";
    exit;
}
?>

<?php 
    include "../templates/header.php"; 
    renderHeader("../css/style.css");
?>

<h3>Edit a customer</h3>

<form method="post">
  <?php foreach ($customer as $key => $value) : ?>

    <label for="<?php echo $key; ?>">
        <?php echo ucfirst($key); ?>
    </label>

    <input
    type="<?php renderInputType($key) ?>"
    step="<?php if($key == 'income') echo '0.01' ?>"
    name="<?php echo $key; ?>"
    id="<?php echo $key; ?>"
    value="<?php echo escape($value); ?>">
    <?php echo ($key === 'customerID' ? '(read-only)' : null); ?>

  <?php endforeach; ?>

  <input type="submit" name="submit" value="Submit">
</form>

<a href="../index.php">Back to home</a>

<?php require "../templates/footer.php"; ?>
