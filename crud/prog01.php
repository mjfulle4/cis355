

<!DOCTYPE html>
<html lang = "en">
<head>
  <meta charset = "utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body style="padding:50px;">
  <h1>Customers</h1><br/>
</body>

<?php
  require ("database.php");
  session_start();

  class Customer {
    private static $id;
    private static $name;
    private static $email;
    private static $mobile;
    
    // display database in a table 
    public function displayRecords () {
    
      $pdo = Database::connect();
      $sql = 'SELECT * FROM customers ORDER BY id DESC';
      echo '<table class = "table table-striped table-bordered">
	  <thead>
        <tr>
          <th>Name</th>
          <th>Email Address</th>
          <th>Mobile Number</th>
          <th>Action</th>
        </tr> </thead>
      <tbody>';
	  
      // populate table with database contents
      foreach ($pdo->query($sql) as $row) {
        echo '<tr>';
        echo '<td>'. $row['name'] . '</td>';
        echo '<td>'. $row['email'] . '</td>';
        echo '<td>'. $row['mobile'] . '</td>';
        echo '<td width=250>';
		$this -> displayReadButton($row);
        echo '&nbsp;';
        $this -> displayUpdateButton($row);
        echo '&nbsp;';
        $this -> displayDeleteButton($row);
        echo '</td>';
        echo '</tr>';
      }
      echo '</tbody></table>';
      Database::disconnect();
    }
	
	// show button to create a new customer
    function displayCreateButton(){
      echo "<a href='create.php' class='btn btn-success' style='margin-bottom:20px;'>Create New</a>";
    }
	
	// show button to read customer data
    function displayReadButton($row){
      echo '<a class="btn btn-info" href="read.php?id='. $row['id'].'">Read</a>';
    }
	
	// show button to update customer data
    function displayUpdateButton($row){
      echo '<a class="btn btn-success" href="update.php?id='.$row['id'].'">Update</a>';
    }
	
	// show button to delete a customer
    function displayDeleteButton($row){
      echo '<a class="btn btn-danger" href="delete.php?id='.$row['id'].'">Delete</a>';
    }
  }

//new class object
$cust1 = new Customer;
$cust1->displayCreateButton();
$cust1->displayRecords();