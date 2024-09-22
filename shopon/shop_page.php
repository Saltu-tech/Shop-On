<?php
	include('./asset/db.php');
	session_start();
	if(!isset($_SESSION['user_id'])){
		$_SESSION['alert'] = "Log in first To continue";
		header('Location:./login.php?redirect='.$_SERVER['REQUEST_URI']);
	}
	if(!isset($_GET['shop_id']))
	{
		header('Location:./');
	}
	
	
	$query = "SELECT *, shop_cat.name as category FROM `shop` INNER JOIN `shop_cat` ON `shop`.`shop_cat_id`=`shop_cat`.`shop_cat_id` 
	INNER JOIN `provider`ON provider.provider_id = shop.provider_id WHERE shop_id = '$_GET[shop_id]'";
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	
	
	
	$query = "SELECT * FROM `shop_img` WHERE shop_id = '$_GET[shop_id]'";
	$statement = $connection->prepare($query);
	$statement->execute();
	$result2 = $statement->fetchAll();
	
	$query = "SELECT product.*, shop_product.*, prod_image.img_path FROM `product` 
	INNER JOIN `shop_product` ON shop_product.prod_id = product.prod_id AND shop_product.shop_id = '$_GET[shop_id]' AND shop_product.status = 0 
	LEFT JOIN prod_image ON prod_image.img_id = (SELECT prod_image.img_id FROM prod_image WHERE product.prod_id = prod_image.prod_id ORDER BY prod_image.img_id LIMIT 1)";
	$statement = $connection->prepare($query);
	$statement->execute();
	$result3 = $statement->fetchAll();
	
	
?>










<!DOCTYPE html>
<html>
	<head>
		<title>Shop Page | ShopOn</title>
		
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
			
			.borderless td, .borderless th {
			border : none;
			}
			
		</style>
	</head>
	
	
	<body>
		
		
		
		<header class="section-header bg-dark  navbar-dark ">
			<section class="header-main "> 
				<div class="container t-5  ">   
					<div class="row align-items-center ">
						<div class="col-lg-2 col-4 mt-4 mb-4">
							
							<a href="./" ><img  src="./src/logo.png"/></a>
						</div>
						
						
					</div>     
				</div>
				
			</section>  
			
			
			
		</header>   
		
		<div class="container box">
			<div id="myCarousel" class="carousel slide" data-ride="carousel" align="center">
				
				<ol class="carousel-indicators" >
					<?php $i = 0;
						foreach($result2 as $row) { ?>
						<li data-target="#myCarousel" data-slide-to="<?= $i++; ?>" <?= $i==1 ? 'class = "active"':''; ?>></li>
					<?php } ?>
				</ol>
				<div class="carousel-inner" >
					<?php $i = 0;
						foreach($result2 as $row) {
							$i++; ?>
							<div class="carousel-item <?= $i == 1 ? "active" : "" ;?>" data-interval="4000" align="center">
								<img src="./image/<?= $row['img_path']; ?>" style="width:auto; height:300px"   >
							</div>
						<?php  } ?>
				</div>
				
				<a class="carousel-control-prev" href="#myCarousel"  role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				
				<a class="carousel-control-next" href="#myCarousel"  role="button" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
			
			
			<div class="card">
				<table  class="table borderless">
					<tbody>
						
							
							<tr>
								<td><b>Shop name:</b></td>
								<td><?= $result[0]['shop_name'] ?></td>
							</tr>
							<?php if($result[0]['shop_type']==0) { ?>
								<tr >
									<td><b>Shop Address:</b></td>
									<td  ><?= $result[0]['building'].'  '.$result[0]['locality'] ?></td>
								</tr>
								
								<tr>
									<td></td>
									<td><?= $result[0]['city'].' '.$result[0]['state'].' '.$result[0]['pin'] ?></td>
								</tr>
								<?php } 
							    else {?>
								<tr>
									<td><b>Mobile no:</b></td>
									<td><?= $result[0]['mobile'] ?></td>
								</tr>
								
							<?php } ?>
							<tr>
								<td><b>Shop Category:</b></td>
								<td><?= $result[0]['category'] ?></td>
							</tr>
							<tr>
								<td><b>Shop type:</b></td>
								<td><?= $result[0]['shop_type']==0 ? "Physical" : "Virtual" ?></td>
							</tr>
					
					</tbody>
					
				</table>
				<?php if($result[0]['shop_type']==0 ) { ?>
				<iframe width="400px" height="200px" frameborder="0" style="border:0" loading="lazy" allowfullscreen src="https://www.google.com/maps/embed/v1/place?key=AIzaSyD9CJa7i9sWoGYszPsVxRCOL9N_RTdBTR4&q=<?=$result[0]['lat'] ?>,<?= $result[0]['longt'] ?>">
					</iframe>
				<?php } else { ?>
				<iframe width="400px" height="200px" frameborder="0" style="border:0" loading="lazy" allowfullscreen src="https://www.google.com/maps/embed/v1/view?key=AIzaSyD9CJa7i9sWoGYszPsVxRCOL9N_RTdBTR4&center=<?=$result[0]['lat'] + rand()/getrandmax()*0.018- 0.009 ?>,<?= $result[0]['longt'] + rand()/getrandmax()*0.018- 0.009 ?>&zoom=14">
					</iframe>
				<?php } ?>
				
			</div>
			
			<div class="row">
			<?php foreach($result3 as $row) { ?>
				
			<div class="card mx-auto my-3" style="width: 18rem;">
				<img class="card-img-top" style="width:auto; height:200px" src="./image/<?=$row['img_path'] ?>">
				<div class="card-body">
					<h5 class="card-title"> <?=$row['prod_name'] ?> </h5>
					<p class="card-text"><b>₹ <?=$row['price'] ?> </b> </p>
					<a href="./product_page.php?prod_id=<?=$row['sp_pid'] ?>" class="btn btn-success stretched-link">View</a> <b > <?= $row['type']==0 ? "Service" : "Product" ?></b>
					
				</div>
				
			</div>
			<?php } ?>
			</div>
		</div>
		
	</body>
	
</html>			