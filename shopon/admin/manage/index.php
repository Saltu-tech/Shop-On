<?php
	
	session_start();
	
	if(!isset($_SESSION['admin_id'])){
		$_SESSION['alert'] = "Log in first To continue to Admin Panel";
		header('Location:../?redirect='.$_SERVER['REQUEST_URI']);
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Shopon Admin panel</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
		<link rel="stylesheet" href="../../src/bootstrap.min.css"> 
		<script defer src="../../src/all.js"></script>
		<script src="../../src/jquery.min.js"></script>
		<script src="../../src/popper.min.js"></script>
		<script src="../../src/bootstrap.min.js"></script>
		
		
		<style>
			.sidepanel{
			height:100%;
			width:0;
			position:fixed;
			
			z-index:11;
			left:0;
			top:0;
			background-color:white;
			overflow-x:hidden;
			transition:0.3s;
			}
			
			.sidepanel a{
			padding: 8px 8px 8px 32px;
			text-decoration:none;
			font-size: 25px;
			color: #818181;
			display: block;
			transition: 0.01s;
			}
			
			
			
			.sidepanel .closebtn{
			position: absolute;
			top:0;
			right:0;
			font-size:17px;
			color:white;
			background-color: grey;
			
			}
			
			.openbtn{
			color:white;
			background-color: grey;
			}
			
			.container .openbtn{
			position:absolute;
			top:10px;
			left:10px;
			}
			
			
			#overlay {
			position: fixed;
			display:none;
			top:-100;
			left:0;
			right:0;
			bottom:0;
			height: 100%;
			width:100%;
			background-color: rgba(0,0,0,0.5);  
			z-index:10;
			cursor:pointer;
			}
		</style>
		
		<script>
	        function openNav(){
				document.getElementById("mySidepanel").style.width = "250px";
				document.getElementById("overlay").style.display= "block";
				
			}
			
			function closeNav() {
				document.getElementById("mySidepanel").style.width = "0";
				document.getElementById("overlay").style.display= "none";
			}
		</script>
		
		
		
	</head>
	
	
	<body>
		<div id="overlay" onclick="closeNav()"></div>
		
		
		
		<header class="section-header bg-dark  navbar-dark ">
			<section class="header-main "> 
				<div class="container t-5  ">   
					<div class="row align-items-center ">
						<div class="col-lg-2 col-4 mt-4 mb-4">
							<button  class="btn openbtn" style="position:relative; left:0; top:0;"   type="button" onclick="openNav()" >
								<span class="navbar-toggler-icon"> </span>
							</button>
							
							
							
							<div id="mySidepanel" class="sidepanel">
								
								<button  class="btn closebtn"   type="button" onclick="closeNav()" >
									&times;
								</button>
								<div class="navbar-toggler" role="button" data-toggle="collapse" data-target="#collapsibleNavbar">
								</div>
								<a href="./"> Home </a>
								
								<a href="./manage_attrib/"> Manage Attribute</a>
								<a href="./manage_cat_subcat/">Manage Category & Subcategory </a>
								<a href="./manage_subcat_prod/"> Manage Subcat & product</a>
								<a href="./add_prod/"> Add product</a>
								<a href="./view/"> View</a>
								<a href="./add_shop_type/"> Add Shop Type</a>
								<a href="./add_mfrs/"> Manage Manufacturer</a>
								<hr/>
								<a href="../logout.php"> Sign out</a>
								<hr/>
								
							</div>
							
							<!--<a class="brand-wrap widget-header" style="position:relative; left:3rem;" href="./">Logo</a> -->
							<img  src="../../src/logo.png">
						</div>
						
						
						
						
					</div>     
				</div>
				
			</section>  
			
			
			
		</header>   
		
		<div class="container py-4">
			
			<div class="row">
				
			</div>
			
			
		</div> 
		
		
		
		
		
		
	</body>
	
	
	
</html>																					