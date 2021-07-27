<?php

require "../../config.php";
require "../../common.php";

if (isset($_GET["id"])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $id = $_GET["id"];

        $sql = "DELETE FROM Employee WHERE sin = :sin";

        $statement = $connection->prepare($sql);
        $statement->bindValue(':sin', $id);
        $statement->execute();

        $success = "Employee (id: $id) successfully deleted";
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}

try {
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT * FROM Employee";

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

<h3>Delete Employee</h3>

<?php if (isset($success)) {
    echo $success;
} ?>

<table>
  <thead>
    <tr>
      <th>SIN</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Salary</th>
      <th>Branch Number</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($result as $row) : ?>
    <tr>
      <td><?php echo escape($row["sin"]); ?></td>
      <td><?php echo escape($row["firstName"]); ?></td>
      <td><?php echo escape($row["lastName"]); ?></td>
      <td><?php echo escape($row["salary"]); ?></td>
      <td><?php echo escape($row["branchNumber"]); ?></td>
      <td><a href="delete.php?id=<?php echo escape($row["sin"]); ?>">Delete</a></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<a href="../index.php">Back to home</a>

<?php require "../templates/footer.php"; ?>