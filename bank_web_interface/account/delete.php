<?php

require "../../config.php";
require "../../common.php";

if (isset($_GET["id"])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $id = $_GET["id"];

        $sql = "DELETE FROM Account WHERE accNumber = :id";

        $statement = $connection->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();

        $success = "Account (id: $id) successfully deleted";
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}

try {
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT * FROM Account";

    $statement = $connection->prepare($sql);
    $statement->execute();

    $result = $statement->fetchAll();
} catch (PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
?>

<?php
    include "../templates/header.php";
    renderHeader("../css/style.css");
?>

<h3>Delete Account</h3>

<?php if (isset($success)) {
    echo $success;
} ?>

<table>
  <thead>
    <tr>
      <th>Account Number</th>
      <th>Account Type</th>
      <!-- <th>Balance ($CAD)</th> -->
      <th>Branch Number</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($result as $row) : ?>
    <tr>
      <td><?php echo escape($row["accNumber"]); ?></td>
      <td><?php echo escape($row["type"]); ?></td>
      <!-- <td><?php echo escape($row["balance"]); ?></td> -->
      <td><?php echo escape($row["branchNumber"]); ?></td>
      <td><a href="delete.php?id=<?php echo escape($row["accNumber"]); ?>">Delete</a></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<a href="../index.php">Back to home</a>

<?php require "../templates/footer.php"; ?>