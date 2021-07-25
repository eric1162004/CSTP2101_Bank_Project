<?php

if (isset($_POST['submit'])) {
    try {
        require "../../config.php";
        require "../../common.php";

        $customerID = $_POST['customerID'];

        $connection = new PDO($dsn, $username, $password, $options);        

        $sql = "SELECT * FROM Customer WHERE customerID = :customerID";

        $statement = $connection->prepare($sql);
        $statement->bindParam(":customerID", $customerID, PDO::PARAM_STR);
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
      <h3>Results</h3>
      <table>
      <thead>
      <tr>
      <th>#</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Income</th>
      <th>Birth date</th>
      </tr>
      </thead>
      <tbody>
      <?php foreach ($result as $row) { ?>
      <tr>
      <td><?php echo escape($row["customerID"]); ?></td>
      <td><?php echo escape($row["firstName"]); ?></td>
      <td><?php echo escape($row["lastName"]); ?></td>
      <td><?php echo escape($row["income"]); ?></td>
      <td><?php echo escape($row["birthDate"]); ?></td>
      </tr>
      <?php } ?>
      </tbody>
      </table>
  <?php } else { ?>
    > No results found for <?php echo escape($_POST['customerID']); ?>.
  <?php }
} ?>

<h3>Find Customer based on ID</h3>

<form method="post">
    <label for="customerID">Customer ID</label>
    <input type="text" id="customerID" name="customerID">
    <input type="submit" name="submit" value="View Results">
</form>

<a href="../index.php">Back to home</a>

<?php include "../templates/footer.php"; ?>