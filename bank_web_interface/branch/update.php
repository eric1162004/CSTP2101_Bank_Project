<?php

try {
    require "../../config.php";
    require "../../common.php";

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

<h3>Update Branchs</h3>

<table>
  <thead>
    <tr>
        <th>#</th>
        <th>Branch Name</th>
        <th>Manager SIN</th>
        <th>Budget</th>
        <th>Update</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($result as $row) : ?>
    <tr>
      <td><?php echo escape($row["branchNumber"]); ?></td>
      <td><?php echo escape($row["branchName"]); ?></td>
      <td><?php echo escape($row["managerSIN"]); ?></td>
      <td><?php echo escape($row["budget"]); ?></td>
      <td><a href="update-single.php?id=<?php echo escape($row["branchNumber"]); ?>">Update</a></td>
  </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<a href="../index.php">Back to home</a>