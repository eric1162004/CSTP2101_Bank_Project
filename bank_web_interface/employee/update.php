<?php

try {
  require "../../config.php";
  require "../../common.php";

  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT * FROM Employee";

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

<h3>Update Employees</h3>

<table>
  <thead>
    <tr>
      <th>SIN</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Salary</th>
      <th>Branch Number</th>
      <th>Update</th>
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
      <td><a href="update-single.php?id=<?php echo escape($row["sin"]); ?>">Update</a></td>
  </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<a href="../index.php">Back to home</a>