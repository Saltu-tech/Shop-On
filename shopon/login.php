<?php
	include('./asset/dbconn.php');
	session_start();
	
	if(isset($_SESSION['user_id'])){
		
		header('Location:./');
	}
	if(isset($_GET['redirect'])) {
		$_SESSION['redirect'] =  $_GET['redirect'];
	}
	
	if (isset($_POST['register'])) 
	{
		$fname=mysqli_real_escape_string($dbconn,$_POST['fname']);
		
		
		
		$mobile = mysqli_real_escape_string($dbconn,$_POST['phone']);
		
		$email = mysqli_real_escape_string($dbconn,$_POST['email']);
		
		$password=mysqli_real_escape_string($dbconn,$_POST['pswd']);
		
		$pass1=md5($password);
		$salt="a1Bz20ydqelm8m1wql";
		$pass=$salt.$pass1;
		
		$query=mysqli_query($dbconn,"SELECT * FROM `user` WHERE mobile='$mobile' OR email='$email' ");
		
		if (mysqli_num_rows($query)>0){
            $infou ="Mobile or Email id Already Registered! Please Log In";
			
			
		}
		
		// checking empty fields
		else if(empty($fname) || empty($mobile) || empty($email)  || empty($password)) {    
			
			if(empty($fname)) {
				echo "<font color='red'>Name field is empty!</font><br/>";
			}
			
			if(empty($mobile)) {
				echo "<font color='red'>Mobile no field is empty!</font><br/>";
			} 
			
			if(empty($email)) {
				echo "<font color='red'>Email id field is empty!</font><br/>";
			}
			
			if(empty($password)) {
				echo "<font color='red'>Password field is empty!</font><br/>";
			}    
			} else {    
			//updating the table
			$query = "INSERT INTO `user` (name, mobile, email, password) 
			VALUES ('$fname', '$mobile', '$email', '$pass')";
			
			$result = mysqli_query($dbconn,$query);
			
			if($result){
				//redirecting to the display page. In our case, it is index.php
				$info = "Successfully Registered! Login Now";
				
				
			}
			
		}
	}
	
	else if(isset($_POST['login']))
	{
		
		$mobile = mysqli_real_escape_string($dbconn,$_POST['phone']);
        $pass1 = mysqli_real_escape_string($dbconn,$_POST['pswd']);
		
		$pass=md5($pass1);
        $salt="a1Bz20ydqelm8m1wql";
        $pass=$salt.$pass;
		
		date_default_timezone_set('Asia/Manila');
        $date = date("Y-m-d H:i:s");
		
		
		$query1=mysqli_query($dbconn,"SELECT * FROM `user` WHERE mobile='$mobile' ");
		
		$query2=mysqli_query($dbconn,"SELECT * FROM `user` WHERE mobile='$mobile' AND password='$pass'");
	
		if (mysqli_num_rows($query1)<1){
			$infou ="Mobile Not Registered! Please Sign Up";
			
		}
		
		
		
		//$res=mysqli_fetch_array($query);
        //$id=$res['cust_id'];
		
		
		
		else if (mysqli_num_rows($query2)<1){
			$infoe ="Login Failed, Wrong Password!, Try Again";
			
		}
		
		
		else{
			$res = mysqli_fetch_array($query2);
			$_SESSION['user_id'] = $res['user_id'];
			$_SESSION['name'] = SUBSTR($res['name'], 0, strpos($res['name'],' '));
			
			if(isset($_SESSION['redirect'])) {
				header('Location:'. $_SESSION['redirect']);
			}
			else {
				header('Location:./');
			}	
			
		}
	}
	
	
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>User Registration | Login</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
		<link rel="stylesheet" href="./src/bootstrap.min.css"> 
		<script defer src="./src/all.js"></script>
		<script src="./src/jquery.min.js"></script>
		<script src="./src/popper.min.js"></script>
		<script src="./src/bootstrap.min.js"></script>
		
	</head>
	
	
	<body>
		
		
		
		
		<div class="navbar-expand-sm bg-dark  navbar-dark py-4 ">
			
			<center><img src="./src/logo.png"></center>
			
		</div> 
		
		<section class="section-content p-4">  
			<div class="container " style="width:400px;">
				
				<div id="tab" class="btn-group" data-toggle="buttons-radio">
					<a data-toggle="tab" class="btn btn-success active" href="#login">Login</a> <p class="small">Already User ? </p>
					<a data-toggle="tab" class="btn btn-success" href="#signup">Signup</a><p class="small">New User? </p>
				</div>
				
				<div class="tab-content">
					<!-- ============================ COMPONENT LOGIN 1  ================================= -->
					<?php if(isset($info)) { 
					?>
					<div class="alert alert-success "> <?php echo $info; ?></div> 
					<?php } ?>
					
					<?php if(isset($infoe)) { 
					?>
					<div class="alert alert-danger "> <?php echo $infoe;  ?></div> 
					<?php } ?>
					
					<?php if(isset($infou)) { 
					?>
					<div class="alert alert-warning "> <?php echo $infou;  ?></div> 
					<?php } ?>
					
					<?php if(isset($_SESSION['alert'])) { 
					?>
					<div class="alert alert-danger "> <?php echo $_SESSION['alert']; unset($_SESSION['alert']);  ?></div> 
					<?php } ?>
					
					<div class="card tab-pane  active" id="login">
						<div class="card-body">
							<h4 class="card-title mb-4">Sign in</h4>
							<form class="was-validated" method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
								
								<div class="form-group">
									<label>Mobile No</label>
									<input type="tel" name="phone" class="form-control" placeholder="99XXXXXXXX" required>
									
								</div>
								
								<div class="form-group">
									<a class="float-right" href="#">Forgot</a>
									<label>Password</label>
									<input class="form-control" name="pswd" placeholder="******" type="password" required>
									
								</div> <!-- form-group// --> 
								<!-- form-group form-check .// -->
								<div class="form-group">
									<button type="submit" name="login" class="btn btn-primary btn-block"> Login  </button>
								</div> <!-- form-group// -->    
							</form>
						</div> <!-- card-body.// -->
						<div class="card-footer text-center">Don't have an account? <a  data-toggle="tab" href="#signup">Signup</a></div>
					</div> <!-- card .// -->
					<!-- ============================ COMPONENT LOGIN 1  END.// ================================= -->
					
					<div class="card tab-pane " id="signup">
						<article class="card-body">
							<header class="mb-4">
								<h4 class="card-title">Sign up</h4>
							</header>
							<form class="was-validated" method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
								
								
								<div class="form-group">
									<label>Name</label>
									<input type="text" name="fname" class="form-control" placeholder="" required>
								</div>
								
								<div class="form-group">
									<label>Mobile No</label>
									<input type="tel" name="phone" class="form-control" placeholder="" required>
									<small class="form-text text-muted">We'll never share your mobile no with anyone else.</small>
								</div>
								
								<div class="form-group">
									<label>Email id</label>
									<input type="email" name="email" class="form-control" placeholder="" required>
									<small class="form-text text-muted">We'll never share your email id with anyone else.</small>
								</div>
								
								
								<div class="form-group">
									<label>Set Password</label>
									<input class="form-control" name="pswd" type="password" required>
								</div> 
								
								<div class="form-group mt-3">
									<button type="submit" name="register" class="btn btn-primary btn-block"> Register  </button>
								</div>      
								<p class="text-muted">By clicking the 'Register' button, you confirm that you accept our Terms of use and Privacy Policy.</p>                                          
							</form>
							<hr>
							<p class="text-center">Have an account? <a  data-toggle="tab" href="#login">Login</a></p>
						</article> <!-- card-body end .// -->
					</div> <!-- card.// -->
					
				</div>
				
				
			</div>
		</section>
		
		
	</body>
</html>
