<?php
	include('../asset/db.php');
	session_start();
	if(!isset($_SESSION['provider_id'])){
		$_SESSION['alert'] = "Log in first To continue to Shop Panel";
		header('Location:./login.php?redirect='.$_SERVER['REQUEST_URI']);
	}
	
	
	$query = "SELECT * FROM `shop` INNER JOIN `shop_cat` ON `shop`.`shop_cat_id`=`shop_cat`.`shop_cat_id` WHERE provider_id = '$_SESSION[provider_id]'";
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	
	if(isset($_POST['shop_id']))
	{
		$shop_id = $_POST['shop_id'];
	}
	else if(count($result) > 0) {
		$shop_id = $result[0][0];
	}
	
	if(count($result) > 0) {
		$query = "SELECT * FROM `shop_img` WHERE shop_id = '$shop_id'";
		$statement = $connection->prepare($query);
		$statement->execute();
		$result2 = $statement->fetchAll();
		
		
		$frontimg = $intimg = 0;
		foreach($result2 as $row)
		{
			if($row['img_type'] == 0)
			{
				$frontimg++;
			} else if($row['img_type'] == 1)
			{
				$intimg++;
			}
		}
	}
	
	
	
	
	
?>	



<html>
	<head>
		<title>Shop Detail | ShopOn</title>
		
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
			
			<center><img src="../src/logo.png"><h1 ><?= $_SESSION['name'] ?>'s Shop Management</h1></center>
			
		</div> 
		<div class="container box">
			
			<?php if(count($result) > 0)
				{ ?>
				<div>
					<div class="container-fluid">
						<form method="post" class="form-inline justify-content-center" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
							
							<div class="form-group mr-2">
								
								<label><b>Shop</b></label>
								<select name="shop_id" class="form-control ml-2">
									<?php foreach($result as $row) { ?>
										<option value="<?=$row['shop_id'] ?>" <?php if ($row['shop_id'] == $shop_id ) echo 'selected = "selected"';  ?> ><?= $row['shop_name'] ?> </option>
									<?php }  ?>
								</select>
								
							</div>
							<div class="form-group mr-2">
								<input type="submit" class="btn btn-primary" />
							</div>
							<div class="form-group mr-2">
								<a href="./add_shop.php" class="btn btn-primary ">Add More Shop</a>
							</div>
							
							<a href="./logout.php" class="btn btn-primary ">Log Out</a>
						</form>
						
					</div>
					<div class="card">
						<table  class="table table-borderless">
							<tbody>
								<?php foreach($result as $row) { 
									if($row['shop_id'] == $shop_id) { ?>
									
									<tr>
										<td><b>Shop name:</b></td>
										<td><?= $row['shop_name'] ?></td>
										<td><button id="edit_shop_id" shop_id="<?= $shop_id ?>" class="btn btn-success">Edit Shop</button></td>
									</tr>
									<tr >
										<td><b>Shop Address:</b></td>
										<td  ><?= $row['building'].'  '.$row['locality'] ?></td>
										<td><button id="manageshop_prod" shop_id="<?= $shop_id ?>" class="btn btn-info">Manage Shop Product/ Service</button></td>
									</tr>
									<tr>
										<td></td>
										<td><?= $row['city'].' '.$row['state'].' '.$row['pin'] ?></td>
									</tr>
									<tr>
										<td><b>Shop Category:</b></td>
										<td><?= $row['name'] ?></td>
									</tr>
									<tr>
										<td><b>Shop type:</b></td>
										<td><?= $row['shop_type']==0 ? "Physical" : "Virtual" ?></td>
									</tr>
									<?php break;
									}
								} ?>
							</tbody>
						</table>
						
						
					</div>
					
					
					
					<div id="frontCarousel" class="carousel slide row my-5" data-interval="false" >
						<div class="col-sm-3  my-auto" align="center">
							<button id ="add_frontimg" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#shopImgModal"> Add Front Image</button>
						</div>
						<?php if($frontimg > 0) 
							{ ?>
							<div class="col-sm-9">
								<div class="carousel-inner"  >
									<?php $i = 0;
										foreach($result2 as $row) {
											if($row['img_type'] ==0) {
											$i++; ?>	
											<div img_id="<?= $row['img_id'] ?>" img_path="<?= $row['img_path'] ?>" class="carousel-item <?= $i == 1 ? "active" : "" ;?>" align="center">
												<img src="../image/<?= $row['img_path']; ?>" style="width:auto; height:200px" >
											</div>
										<?php } } ?>
										
								</div>
								
								<ol class="carousel-indicators my-5" >
									<?php $i = 0;
										foreach($result2 as $row) {
											if($row['img_type'] ==0) {?>
											<li data-target="#frontCarousel" data-slide-to="<?= $i++; ?>" <?= $i==1 ? 'class = "active"':''; ?> ></li>
										<?php } } ?>
										
								</ol>
								
								
								<div  align="center">
									<a class="btn btn-primary btn-sm"  href="#frontCarousel" data-slide="prev">Prev</a>
									<button class="btn btn-danger btn-sm img_delete"  >Delete This</button>
									<a class="btn btn-primary btn-sm" href="#frontCarousel" data-slide="next">Next</a>
								</div>
							</div>
						<?php } ?>
					</div>
					
					
					<div id="interCarousel" class="carousel slide row my-5" data-interval="false" >
						<div class="col-sm-3  my-auto" align="center">
							<button id ="add_intimg" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#shopImgModal"> Add Interior Image</button>
						</div>
						<?php if($intimg > 0) 
							{ ?>
							<div class="col-sm-9">
								<div class="carousel-inner"  >
									<?php $i = 0;
										foreach($result2 as $row) {
											if($row['img_type'] ==1) {
											$i++; ?>
											<div img_id="<?= $row['img_id'] ?>" img_path="<?= $row['img_path'] ?>" class="carousel-item <?= $i == 1 ? "active" : "" ;?>" align="center" >
												<img  src="../image/<?= $row['img_path'] ?>" style="width:auto; height:200px"   >
											</div>
										<?php } } ?>
										
										
								</div>
								
								<ol class="carousel-indicators my-5" >
									<?php $i = 0;
										foreach($result2 as $row) {
											if($row['img_type'] ==1) {?>
											<li data-target="#interCarousel" data-slide-to="<?= $i++ ?>" <?= $i==1 ? 'class = "active"':''; ?> ></li>
										<?php } } ?>
										
										
								</ol>
								
								
								<div  align="center">
									<a class="btn btn-primary btn-sm"  href="#interCarousel" data-slide="prev">Prev</a>
									<button class="btn btn-danger btn-sm img_delete" >Delete This</button>
									<a class="btn btn-primary btn-sm" href="#interCarousel" data-slide="next">Next</a>
								</div>
							</div>
						<?php } ?>
					</div>
					
				</div>
				<?php 
				} else { ?>
				
				<div  >
					<h1>No Shop Added. Please Add your <a href="./add_shop.php">Shop</a></h1>
				</div>
				
			<?php } ?>
			
		</div>
	</body>
