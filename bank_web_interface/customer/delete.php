<?php

require "../../config.php";
require "../../common.php";

if (isset($_GET["id"])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $id = $_GET["id"];

    $sql = "DELETE FROM Customer WHERE customerID = :id";

    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();

    $success = "Customer (id: $id) successfully deleted";

  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}

try {
  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT * FROM Customer";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>

<?php 
    include "../templates/header.php"; 
    renderHeader("../css/style.css");
?>

<h3>Delete Customer</h3>

<?php if (isset($success)) echo $success; ?>

<table>
  <thead>
    <tr>
      <th>#</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Income</th>
      <th>Birth Date</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($result as $row) : ?>
    <tr>
      <td><?php echo escape($row["customerID"]); ?></td>
      <td><?php echo escape($row["firstName"]); ?></td>
      <td><?php echo escape($row["lastName"]); ?></td>
      <td><?php echo escape($row["income"]); ?></td>
      <td><?php echo escape($row["birthDate"]); ?></td>
      <td><a href="delete.php?id=<?php echo escape($row["customerID"]); ?>">Delete</a></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<a href="../index.php">Back to home</a>

<?php require "../templates/footer.php"; ?>