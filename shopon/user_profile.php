<?php
	include('./asset/db.php');
	include('./asset/dbconn.php');
	session_start();
	if(!isset($_SESSION['user_id'])){
		$_SESSION['alert'] = "Log in first To continue to Shop Panel";
		header('Location:./login.php?redirect='.$_SERVER['REQUEST_URI']);
	}
	
	
	
	
	
	
	
	
	$query = "SELECT * FROM `user` WHERE user_id = '$_SESSION[user_id]'";
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	
	
	
	
	
	
	
	
	
	
	
	
	if (isset($_POST['update_user'])) 
	{
		$user_name = mysqli_real_escape_string($dbconn,$_POST['user_name']);
		$phone=mysqli_real_escape_string($dbconn,$_POST['phone']);
		$email=mysqli_real_escape_string($dbconn,$_POST['email']);
		$password=mysqli_real_escape_string($dbconn,$_POST['pswd']);
		$gender=mysqli_real_escape_string($dbconn,$_POST['gender']);
		$dob=mysqli_real_escape_string($dbconn,$_POST['dob']);
		$lat=mysqli_real_escape_string($dbconn,$_POST['lat']);
		$long=mysqli_real_escape_string($dbconn,$_POST['long']);
		
		$user_id = $_SESSION['user_id'];
		
		
		
		// checking empty fields
		if(empty($password)  ) {    
			
			$query = "UPDATE user SET name = '$user_name', mobile = '$phone', email = '$email', 
			gender = '$gender', dob = '$dob', lat = '$lat', longt = '$long' WHERE user_id = '$user_id' ";
			
			$result2 = mysqli_query($dbconn,$query);
			
			if($result[0]['lat'] == null || $result[0]['longt'] ==null || $result[0]['lat'] != round($lat, 6) || $result[0]['longt'] != round($long, 6))
			{
				$query = "INSERT INTO user_loc_hist (user_id, lat, longt) VALUES ('$_SESSION[user_id]', '$lat', '$long')";
				
				$result3 = mysqli_query($dbconn,$query);
			}
			
			if($result2){
				//redirecting to the display page. In our case, it is index.php
				echo "<meta http-equiv='refresh' content='0' >";
				echo "Profile Updated";
				
				
			}
			else {
				echo "Error Occured";
			}	
			
		} 
		else {
			$pass1=md5($password);
			$salt="a1Bz20ydqelm8m1wql";
			$pass=$salt.$pass1;
			
			//updating the table
			$query = "UPDATE user SET name = '$user_name', mobile = '$phone', email = '$email', password = '$pass', 
			gender = '$gender', dob = '$dob', lat = '$lat', longt = '$long' WHERE user_id = '$user_id' ";
			
			$result2 = mysqli_query($dbconn,$query);
			
			
			if($result[0]['lat'] == null || $result[0]['longt'] ==null || $result[0]['lat'] != round($lat, 6) || $result[0]['longt'] != round($long, 6))
			{
				$query = "INSERT INTO user_loc_hist (user_id, lat, longt) VALUES ('$_SESSION[user_id]', '$lat', '$long')";
				
				$result3 = mysqli_query($dbconn,$query);
			}
			
			if($result2){
				//redirecting to the display page. In our case, it is index.php
				echo "<meta http-equiv='refresh' content='0' >";
				echo "User Profile Updated";
				
				
			}
			else {
				echo "Error Occured";
			}
			
		} 
	}
	
	
	
	
?>	


