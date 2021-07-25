<?php

if (isset($_POST['submit'])) {
    try {
        require "../../config.php";
        require "../../common.php";

        $sin = $_POST['sin'];

        $connection = new PDO($dsn, $username, $password, $options);        

        $sql = "SELECT * FROM Employee WHERE sin = :sin";

        $statement = $connection->prepare($sql);
        $statement->bindParam(":sin", $sin, PDO::PARAM_STR);
        $statement->execute();

        $result = $statement->fetchAll();

    } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
    }
  }
?>

<?php 
    include "../templates/header.php"; 
    renderHeader("../css/style.css");
?>

<?php
if (isset($_POST['submit'])) {
  if ($result && $statement->rowCount() > 0) { ?>
    <h2>Results</h2>

    <table>
      <thead>
<tr>
  <th>SIN</th>
  <th>First Name</th>
  <th>Last Name</th>
  <th>Salary</th>
  <th>Branch Number</th>
</tr>
      </thead>
      <tbody>
  <?php foreach ($result as $row) { ?>
      <tr>
<td><?php echo escape($row["sin"]); ?></td>
<td><?php echo escape($row["firstName"]); ?></td>
<td><?php echo escape($row["lastName"]); ?></td>
<td><?php echo escape($row["salary"]); ?></td>
<td><?php echo escape($row["branchNumber"]); ?></td>
      </tr>
    <?php } ?>
      </tbody>
  </table>
  <?php } else { ?>
    > No results found for <?php echo escape($_POST['sin']); ?>.
  <?php }
} ?>

<h3>Find Employee based on SIN</h3>

<form method="post">
    <label for="sin">Employee SIN</label>
    <input type="text" id="sin" name="sin">
    <input type="submit" name="submit" value="View Results">
</form>

<a href="../index.php">Back to home</a>

<?php include "../templates/footer.php"; ?>