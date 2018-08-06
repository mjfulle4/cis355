<?php  
  session_start(); 
  require 'database.php'; 
     
  if (!empty($_POST)) { 
    $nameError = null; 
    $passwordError = null; 
         
    $name = $_POST['name']; 
    $password = $_POST['password'];
    $password = MD5($password);	
    $valid = true;
	
    if (empty($name)) { 
      $nameError = 'Enter a user name'; 
      $valid = false; 
    } 
         
    if (empty($password)) { 
      $passwordError = 'Enter a password'; 
      $valid = false; 
    }  
	
    if ($valid) { 
      $pdo = Database::connect(); 
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
      $sql = "SELECT * FROM customers WHERE name = ? LIMIT 1"; 
      $q = $pdo->prepare($sql); 
      $q->execute(array($name)); 
      $results = $q->fetch(PDO::FETCH_ASSOC);
	  
      if($results['password']==$password) { 
        $_SESSION['name'] = $name; 
        Database::disconnect(); 
        header("Location: prog02.php");
      } 
      else { 
        $passwordError = 'Invalid password'; 
        Database::disconnect(); 
      } 
    } 
  }
  
?> 
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
      <div class="row"><h3>Login</h3></div> 
             
      <form class="form-horizontal" action="login.php" method="post"> 
                     
        <div class="control-group <?php echo !empty($nameError)?'error':'';?>"> 
        <label class="control-label">User Name</label> 
          <div class="controls"> 
            <input name="name" type="text"  placeholder="Name" value="<?php echo !empty($name)?$name:'';?>"> 
            <?php if (!empty($nameError)): ?> 
              <span class="help-inline"><?php echo $nameError;?></span> 
            <?php endif; ?> 
          </div> 
        </div> 
                       
        <div class="control-group <?php echo !empty($passwordError)?'error':'';?>"> 
        <label class="control-label">Password</label> 
          <div class="controls"> 
            <input name="password" type="password" placeholder="Password" value="<?php echo !empty($password)?$password:'';?>"> 
            <?php if (!empty($passwordError)): ?> 
              <span class="help-inline"><?php echo $passwordError;?></span> 
            <?php endif;?> 
          </div> 
        </div> 
                       
        <div class="form-actions"> 
          <button type="submit" class="btn btn-success">Submit</button> 
          <a class="btn" href="logout.php">Log out</a>
        </div>                     
      </form>                    
    </div>               
  </div>  
</body> 
</html> 