<?php

if (isset($_POST['submit'])) {
    try {
        require "../../config.php";
        require "../../common.php";

        $accNumber = $_POST['accNumber'];

        $connection = new PDO($dsn, $username, $password, $options);        

        $sql = "SELECT * FROM Account WHERE accNumber = :accNumber";
        $statement = $connection->prepare($sql);
        $statement->bindParam(":accNumber", $accNumber, PDO::PARAM_STR);
        $statement->execute();

        $result = $statement->fetchAll();

        $sql = "SELECT * FROM Owns WHERE accNumber = :accNumber";
        $statement = $connection->prepare($sql);
        $statement->bindParam(":accNumber", $accNumber, PDO::PARAM_STR);
        $statement->execute();

        $ownResults = $statement->fetchAll();

        // Get Customer Information
        $customers = array();
        foreach ($ownResults as $row){
          $sql2 = "SELECT * FROM Customer WHERE customerID = :customerID";
          $statement = $connection->prepare($sql2);
          $statement->bindParam(":customerID", $row["customerID"], PDO::PARAM_STR);
          $statement->execute();

          $customerResults = $statement->fetchAll();
          array_push($customers, $customerResults[0]);
        }

    } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
    }
  }
?>

<?php 
    include "../templates/header.php"; 
    renderHeader("../css/style.css");
?>

<!-- Search box -->
<div class="borderDiv">
<form method="post">
    <label for="accNumber">Please Enter Account Number</label>
    <input type="text" id="accNumber" name="accNumber">
    <input type="submit" name="submit" value="View Results">
</form>
</div>

<?php
if (isset($_POST['submit'])) {
  if ($result && $statement->rowCount() > 0) { ?>

    <h3>Account Details</h3>
    <table>
    <thead>
    <tr>
    <th>Account Number</th>
    <th>Account Type</th>
    <th>Balance($CAD)</th>
    <th>Branch Number</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row) { ?>
    <tr>
    <td><?php echo escape($row["accNumber"]); ?></td>
    <td><?php echo escape($row["type"]); ?></td>
    <td><?php echo escape($row["balance"]); ?></td>
    <td><?php echo escape($row["branchNumber"]); ?></td>
    </tr>
    <?php } ?>
    </tbody>
    </table>

    <h3>Account Owner(s)</h3>
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
    <?php foreach ($customers as $row) { ?>
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
    <h3>Results</h3>
    No results for account number: <?php echo escape($_POST['accNumber']); ?>.
  <?php }
} ?>

<br>
<div>
  <a href="../index.php">Back to home</a>
</div>
  
<?php include "../templates/footer.php"; ?>