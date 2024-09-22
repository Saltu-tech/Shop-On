<?php
	include('../asset/db.php');
	include('../asset/dbconn.php');
	session_start();
	if(!isset($_SESSION['provider_id'])){
		$_SESSION['alert'] = "Log in first To continue to Shop Panel";
		header('Location:./login.php?redirect='.$_SERVER['REQUEST_URI']);
	}
	
	
	$query = "SELECT * FROM `shop_cat`";
	$statement = $connection->prepare($query);
	$statement->execute();
	$result2 = $statement->fetchAll();
	
	
	
	
	if(isset($_POST['edit_shop']))
	{
		$shop_id = $_POST['shop_id'];
		$query = "SELECT * FROM `shop` INNER JOIN `shop_cat` ON `shop`.`shop_cat_id`=`shop_cat`.`shop_cat_id` WHERE shop_id = '$shop_id'";
		$statement = $connection->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
	}
	
	
	
	
	
	
	
	if (isset($_POST['add_shop'])) 
	{
		$shop_cat_id = mysqli_real_escape_string($dbconn,$_POST['shop_cat_id']);
		$shop_type=mysqli_real_escape_string($dbconn,$_POST['shop_type']);
		$shop_name=mysqli_real_escape_string($dbconn,$_POST['shop_name']);
		$building=mysqli_real_escape_string($dbconn,$_POST['building']);
		$locality=mysqli_real_escape_string($dbconn,$_POST['locality']);
		$city=mysqli_real_escape_string($dbconn,$_POST['city']);
		$state=mysqli_real_escape_string($dbconn,$_POST['state']);
		$pin=mysqli_real_escape_string($dbconn,$_POST['pin']);
		$lat=mysqli_real_escape_string($dbconn,$_POST['lat']);
		$long=mysqli_real_escape_string($dbconn,$_POST['long']);
		
		if(isset($_POST['range']))
		{
			
			$range=mysqli_real_escape_string($dbconn,$_POST['range']);
		}
		else {
			$range = null;
		}
		
		$provider_id = $_SESSION['provider_id'];
		
		
		
		// checking empty fields
		if(empty($shop_cat_id) || !isset($shop_type)  || empty($shop_name) || empty($building) || empty($locality) || empty($city) || empty($state) || empty($pin) || empty($lat)  || empty($long)  ) {    
			
			echo "<font color='red'>All field required</font><br/>";    
		} 
		else {
			
			
			//updating the table
			if(range == null)
			{
				$query = "INSERT INTO shop (shop_cat_id, shop_type, shop_name, building, locality, city, state, pin, lat, longt, provider_id) 
				VALUES ('$shop_cat_id', '$shop_type', '$shop_name', '$building', '$locality', '$city', '$state', '$pin', '$lat', '$long', '$provider_id')";
			}
			else {
				$query = "INSERT INTO shop (shop_cat_id, shop_type, shop_name, building, locality, city, state, pin, lat, longt, ranged, provider_id) 
				VALUES ('$shop_cat_id', '$shop_type', '$shop_name', '$building', '$locality', '$city', '$state', '$pin', '$lat', '$long', '$range', '$provider_id')";
			}
			$result = mysqli_query($dbconn,$query);
			
			
			if($result){
				//redirecting to the display page. In our case, it is index.php
				echo "Shop Added";
				header('Location:./');
				
			
			}
			else {
				echo "Error Occured";
			} 
			
			
		} 
	}
	
	
	
	
	if (isset($_POST['update_shop'])) 
	{
		$shop_cat_id = mysqli_real_escape_string($dbconn,$_POST['shop_cat_id']);
		$shop_type=mysqli_real_escape_string($dbconn,$_POST['shop_type']);
		$shop_name=mysqli_real_escape_string($dbconn,$_POST['shop_name']);
		$building=mysqli_real_escape_string($dbconn,$_POST['building']);
		$locality=mysqli_real_escape_string($dbconn,$_POST['locality']);
		$city=mysqli_real_escape_string($dbconn,$_POST['city']);
		$state=mysqli_real_escape_string($dbconn,$_POST['state']);
		$pin=mysqli_real_escape_string($dbconn,$_POST['pin']);
		$lat=mysqli_real_escape_string($dbconn,$_POST['lat']);
		$long=mysqli_real_escape_string($dbconn,$_POST['long']);
		$range=mysqli_real_escape_string($dbconn,$_POST['range']);
		
		$provider_id = $_SESSION['provider_id'];
		
		$shop_id = mysqli_real_escape_string($dbconn,$_POST['shop_id']);
		
		
		
		// checking empty fields
		if(empty($shop_id) || empty($shop_cat_id) || !isset($shop_type)  || empty($shop_name) || empty($building) || empty($locality) || empty($city) || empty($state) || empty($pin) || empty($lat)  || empty($long) || empty($range) ) {    
			
			echo "<font color='red'>All field required</font><br/>";  
			if(!isset($shop_cat_id))
			{
				echo "<font color='red'>Name field required</font><br/>";
			}	
			
		} 
		else {
			
			//updating the table
			$query = "UPDATE shop SET shop_cat_id = '$shop_cat_id', shop_type = '$shop_type', shop_name = '$shop_name', 
			building = '$building', locality = '$locality', city = '$city', state = '$state', pin = '$pin', lat = '$lat', 
			longt = '$long', ranged = '$range' WHERE shop_id = '$shop_id' AND provider_id = '$provider_id'   ";
			
			$result = mysqli_query($dbconn,$query);
			
			
			if($result){
				//redirecting to the display page. In our case, it is index.php
				echo "Shop Updated";
				header('Location:./');
				
				
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
		<title>Add Shop | ShopOn</title>
		
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
			
			<center><img src="../src/logo.png"><h1 ><?= $_SESSION['name'] ?>'s Add Shop</h1></center>
			
		</div> 
		<div class="container box">
			<a href="./"> Home </a>
			<div class="row">
				<div class="col-lg-3">
				</div>
				<div class="card col-lg-6">
					<h3 align="center"> Add New Shop </h3>
					<form  method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
						<div class="form-group">
							<label> <b>Shop category</b> </label>
							<select class="form-control" name="shop_cat_id" required>
								<?php foreach($result2 as $row) { ?>
									<option value="<?= $row['shop_cat_id']; ?>" <?php if(isset($result) && $result[0][1] == $row['shop_cat_id'] ) echo "selected";  ?> > <?= $row['name']; ?> </option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group">
							<label> <b>Shop Type</b> </label>
							<select class="form-control" id="shop_type" name="shop_type" required>
								<option value="0" <?php if(isset($result) && $result[0][2] == 0 ) echo 'selected = "selected"' ; ?> > Physical Shop </option>
								<option value="1" <?php if(isset($result) && $result[0][2] == 1 ) echo 'selected = "selected"' ; ?> > Virtual Provider  </option>
							</select>
						</div>
						<div class="form-group">
							<label> <b>Shop name</b> </label>
							<input type="text" maxlength="60" <?php if(isset($result)) { echo 'value=  "'.$result[0][3].'"'; }  ?>  class="form-control" name="shop_name" required/>
							<span id="hint" style="display:none" class="help-block">Address is only for verification & will not be shared with user </span>
						</div>
						
						<div class="form-group">
							
							<label> <b>Building</b> </label>
							<input type="text" maxlength="60" <?php if(isset($result)) echo 'value=  "'.$result[0][4].'"';  ?> class="form-control" name="building" required/>
						</div>
						<div class="form-group">
							<label> <b>locality</b> </label>
							<input type="text" maxlength="60" <?php if(isset($result)) echo 'value=  "'.$result[0][5].'"';  ?> class="form-control" name="locality" required/>
						</div>
						<div class="form-group">
							<label> <b>City</b> </label>
							<input type="text" maxlength="60" <?php if(isset($result)) echo 'value=  "'.$result[0][6].'"';  ?> class="form-control" name="city" required/>
						</div>
						<div class="form-group">
							<label> <b>State</b> </label>
							<input type="text" maxlength="60" <?php if(isset($result)) echo 'value=  "'.$result[0][7].'"';  ?> class="form-control" name="state" required/>
						</div>
						<div class="form-group">
							<label> <b>Pin</b> </label>
							<input type="number" onKeyPress="if(this.value.length==6) return false;" <?php if(isset($result)) echo 'value=  "'.$result[0][8].'"';  ?>  class="form-control" name="pin" required/>
						</div>
						<div id="google_map" style="width:500px;height:400px;"></div>
						<div class="form-group">
							<label> <b>Lat</b> </label>
							<input id="LATITUDE_ELEMENT_ID"  <?php if(isset($result)) echo 'value=  "'.$result[0][9].'"';  ?>  class="form-control" name="lat" readonly/>
						</div>
						<div class="form-group">
							<label> <b>Long</b> </label>
							<input id="LONGITUDE_ELEMENT_ID" <?php if(isset($result)) echo 'value=  "'.$result[0][10].'"';  ?>  class="form-control" name="long" readonly/>
						</div>
						
						<div class="form-group">
							<label> <b>Range (In Km</b> </label>
							<input type="number" onKeyPress="if(this.value.length==2) return false;" <?php if(isset($result)) echo 'value=  "'.$result[0][11].'"';  ?>  class="form-control" id="range" name="range"/>
						</div>
						<div class="form-group">
							<input type="hidden" name="shop_id" <?php if(isset($result)) echo 'value=  "'.$result[0][0].'"';  ?> />
							<input type="submit"   class="btn btn-primary btn-block" <?php echo(isset($result) ? 'value = "Update Shop"' : 'value = "Add Shop"'); ?> <?php echo(isset($result) ? 'name = "update_shop"' : 'name = "add_shop"'); ?> />
						</div>
						
					</form>
					
				</div>
				<div class="col-lg-3">
				</div>
				
				
			</div>
			
		</div>
	</body>
</html>




<script type="text/javascript">
	
	function edit_range() {
		if($('#shop_type :selected').val() == 0)
		{
			$('#range').prop('disabled', true);
			$('#range').prop('required', false);
			$('#hint').hide();
		}
		else {
			$('#range').prop('disabled', false);
			$('#range').prop('required', true);
			$('#hint').show();
			
		} 
	}	
	
	$("#shop_type").change(function(){
		edit_range();
		
		
	});
	
	window.onload = edit_range;
	
	
</script>


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
				draggable: true
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
					draggable: true
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




