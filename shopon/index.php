<?php
	include('./asset/db.php');
	session_start();
	if(!isset($_SESSION['user_id'])){
		$_SESSION['alert'] = "Log in first To continue";
		header('Location:./login.php?redirect='.$_SERVER['REQUEST_URI']);
	}
	
	$_SESSION['shop_count'] = 0;
	$_SESSION['prod_count'] = 0;
	$_SESSION['query1'] = '';
	$_SESSION['query2'] = '';
	
	$query = "SELECT * FROM user WHERE user_id = '$_SESSION[user_id]'";
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	
	$lat = $result[0]['lat'];
	$longt = $result[0]['longt'];
	$range = $result[0]['ranged'];
	if(isset($_GET['range']) && $_GET['range'] != $range )
	{
		$range = $_GET['range'];
		$statement = $connection->prepare("
		UPDATE user SET ranged = :range WHERE user_id = :user_id
		");
		$statement->execute(
		array(
		':range' => $range,
		':user_id'  => $_SESSION['user_id']
		)
		);
	}
	
	if($lat == null || $longt == null)
	{ 
		
		echo '<a href="./user_profile.php">Update profile </a> and set your location';
	}
	else if(isset($_GET['search_key']))
	{
		$query = "SELECT *, (6371 * acos( cos( radians($lat)) * cos( radians(shop.lat)) * cos(radians(shop.longt) - radians($longt) ) + sin(radians($lat)) * sin(radians(shop.lat)))) AS distance FROM shop 
		INNER JOIN shop_cat ON shop.shop_cat_id = shop_cat.shop_cat_id
		INNER JOIN `provider`ON provider.provider_id = shop.provider_id
		LEFT JOIN shop_img ON shop_img.img_id = (SELECT shop_img.img_id FROM shop_img WHERE shop_img.shop_id = shop.shop_id ORDER BY shop_img.img_id LIMIT 1) 
		WHERE shop_cat.keyword LIKE '%$_GET[search_key]%' OR shop.shop_name LIKE '%$_GET[search_key]%' HAVING distance < '$range' ORDER BY distance LIMIT 3";
		$statement = $connection->prepare($query);
		$statement->execute();
		$result2 = $statement->fetchAll();
		
		$_SESSION['query1'] = $query;
		
		$query = "SELECT *, (6371 * acos( cos( radians($lat)) * cos( radians(shop.lat)) * cos(radians(shop.longt) - radians($longt) ) + sin(radians($lat)) * sin(radians(shop.lat)))) AS distance FROM `product` 
		INNER JOIN `shop_product` ON shop_product.prod_id = product.prod_id  AND shop_product.status = 0 
		INNER JOIN `shop` ON shop_product.shop_id = shop.shop_id
		LEFT JOIN prod_image ON prod_image.img_id = (SELECT prod_image.img_id FROM prod_image WHERE product.prod_id = prod_image.prod_id ORDER BY prod_image.img_id LIMIT 1) 
		WHERE product.prod_name LIKE '%$_GET[search_key]%' OR product.prod_desc LIKE '%$_GET[search_key]%' OR product.keyword LIKE '%$_GET[search_key]%' HAVING distance < '$range' ORDER BY distance LIMIT 3";
		$statement = $connection->prepare($query);
		$statement->execute();
		$result3 = $statement->fetchAll(); 
		
		$_SESSION['query2'] = $query;
		
		
	} else 
	
	{
		$query = "SELECT *, (6371 * acos( cos( radians($lat)) * cos( radians(shop.lat)) * cos(radians(shop.longt) - radians($longt) ) + sin(radians($lat)) * sin(radians(shop.lat)))) AS distance FROM shop 
		INNER JOIN shop_cat ON shop.shop_cat_id = shop_cat.shop_cat_id
		INNER JOIN `provider`ON provider.provider_id = shop.provider_id
		LEFT JOIN shop_img ON shop_img.img_id = (SELECT shop_img.img_id FROM shop_img WHERE shop_img.shop_id = shop.shop_id ORDER BY shop_img.img_id LIMIT 1) HAVING distance < '$range' ORDER BY distance LIMIT 3";
		$statement = $connection->prepare($query);
		$statement->execute();
		$result2 = $statement->fetchAll();
		
		$_SESSION['query1'] = $query;
		
		
		$query = "SELECT *, (6371 * acos( cos( radians($lat)) * cos( radians(shop.lat)) * cos(radians(shop.longt) - radians($longt) ) + sin(radians($lat)) * sin(radians(shop.lat)))) AS distance FROM `product` 
		INNER JOIN `shop_product` ON shop_product.prod_id = product.prod_id  AND shop_product.status = 0 
		INNER JOIN `shop` ON shop_product.shop_id = shop.shop_id
		LEFT JOIN prod_image ON prod_image.img_id = (SELECT prod_image.img_id FROM prod_image WHERE product.prod_id = prod_image.prod_id ORDER BY prod_image.img_id LIMIT 1) HAVING distance < '$range' ORDER BY distance LIMIT 3";
		$statement = $connection->prepare($query);
		$statement->execute();
		$result3 = $statement->fetchAll();  
		
		$_SESSION['query2'] = $query;
		
	}
	
	
	
	/*print "<pre>";
	print_r ($result2[0]);
	print "</pre>";  
	
	
	print "<pre>";
	print_r ($result3[0]);
	print "</pre>"; */
	
	
?>	



<html>
	<head>
		<title>ShopOn | Digital Showroom</title>
		
		
		<link rel="stylesheet" href="./src/bootstrap.min.css"> 
		<script defer src="./src/all.js"></script>
		<script src="./src/jquery.min.js"></script>
		<script src="./src/popper.min.js"></script>
		<script src="./src/bootstrap.min.js"></script>
		
		
		
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
			.borderless td, .borderless th {
			border : none;
			}
			
		</style>
	</head>
	<body>
		<header class="section-header bg-dark  navbar-dark ">
			<section class="header-main "> 
				<div class="container   ">   
					
					
					<div class="row align-items-center">
						<div class="col-lg-3 col-4">
							
							<a   href="./"><img  src="./src/logo.png"/></a>
						</div>
						
						
						<div class="col-lg-6 col-sm-12 order-3 order-lg-2 my-4" align="center">
							<form  method="get" action ="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" >
								<div class="input-group"  >
									
									<select class="custome-select"  name="range">
				                        <option value="0.1" <?= $range == 0.1 ? ' selected="selected"' : ''; ?> > 100 Mtr</option>
					                    <option value ="0.5" <?= $range == 0.5 ? ' selected="selected"' : ''; ?>> 500 Mtr</Option>
										<option value ="1" <?= $range == 1 ? ' selected="selected"' : ''; ?>> 1 Km</Option>
										<option value ="5" <?= $range == 5 ? ' selected="selected"' : ''; ?>> 5 Km</Option>
										<option value ="10" <?= $range == 10 ? ' selected="selected"' : ''; ?>> 10 Km</Option>
										<option value ="50" <?= $range == 50 ? ' selected="selected"' : ''; ?>> 50 Km</Option>
									</select>
									<input type="text" name="search_key" value="<?= isset($_GET['search_key']) ? $_GET['search_key'] : ""  ?>" class="form-control"   placeholder="search anything">
									<div class="input-group-append"><button class="btn btn-warning"  type="submit"><i class="fas fa-search"></i></button>
									</div>
									
									
									
								</div>		 
							</form>		
						</div>
						
						<div class="col-lg-3 col-sm-6 col-8 order-2 order-lg-3">
							<div class="d-flex justify-content-end"> 
								
								
								<a class="widget-header" href="./user_profile.php"><i class="fa fa-user-cog"></i> <?php echo ($_SESSION['name']); ?></a>
								<a class="widget-header ml-3" href="#" data-toggle="modal" data-target="#locationModal"><i class="fa fa-map-marker"></i> Update location</a>
								
								
								
								
							</div>
						</div>  
					</div>   
				</div>
				
			</section>  
			
			
			
		</header>
		
		
		<div class="container box">
			<?php 
				if($lat == null || $longt == null)
				{ ?>
				
				<a href="./user_profile.php">Update profile </a> and set your location';
				<?php	} else {
					if(count($result2) > 0) {
					?> 
					<center><h3> Shop / Provider List </h3></center>
 					<div class="row" id="shop_data"> <?php
						foreach ($result2 as $row) {?>
						
						<div class="card mx-auto my-3" style="width: 18rem;">
							<img class="card-img-top" style="width:auto; height:200px" src="./image/<?=$row['img_path'] ?>">
							<div class="card-body">
								<table class="table borderless">
									<colgroup>
										<col span="1" style="width: 70%;">
										<col span="1" style="width: 30%;">
									</colgroup>
									<tbody>
										<tr>
											<td> <?=$row['shop_name'] ?></td>
											<td> <a  href="./shop_page.php?shop_id=<?= $row['shop_id'] ?>" class="btn btn-success btn-sm">View provider</a> </td>
										</tr>
										<tr>
											<?php if($row['shop_type'] ==0) { ?>
												<td><?=$row['building']." ".$row['locality'] ?> </td>
												<?php } else { ?>
												<td><?=$row['mobile'] ?> </td>
											<?php } ?>
											<td><?= round($row['distance'], 2) ?> Km </td>
										</tr>
									</tbody>
								</table>
							</div>
							
						</div>
						
						
						<?php }
						
					?> </div> 
					<center><button class="btn btn-success mb-5" id="shop_load"> Load More </button></center>
					<?php } 
					if(count($result3) > 0) {?>
					<center><h3> Product / Service List </h3></center>
					<div class="row mt-5" id="prod_data"><?php
						
						foreach($result3 as $row) { ?>
						<div class="card mx-auto my-3" style="width: 18rem;">
							<img class="card-img-top" style="width:auto; height:200px" src="./image/<?=$row['img_path'] ?>">
							<div class="card-body">
								<table class="table borderless">
									<colgroup>
										<col span="1" style="width: 70%;">
										<col span="1" style="width: 30%;">
									</colgroup>
									<tbody>
										<tr>
											<td> <?=$row['prod_name'] ?></td>
											<td> ₹ <?=$row['price'] ?> </td>
										</tr>
										<tr>
											<td><?=$row['shop_name'] ?> </td>
											<td><?= round($row['distance'], 2) ?> Km <a href="./product_page.php?prod_id=<?= $row['sp_pid'] ?>" class="btn btn-success btn-sm">View Product</a> </td>
										</tr>
									</tbody>
								</table>
							</div>
							
						</div>
						<?php 	}
					?> </div>
					<center><button class="btn btn-success" id="prod_load"> Load More </button></center>
					<?php }
					
					if(count($result2) ==0 && count($result3) == 0) {
						if(isset($_GET['search_key'])) {
						?>
						<div> No Search Result for <?= $_GET['search_key'] ?> Please modify search query  </div>
						
						<?php
							} else {
						?>
						<div>  Please modify search Area  </div>
						
						<?php
						}
					}
				} ?> 
		</div> 
	</body>
</html>




<div id="locationModal" class="modal fade">
<div class="modal-dialog">
<form method="post" id="location_form" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Set Your Location</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					
				</div>
				<div class="modal-body">
					
					<div id="google_map" style="width:400px;height:400px;"></div>
					<div class="form-group">
						<label> <b>Lat</b> </label>
						<input id="LATITUDE_ELEMENT_ID"  value ="<?= $result[0][7]; ?>" class="form-control" name="lat" required readonly/>
					</div>
					<div class="form-group">
						<label> <b>Long</b> </label>
						<input id="LONGITUDE_ELEMENT_ID" value ="<?= $result[0][8]; ?>"  class="form-control" name="long" required readonly/>
					</div>
					
					
				</div>
				<div class="modal-footer">
					<input type="hidden" name="operation" value="set_location" />
					<input type="submit" name="action"  class="btn btn-success" value="Set Current location" />
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>





<script type="text/javascript" language="javascript" >
	
	$(document).ready(function(){
		
		
		$(document).on('click','#shop_load', function(){
			$('#shop_load').html('Loading...');
			$.ajax({
				url : "load_more.php",
				type: "POST",
				data: {operation: "shop_data"},
				success:function(data){
					if($.trim(data) != ''){
						$('#shop_data').append(data);
						$('#shop_load').html('Load More');
					} 
					else {
						$('#shop_load').prop("disabled", true);
						$('#shop_load').html('That is All');
					
					}
				}
				
				
				
			});
			
		});
		
		
		$(document).on('click','#prod_load', function(){
			$('#prod_load').html('Loading...');
			
			$.ajax({
				url : "load_more.php",
				type: "POST",
				data: {operation: "prod_data"},
				success:function(data){
					if($.trim(data) != ''){
						$('#prod_data').append(data);
						$('#prod_load').html('Load More');
					} 
					else {
						$('#prod_load').prop("disabled", true);
						$('#prod_load').html('That is All');
					
					}
				}
				
				
				
			});
			
			
			
		}); 
		
		
		
		
		
		
		
		
		$(document).on('submit', '#location_form', function(event){
			event.preventDefault();
			var lat = $('#LATITUDE_ELEMENT_ID').val();
			var longt = $('#LONGITUDE_ELEMENT_ID').val();
			
			if(lat != '' && longt != '' )
			{
				$.ajax({
					url:"action.php",
					method:'POST',
					data:new FormData(this),
					contentType:false,
					processData:false,
					success:function(data)
					{
						alert(data);
						location.reload();
					}
				});
			}
			else
			{
				alert("All Fields are Required");
			} 
		});
		
		
	});
	
	
	
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
