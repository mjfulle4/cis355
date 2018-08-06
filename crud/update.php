

<?php 
	
  session_start();
  if(empty ($_SESSION['name'])) header ("Location: login.php");
  require 'database.php';
  
  $id = null;
  if ( !empty($_GET['id'])) {
	$id = $_REQUEST['id'];
  }	
  if ( null==$id ) {
    header("Location: prog02.php");
  }
	
  if ( !empty($_POST)) {
    // initialize error variables
    $nameError = null;
	$emailError = null;
	$mobileError = null;
		
	// populate data variables with user-entered text
	$name = $_POST['name'];
	$email = $_POST['email'];
	$mobile = $_POST['mobile'];
		
	// is a valid name?
	$valid = true;
	if (empty($name)) {
	  $nameError = 'Please enter Name';
	  $valid = false;
	}
	
    // is a valid email?	
	if (empty($email)) {
	  $emailError = 'Please enter Email Address';
	  $valid = false;
	}
	
    // is a valid phone number?	
	if (empty($mobile)) {
	  $mobileError = 'Please enter Mobile Number';
	  $valid = false;
	}
		
	// update database with user's information
	if ($valid) {
	  $pdo = Database::connect();
	  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	  $sql = "UPDATE customers  set name = ?, email = ?, mobile =? WHERE id = ?";
	  $q = $pdo->prepare($sql);
	  $q->execute(array($name,$email,$mobile,$id));
	  Database::disconnect();
	  header("Location: prog01.php");
	}
  } 
  else {
	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "SELECT * FROM customers where id = ?";
	$q = $pdo->prepare($sql);
	$q->execute(array($id));
	$data = $q->fetch(PDO::FETCH_ASSOC);
	$name = $data['name'];
	$email = $data['email'];
	$mobile = $data['mobile'];
	Database::disconnect();
  }
?>


<!-- prompt user to edit an existing customer's data -->

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
  </head>

  <body>
    <div class="container">
      <div class="span10 offset1">
    	<div class="row"><h3>Update customer's information</h3></div>
    		
	    <form class="form-horizontal" action="update.php?id=<?php echo $id?>" method="post">
		  <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
		  <label class="control-label">Name</label>
		    <div class="controls">
			  <input name="name" type="text"  placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">
			  <?php if (!empty($nameError)): ?>
			    <span class="help-inline"><?php echo $nameError;?></span>
			  <?php endif; ?>
		    </div>
		  </div>
		
		  <div class="control-group <?php echo !empty($emailError)?'error':'';?>">
		  <label class="control-label">Email Address</label>
		    <div class="controls">
			  <input name="email" type="text" placeholder="Email Address" value="<?php echo !empty($email)?$email:'';?>">
			  <?php if (!empty($emailError)): ?>
			    <span class="help-inline"><?php echo $emailError;?></span>
			  <?php endif;?>
		    </div>
		  </div>
					  
		  <div class="control-group <?php echo !empty($mobileError)?'error':'';?>">
		  <label class="control-label">Mobile Number</label>
		    <div class="controls">
			  <input name="mobile" type="text"  placeholder="Mobile Number" value="<?php echo !empty($mobile)?$mobile:'';?>">
			  <?php if (!empty($mobileError)): ?>
			    <span class="help-inline"><?php echo $mobileError;?></span>
			  <?php endif;?>
		    </div>
		  </div>
		
		  <div class="form-actions">
		    <button type="submit" class="btn btn-success">Update</button>
		    <a class="btn" href="prog02.php">Back</a>
		  </div>
		</form>
	  </div> <!-- end span -->		
    </div> <!-- end container -->

  </body>
</html>