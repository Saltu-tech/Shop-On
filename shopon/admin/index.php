<?php
	include('../asset/dbconn.php');
	session_start();
	date_default_timezone_set('Asia/Manila');
	if(isset($_SESSION['admin_id'])){
		
		header('Location: ./manage/');
		
	}
	
	
	if(isset($_POST['login']))
	{
		
		$mobile = mysqli_real_escape_string($dbconn,$_POST['phone']);
        $pass = md5(mysqli_real_escape_string($dbconn,$_POST['pswd']));
		
		date_default_timezone_set('Asia/Manila');
        $date = date("Y-m-d H:i:s");
		
		
		$query=mysqli_query($dbconn,"SELECT * FROM `admin` WHERE mobile='$mobile' and password = '$pass' ");
		
		if (mysqli_num_rows($query)<1){
			$infou ="Wrong Credential!";
			echo $infou;
		}
		
		else{
			//echo "rakesh";
			$res = mysqli_fetch_array($query);
			$_SESSION['admin_id'] = $res['admin_id'];
			$_SESSION['name'] = SUBSTR($res['name'], 0, strpos($res['name'],' '));
			
			
			header('Location: ./manage/');
				   
			
		}
	}
?>



<!DOCTYPE html>
<html lang="en">
	<head>
		<title>ShopOn Admin</title>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
		
		<link rel="stylesheet" href="../src/bootstrap.min.css"/> 
		<script defer src="../src/all.js"></script>
		<script src="../src/jquery.min.js"></script>
		<script src="../src/popper.min.js"></script>
		<script src="../src/bootstrap.min.js"></script>
		
	</head>
	
	
	<body>
		
		<div class="navbar-expand-sm bg-dark  navbar-dark py-4 ">
			
			<center><img src="../src/logo.png"></center>
			
		</div> 
		<div class="container " style="width:400px;">
			
			<div class="card  active" id="login">
				<div class="card-body">
					<h4 class="card-title mb-4">Sign in</h4>
					<form class="was-validated" method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
						
						
						<div class="form-group">
							<label>Mobile No</label>
							<input type="tel" name="phone" class="form-control" placeholder="99XXXXXXXX" required>
							
						</div>
						
						<div class="form-group">
							<label>Password</label>
							<input class="form-control" name="pswd" placeholder="******" type="password" required>
							
						</div> 
						<div class="form-group">
							<button type="submit" name="login" class="btn btn-primary btn-block"> Login  </button>
						</div>   
					</form>
				</div> 
				
			</div> 	
			
		</div>
	</body>
	
</html>
