<?php

if (isset($_POST['submit'])) {
    try {
        require "../../config.php";
        require "../../common.php";

        $transNumber = $_POST['transNumber'];

        $connection = new PDO($dsn, $username, $password, $options);        

        $sql = "SELECT * FROM Transactions WHERE transNumber = :transNumber";

        $statement = $connection->prepare($sql);
        $statement->bindParam(":transNumber", $transNumber, PDO::PARAM_STR);
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
    <th>Transaction Number</th>
    <th>Account Number</th>
    <th>Amount ($CAD)</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row) { ?>
    <tr>
    <td><?php echo escape($row["transNumber"]); ?></td>
    <td><?php echo escape($row["accNumber"]); ?></td>
    <td><?php echo escape($row["amount"]); ?></td>
    </tr>
    <?php } ?>
    </tbody>
    </table>

  <?php } else { ?>
    > No results found for <?php echo escape($_POST['transNumber']); ?>.
  <?php }
} ?>

<h3>Find Transactions based on ID</h3>

<form method="post">
    <label for="transNumber">Transactions ID</label>
    <input type="text" id="transNumber" name="transNumber">
    <input type="submit" name="submit" value="View Results">
</form>

<a href="../index.php">Back to home</a>

<?php include "../templates/footer.php"; ?>