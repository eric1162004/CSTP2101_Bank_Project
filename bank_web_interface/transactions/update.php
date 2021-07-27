<?php

try {
    require "../../config.php";
    require "../../common.php";

    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT * FROM Transactions";

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

<h3>Update Transactions</h3>

<table>
  <thead>
    <tr>
        <th>Transaction Number</th>
        <th>Account Number</th>
        <th>Amount</th>
        <th>Update</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($result as $row) : ?>
    <tr>
      <td><?php echo escape($row["transNumber"]); ?></td>
      <td><?php echo escape($row["accNumber"]); ?></td>
      <td><?php echo escape($row["amount"]); ?></td>
      <td><a href="update-single.php?id=<?php echo escape($row["transNumber"]); ?>">Update</a></td>
  </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<a href="../index.php">Back to home</a>