<?php 
include "templates/header.php"; 
renderHeader("css/style.css");
?>

<h3>Manage Customers:</h3>

<ul>
  <li>
    <a href="customer/create.php"><strong>Create</strong></a> - add a customer
  </li>
  <li>
    <a href="customer/read.php"><strong>Search</strong></a> - search customer by ID
  </li>
  <li>
    <a href="customer/update.php"><strong>Update</strong></a> - update a customer
  </li>
  <li>
    <a href="customer/delete.php"><strong>Delete</strong></a> - delete a customer by ID
  </li>
</ul>

<?php include "templates/footer.php"; ?>