<?php
	include('./asset/db.php');
	session_start();
	if(!isset($_SESSION['user_id'])){
		$_SESSION['alert'] = "Log in first To continue";
		header('Location:./login.php?redirect='.$_SERVER['REQUEST_URI']);
	}
	if(!isset($_GET['prod_id']))
	{
		header('Location:./');
	}
	
	
	$query = "SELECT shop_product.*, product.*, shop.*, provider.mobile FROM shop_product 
	INNER JOIN `product` ON `shop_product`.`prod_id`=`product`.`prod_id` 
	INNER JOIN `shop`ON shop.shop_id = shop_product.shop_id
	INNER JOIN provider ON provider.provider_id = shop.provider_id WHERE shop_product.sp_pid = '$_GET[prod_id]'";
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	
	
	
	$query2 = "SELECT attrib_val, attrib_name FROM `prod_attrib` INNER JOIN attrib_val_list ON prod_attrib.attrib_val_id = attrib_val_list.attrib_val_id 
	INNER JOIN attrib_list ON attrib_val_list.attrib_id = attrib_list.attrib_id WHERE prod_id = ".$result[0][2]." ";
	$statement2 = $connection->prepare($query2);
	$statement2->execute();
	$result2 = $statement2->fetchAll();
	
	$query3 = "SELECT img_path FROM prod_image WHERE prod_id = ".$result[0][2]." 
	UNION SELECT img_path FROM shop_prod_img WHERE sp_pid = ".$result[0][0]." ";
	$statement3 = $connection->prepare($query3);
	$statement3->execute();
	$result3 = $statement3->fetchAll();
	
	
	
	
	$query4 = "SELECT feature FROM prod_feat WHERE prod_id = ".$result[0][2]." ";
	$statement4 = $connection->prepare($query4);
	$statement4->execute();
	$result4 = $statement4->fetchAll();
	
	
	
	
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
			<div id="myCarousel" class="carousel slide row" data-ride="carousel">
				<div class="col-md-6 bg-secondary">
					<ol class="carousel-indicators" >
						<?php $i = 0;
							foreach($result3 as $row) { ?>
							<li data-target="#myCarousel" data-slide-to="<?= $i++; ?>" <?= $i==1 ? 'class = "active"':''; ?>></li>
						<?php } ?>
					</ol>
					<div class="carousel-inner" >
						<?php $i = 0;
							foreach($result3 as $row) {
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
				
				<div class="col-md-6">
					<h4> <?= $result[0][6] ?></h4><br/>
					<?php if($result[0][3] < $result[0][7]) { ?>
						
						<h5>
							<div class="price-wrap mt-2">
								<span class="price">₹ <?= $result[0][3] ?></span>
								<del class="text-muted">₹ <?= $result[0][7] ?></del>
								<span class="text-success"><?= round(($result[0][7] - $result[0][3]) * 100 / $result[0][7]) ?> % discount  </span>
							</div>
						</h5>
						<?php } else { ?>
						<h5> ₹ <?=  $result[0][3] ?> </h5>
					<?php } ?>
					
					<?php if(count($result4) > 0) { ?>
						
						<ul class="my-5">
							<h5><b> About this item </b> </h5>
							<?php foreach($result4 as $row) { ?>
								<li> <?= $row['feature'] ?> </li>
							<?php } ?>
						</ul>
					<?php } ?>
				</div>
			</div>
			
			<div class="row my-5" >
				<?php if(count($result2) > 0 ) { ?>
					<div class="col-md-6">
						<table class="table table-striped table-bordered">
							<thead>
								<b> Detail</b>
								<thead>
									<tbody>
										<?php foreach($result2 as $row) { ?>
											<tr>
												<td> <?= $row['attrib_name'] ?> </td>
												<td> <?= $row['attrib_val'] ?> </td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
							<?php } else { ?>
							<div class="col-md-6">
								
							</div>
							
						<?php } ?>
						
						<?php if($result[0][8] != null ) { ?>
							<div class="col-md-6">
								<b> Description </b>
								<p> <?= $result[0][8] ?></p>
							</div>
						<?php } ?>
					</div>
					
					
					<div class="row my-5">
						<div class="col-md-6 card">
							<table class="table borderless">
								<tr>
									<td><?= $result[0][15] ?></td>
									<td><a align="right" href="./shop_page.php?shop_id=<?= $result[0][1] ?>" class="btn btn-success ">View provider</a></td>
									
								</tr>
								<?php if($result[0][14] == 0) { ?>
									<tr>
										<td><?= $result[0][16] ?></td>
									</tr>
									<tr>
										<td><?= $result[0][17] ?></td>
									</tr>
									<tr>
										<td><?= $result[0][18] ?></td>
									</tr>
									<?php } else { ?>
									<tr>
										<td><?= $result[0][18] ?> </td>
									</tr>
								<?php } ?>
							</table>
						</div>
						
						<div class="col-md-6">
							<?php if($result[0][14]==0 ) { ?>
								<iframe width="400px" height="200px" frameborder="0" style="border:0" loading="lazy" allowfullscreen src="https://www.google.com/maps/embed/v1/place?key=AIzaSyD9CJa7i9sWoGYszPsVxRCOL9N_RTdBTR4&q=<?=$result[0][21] ?>,<?= $result[0][22] ?>">
								</iframe>
								<?php } else { ?>
								<iframe width="400px" height="200px" frameborder="0" style="border:0" loading="lazy" allowfullscreen src="https://www.google.com/maps/embed/v1/view?key=AIzaSyD9CJa7i9sWoGYszPsVxRCOL9N_RTdBTR4&center=<?=$result[0][21] + rand()/getrandmax()*0.018- 0.009 ?>,<?= $result[0][22] + rand()/getrandmax()*0.018- 0.009 ?>&zoom=14">
								</iframe>
							<?php } ?>
						</div>
						
					</div>
				</div>
				
			</body>
			
		</html>															