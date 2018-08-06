

<?php 
  session_start();
  if(empty ($_SESSION['name'])) header ("Location: login.php");
  require 'database.php';
  $id = null;
  
  if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
  }
  if (null==$id) {
	header("Location: prog02.php");
  } 
  else {
	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "SELECT * FROM customers where id = ?";
	$q = $pdo->prepare($sql);
	$q->execute(array($id));
	$data = $q->fetch(PDO::FETCH_ASSOC);
	Database::disconnect();
  }
?>


<!-- display customer's data from database -->

<!DOCTYPE html>
<html lang="en">

  <head><meta charset="utf-8">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script>function clearForm(){}</script>
  </head>

  <body 
    <div class="container">
      <div class="span10 offset1">
    	<div class="row"><h3>Customer's information</h3></div>
		    		
	    <div class="form-horizontal" >
		  <div class="control-group">
		  <label class="control-label">Name</label>
			<?php echo $data['name'];?>
		  </div>
		  
		  <div class="control-group">
		  <label class="control-label">Email Address</label>
			<?php echo $data['email'];?>
		  </div>
		  
		  <div class="control-group">
		  <label class="control-label">Mobile Number</label>
			<?php echo $data['mobile'];?>
		  </div> <br />
		  
		  <div class="form-actions">
		    <a class="btn btn-success" href="prog02.php">Back</a>
		  </div>
		  
		</div>
      </div> <!-- end span -->		
    </div> <!-- end container -->
	
  </body>
</html>