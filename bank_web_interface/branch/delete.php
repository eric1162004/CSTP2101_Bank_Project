<?php

require "../../config.php";
require "../../common.php";

if (isset($_GET["id"])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $id = $_GET["id"];

        $sql = "DELETE FROM Branch WHERE branchNumber = :id";

        $statement = $connection->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();

        $success = "Branch (id: $id) successfully deleted";
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}

try {
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT * FROM Branch";

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

<h3>Delete Branch</h3>

<?php if (isset($success)) {
    echo $success;
} ?>

<table>
  <thead>
    <tr>
      <th>#</th>
      <th>Branch Number</th>
      <th>Branch Name</th>
      <th>Manager SIN</th>
      <th>Budget</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($result as $row) : ?>
    <tr>
      <td><?php echo escape($row["branchNumber"]); ?></td>
      <td><?php echo escape($row["branchName"]); ?></td>
      <td><?php echo escape($row["managerSIN"]); ?></td>
      <td><?php echo escape($row["budget"]); ?></td>
      <td><a href="delete.php?id=<?php echo escape($row["branchNumber"]); ?>">Delete</a></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<a href="../index.php">Back to home</a>

<?php require "../templates/footer.php"; ?>