</html>




<div id="shopImgModal" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="shopimg_form" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Add Image</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					
				</div>
				<div class="modal-body">
					
					<label>Select Product Image</label><br>
					<input type="file" name="shop_image" id="shop_image" />
					<span id="user_uploaded_image"></span>
					
					
				</div>
				<div class="modal-footer">
					<input type="hidden" name="shop_id" id="shop_id" />
					<input type="hidden" name="img_type" id="img_type" />
					<input type="hidden" name="operation" id="operation" />
					<input type="submit" name="action" id="action" class="btn btn-success" value="Add Image" />
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>





<script type="text/javascript" language="javascript" >
	var shop_id = <?php echo $shop_id ?>;
	
	$(document).ready(function(){
		
		
		
		$('#add_frontimg').click(function(){
			$('#shopimg_form')[0].reset();
			$('.modal-title').text("Add Shop Front Image");
			$('#action').val("Add Front Image");
			$('#shop_id').val(shop_id);
			$('#img_type').val('0');
			$('#operation').val("addshop_image");
		});
		
		$('#add_intimg').click(function(){
			$('#shopimg_form')[0].reset();
			$('.modal-title').text("Add Shop Interior Image");
			$('#action').val("Add Interior Image");
			$('#shop_id').val(shop_id);
			$('#img_type').val('1');
			$('#operation').val("addshop_image");
		});
		
		$(document).on('click', '.img_delete', function(){
			
			var img_id = $(this).parent().siblings('.carousel-inner').children('.active').attr('img_id');
			var img_path = $(this).parent().siblings('.carousel-inner').children('.active').attr('img_path');
			
			if(confirm("Are you sure you want to delete this?"))
		{
		$.ajax({
		url:"action.php",
		method:"POST",
		data:{img_id:img_id, img_path:img_path},
		success:function(data)
		{
		alert(data);
		location.reload();
		
		}
		});
		}
		else
		{
		return false; 
		}
		
		});
		
		
		$(document).on('click', '#edit_shop_id', function(){
		
		var shop_id = $(this).attr('shop_id');
		
		
		
		
		var form = $('<form action="add_shop.php"  method = "post">' + 
		'<input type="text" name="shop_id" value="'+shop_id+'" />' +
		'<input type="text" name="edit_shop"  />' +
		'</form>');
		$('body').append(form);
		form.submit();
		});
		
		$(document).on('click', '#manageshop_prod', function(){
		
		var shop_id = $(this).attr('shop_id');
		
		
		
		
		var form = $('<form action="./shop_prod/index.php" method = "post">' + 
		'<input type="text" name="shop_id" value="'+shop_id+'" />' +
		'</form>');
		$('body').append(form);
		form.submit();
		});
		
		
		
		
		
		
		$(document).on('submit', '#shopimg_form', function(event){
		event.preventDefault();
		
		//var image_path = $('#prod_image').val();
		var extension = $('#shop_image').val().split('.').pop().toLowerCase();
		
		
		if(extension != '')
		{
		if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
		{
		alert("Invalid Image File");
		$('#shop_image').val('');
		return false;
		}
		
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