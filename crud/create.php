

<?php 
  session_start();
  if(empty ($_SESSION['name'])) header ("Location: login.php");
	
  // check user input before entry into database
  require 'database.php';
	
  // initialize error variables	
  if (!empty($_POST)) {
	$nameError = null;
	$emailError = null;
	$mobileError = null;
	$passwordError = null;
		
	// populate data variables with text field data
	$name = $_POST['name'];
	$email = $_POST['email'];
	$mobile = $_POST['mobile'];
	$password = $_POST['password'];
	$password = MD5($password);	
		
	// check for blank name
	$valid = true;
	if (empty($name)) {
	  $nameError = 'Please enter a name';
	  $valid = false;
	}
	// check for blank email address	
	if (empty($email)) {
	  $emailError = 'Please enter an email address';
	  $valid = false;
	} 
	// check for blank phone number	
	if (empty($mobile)) {
	  $mobileError = 'Please enter a mobile phone number';
	  $valid = false;
	}
	// check for blank password	
	if (empty($password)) {
	  $passwordError = 'Please enter a password';
	  $valid = false;
	}
	
		
	// insert data into database
	if ($valid) {
	  $pdo = Database::connect();
	  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	  $sql = "INSERT INTO customers (name,email,mobile, password) values(?, ?, ?, ?)";
	  $q = $pdo->prepare($sql);
	  $q->execute(array($name,$email,$mobile,$password));
	  Database::disconnect();
	  header('Location: prog01.php');
	}
  }
?>


<!-- prompt user to enter new customer data -->

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
        <div class="row"><h3>Create a new Customer</h3></div>
    		
	    <form class="form-horizontal" action="create.php" method="post">
		  <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
		    <label class="control-label">Name</label>
			<div class="controls">
		      <input name="name" type="text" placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">
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
		  
		  <div class="control-group <?php echo !empty($passwordError)?'error':'';?>">
			<label class="control-label">Password</label>
			<div class="controls">
			  <input name="password" type="text"  placeholder="Password" value="<?php echo !empty($password)?$password:'';?>">
			  <?php if (!empty($passwordError)): ?>
			    <span class="help-inline"><?php echo $passwordError;?></span>
			  <?php endif;?>
			</div>
		  </div><br />
		  
		  <div class="form-actions">
			<button type="submit" class="btn btn-success">Create</button>
			<a class="btn" href="prog02.php">Back</a>
		  </div>
		</form>
	  </div> <!-- end span -->		
    </div> <!-- end container -->
	
  </body>
</html>