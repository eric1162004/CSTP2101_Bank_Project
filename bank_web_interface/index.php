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

<h3>Manage Customer Accounts:</h3>

<h3>Manage Transactions:</h3>

<h3>Manage Employees:</h3>

<ul>
  <li>
    <a href="employee/create.php"><strong>Create</strong></a> - add a employee
  </li>
  <li>
    <a href="employee/read.php"><strong>Search</strong></a> - search employee by SIN
  </li>
  <li>
    <a href="employee/update.php"><strong>Update</strong></a> - update a employee
  </li>
  <li>
    <a href="employee/delete.php"><strong>Delete</strong></a> - delete a employee by SIN
  </li>
</ul>

<h3>Manage Branch:</h3>

<ul>
  <li>
    <a href="branch/create.php"><strong>Create</strong></a> - add a branch
  </li>
  <li>
    <a href="branch/read.php"><strong>Search</strong></a> - search branch by branch number
  </li>
  <li>
    <a href="branch/update.php"><strong>Update</strong></a> - update a branch
  </li>
  <li>
    <a href="branch/delete.php"><strong>Delete</strong></a> - delete a branch by branch number
  </li>
</ul>


<?php include "templates/footer.php"; ?>