<!DOCTYPE html>
<html>
	<head>
		<title>User Profile | ShopOn</title>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>   
		
		
		<style>
			body
			{
			margin:0;
			padding:0;
			background-color:#f1f1f1;
			}
			.box
			{
			width:1270px;
			padding:20px;
			background-color:#fff;
			border:1px solid #ccc;
			border-radius:5px;
			margin-top:25px;
			}
			
		</style>
	</head>
	<body>
		<div class="navbar-expand-sm   py-4 ">
			
			<center><img src="./src/logo.png"><h1 ><?= $_SESSION['name'] ?>'s User Profile</h1></center>
			
		</div> 
		<div class="container box">
			<a href="./"> Home </a>
			<div class="row">
				<div class="col-lg-3">
				</div>
				<div class="card col-lg-6">
					<form  method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
						
						<div class="form-group">
							<label> <b>User name</b> </label>
							<input type="text" maxlength="60"  value ="<?= $result[0][1]; ?>"  class="form-control" name="user_name" required/>
						</div>
						<div class="form-group">
							<label> <b>Mobile</b> </label>
							<input type="tel" maxlength="10" value ="<?= $result[0][2]; ?>" class="form-control" name="phone" required/>
						</div>
						<div class="form-group">
							<label> <b>Email</b> </label>
							<input type="email" maxlength="60" value ="<?= $result[0][3]; ?>" class="form-control" name="email" required/>
						</div>
						<div class="form-group">
							<label> <b>Password</b> </label>
							<input type="password" placeholder="Enter new password to change or leave empty" maxlength="60"  class="form-control" name="pswd" />
						</div>
						<div class="form-group">
							<label> <b>Gender</b> </label>
							<select class="form-control" name="gender" required>
								<option value="Male" <?php if($result[0][5] == "Male" ) echo 'selected = "selected"' ; ?> > Male </option>
								<option value="Female" <?php if($result[0][5] == "Female" ) echo 'selected = "selected"' ; ?> > Female  </option>
								<option value="Other" <?php if($result[0][5] == "Other" ) echo 'selected = "selected"' ; ?> > Other  </option>
							</select>
						</div>
						<div class="form-group">
							<label> <b>Date of birth</b> </label>
							<input type="date" value ="<?= $result[0][6]; ?>" class="form-control" name="dob" required/>
						</div>
						<div id="google_map" style="width:500px;height:400px;"></div>
						<div class="form-group">
							<label> <b>Lat</b> </label>
							<input id="LATITUDE_ELEMENT_ID"  value ="<?= $result[0][7]; ?>" class="form-control" name="lat" readonly/>
						</div>
						<div class="form-group">
							<label> <b>Long</b> </label>
							<input id="LONGITUDE_ELEMENT_ID" value ="<?= $result[0][8]; ?>"  class="form-control" name="long" readonly/>
						</div>
						
						
						<div class="form-group">
							<input type="submit" Value="Update"  class="btn btn-primary btn-block" name="update_user"  />
						</div>
						
					</form>
					
				</div>
				<div class="col-lg-3">
				</div>
				
				
			</div>
			
		</div>
	</body>
</html>







<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=AIzaSyD9CJa7i9sWoGYszPsVxRCOL9N_RTdBTR4"></script>
<Script type="text/javascript">
	var LATITUDE_ELEMENT_ID = "LATITUDE_ELEMENT_ID";
	var LONGITUDE_ELEMENT_ID = "LONGITUDE_ELEMENT_ID";
	var MAP_DIV_ELEMENT_ID = "google_map";
	
	var DEFAULT_ZOOM_WHEN_NO_COORDINATE_EXISTS = 4;
	var DEFAULT_CENTER_LATITUDE = 22;
	var DEFAULT_CENTER_LONGITUDE = 78;
	var DEFAULT_ZOOM_WHEN_COORDINATE_EXISTS = 15;
	var REQUIRED_ZOOM = 15;
	
	
	var map;
	var marker = false;
	
	function initMap() {
		var latitude = +document.getElementById(LATITUDE_ELEMENT_ID).value;
		var longitude = +document.getElementById(LONGITUDE_ELEMENT_ID).value;
		
		if(latitude != 0 && longitude != 0) {
			//We have some sort of starting position, set map center and marker
			centerOfMap = new google.maps.LatLng(latitude, longitude);
			var options = {
				center: centerOfMap,
				zoom: DEFAULT_ZOOM_WHEN_COORDINATE_EXISTS
			};
			map = new google.maps.Map(document.getElementById(MAP_DIV_ELEMENT_ID), options);
			marker = new google.maps.Marker({
				position: centerOfMap,
				map: map,
				//draggable: true
			});
		} 
		else {
			// Just set the default center, do not add a marker
			centerOfMap = new google.maps.LatLng(DEFAULT_CENTER_LATITUDE, DEFAULT_CENTER_LONGITUDE);
			var options = {
				center: centerOfMap,
				zoom: DEFAULT_ZOOM_WHEN_NO_COORDINATE_EXISTS
			};
			map = new google.maps.Map(document.getElementById(MAP_DIV_ELEMENT_ID), options);
		}
		
		
		google.maps.event.addListener(map, 'click', function(event) {
			var clickedLocation = event.latLng
			
			if(map.getZoom() < REQUIRED_ZOOM) {
				alert("you_must_zoom_in_closer_to_position_the_course_accurately." );
				return;
			}
			
			if(marker == false) {
				marker = new google.maps.Marker({
					position: clickedLocation,
					map: map,
					//draggable: true
				});
				
				google.maps.event.addListener(marker, 'dragend', function(event){
					markerLocation();
				});	
			} 
			else {
				marker.setPosition(clickedLocation);
			}
			markerLocation();
			
		});
		
		
		
	}
	
	
	function markerLocation() {
		var currentLocation = marker.getPosition();
		document.getElementById(LATITUDE_ELEMENT_ID).value = currentLocation.lat();
		document.getElementById(LONGITUDE_ELEMENT_ID).value = currentLocation.lng();
	}
	
	google.maps.event.addDomListener(window, 'load', initMap);
	
</script>




