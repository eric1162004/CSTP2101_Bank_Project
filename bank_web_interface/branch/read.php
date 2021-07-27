<?php

if (isset($_POST['submit'])) {
    try {
        require "../../config.php";
        require "../../common.php";

        $branchNumber = $_POST['branchNumber'];

        $connection = new PDO($dsn, $username, $password, $options);

        $sql = "SELECT * FROM Branch WHERE branchNumber = :branchNumber";

        $statement = $connection->prepare($sql);
        $statement->bindParam(":branchNumber", $branchNumber, PDO::PARAM_STR);
        $statement->execute();

        $result = $statement->fetchAll();
    } catch (PDOException $error) {
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
  <th>#</th>
  <th>Branch Name</th>
  <th>Manager SIN</th>
  <th>Budget</th>
</tr>
      </thead>
      <tbody>
  <?php foreach ($result as $row) { ?>
      <tr>
<td><?php echo escape($row["branchNumber"]); ?></td>
<td><?php echo escape($row["branchName"]); ?></td>
<td><?php echo escape($row["managerSIN"]); ?></td>
<td><?php echo escape($row["budget"]); ?></td>
      </tr>
    <?php } ?>
      </tbody>
  </table>
  <?php } else { ?>
    > No results found for <?php echo escape($_POST['branchNumber']); ?>.
  <?php }
} ?>

<h3>Find Branch based on ID</h3>

<form method="post">
    <label for="branchNumber">Branch ID</label>
    <input type="text" id="branchNumber" name="branchNumber">
    <input type="submit" name="submit" value="View Results">
</form>

<a href="../index.php">Back to home</a>

<?php include "../templates/footer.php"; ?>