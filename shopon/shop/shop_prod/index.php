<?php
	include('../../asset/db.php');
	session_start();
	if(!isset($_SESSION['provider_id'])){
		$_SESSION['alert'] = "Log in first To continue to Shop Panel";
		header('Location:../login.php?redirect='.$_SERVER['REQUEST_URI']);
	}
	
	if(isset($_POST['shop_id'])) {
		$_SESSION['shop_id'] = $_POST['shop_id'];
	}
	
	if(!isset($_SESSION['shop_id'])) {
		header('Location:../');
	}
	
	
	$query = "SELECT * FROM `category`";
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	
	
	$query = "SELECT * FROM `subcategory`";
	$statement = $connection->prepare($query);
	$statement->execute();
	$result2 = $statement->fetchAll();
	
	$query = "SELECT * FROM `shop` WHERE shop_id = '$_SESSION[shop_id]'";
	$statement = $connection->prepare($query);
	$statement->execute();
	$result3 = $statement->fetchAll();
	
?>	



<html>
	<head>
		<title>Manage Product | ShopOn</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> 
		<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>  
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
		
		
		
		
		
		
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
			td.details-control {
			background:url('../../asset/details_open.png') no-repeat center center; 
			cursor: pointer;
			
			}
			tr.shown td.details-control{
			background: url('../../asset/details_close.png') no-repeat center center;
			}
			
			div.slider {
			display:none;
			}
			
			table.dataTable tbody td.no-padding {
			padding:0;
			}
		</style>
	</head>
	<body>
		<div class="container box">
			<a href="../"> Home </a>
			<h1 align="center"><?= $_SESSION['name'] ?>'s Shop Product / Service Management</h1>
			<br />
			
			<center>
				
				<select class="custome-select" id="category" >
					<option value="0" selected>Please Select</option>
					<?php foreach($result as $row) { ?>
						<option value="<?=$row['cat_id'] ?>"><?= $row['cat_name'] ?> </option>
					<?php }  ?>
					
				</select>
				
				<select class="custome-select" id="subcat" style="display:none">
					
					
				</select> 
			</center>
			
			<div class="table-responsive">
				<center><h1><b> Product / Service Catalogue </b> </h1></center>
				<table id="product_data" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th width="5%"> </th> 
							<th width="20%">Product Name</th>
							<th width="10%">Product Price</th>
							<th width="30%">Product Desc</th>
							<th width="10%">Manufactrer</th>
							<th width="10%">Type(Pro/ Service)</th>
							<th width="5%">Edit</th>
							
						</tr>
					</thead>
				</table>
				
			</div>
			
			<div class="card float-left" style="margin:150px 20% 50px 20%;"   >
				<table  class="table table-borderless"  >
					<tbody >
						<h3 class="card-title" align ="center"><b>Shop Detail</b> </h3>
						<tr>
							<td><label>Shop Name</label> </td>
							<td> <?= $result3[0]['shop_name']  ?></td>
						</tr>
						<tr >
							<td><b>Shop Address:</b></td>
							<td  ><?= $result3[0]['building'].'  '.$result3[0]['locality'] ?></td>
						</tr>
						<tr>
							<td></td>
							<td><?= $result3[0]['city'].' '.$result3[0]['state'].' '.$result3[0]['pin'] ?></td>
						</tr>
					</tbody>
				</table>
			</div>
			
			
			
			
			<div class="table-responsive">
				<center><h1><b> Shop Product / Service List </b> </h1></center>
				<table id="shop_prod_data" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th width="5%"> </th> 
							<th width="20%">Product Name</th>
							<th width="10%">Product Price / MRP</th>
							<th width="30%">Product Desc</th>
							<th width="10%">Manufactrer</th>
							<th width="10%">Type(Pro/ Service)</th>
							<th width="5%">Edit</th>
							
						</tr>
					</thead>
				</table>
				
			</div>
		</div>
	</body>
</html>


<div id="prodModal" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="prod_form" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add Product</h4>
				</div>
				<div class="modal-body">
					
					
					<label>Product Price</label>
					<input type="text" name="prod_price" id="prod_price" class="form-control" />
					
					
				</div>
				<div class="modal-footer">
					<input type="hidden" name="prod_id" id="prod_id" />
					<input type="hidden" name="shop_id" id="shop_id" />
					<input type="hidden" name="operation" id="operation" />
					<input type="submit" name="action" id="action" class="btn btn-success" value="Add Product" />
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>

<div id="imgModal" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="img_form" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add Image</h4>
				</div>
				<div class="modal-body">
					
				    <label>Select Product Image</label>
                    <input type="file" name="prod_image" id="prod_image" />
					<span id="user_uploaded_image"></span>
					
					
				</div>
				<div class="modal-footer">
					<input type="hidden" name="sp_pid" id="sp_pid" />
					<input type="hidden" name="operation" id="operation2" />
					<input type="submit" name="action"  class="btn btn-success" value="Add Image" />
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>






<script type="text/javascript" language="javascript" >
	
	var subcategory = <?= json_encode($result2) ?>;
	var subcat_id = null;
	var shop_id = <?= $_SESSION['shop_id'] ?>;
	var dataTable;
	$(document).ready(function(){
		show_data();
		
		$(document).on('click', '.add_prod', function(){
			var prod_id = $(this).attr("id");
			var prod_name = $(this).attr("idn");
			
			$('.modal-title').text("Add product " +prod_name );
			$('#prod_id').val(prod_id);
			$('#shop_id').val(shop_id);
			$('#action').val("Add Product");
			$('#operation').val("add_product");
			
			$('#prodModal').modal('show');
			
			
		});
		
		$(document).on('click', '.delete_prod', function(){
			
			var sp_pid = $(this).attr('id');
			
			
			if(confirm("Are you sure you want to delete this?"))
			{
				$.ajax({
					url:"action.php",
					method:"POST",
					data:{"sp_pid":sp_pid,
						"operation":"delete_prod"
						},
					success:function(data)
					{
						alert(data);
						shopdataTable.ajax.reload();
						dataTable.ajax.reload();
						
					}
				});
			}
			else
			{
				return false; 
			}
			
		});
		
		
		$(document).on('click', '.add_img', function(){
			var sp_pid = $(this).attr("id");
			var prod_name = $(this).attr("idn");
			$('#img_form')[0].reset();
			$('.modal-title').text("Add Image For " +prod_name );
			$('#sp_pid').val(sp_pid);
			$('#operation2').val("add_image");
			
			$('#imgModal').modal('show');
			
			
		});
		
		
		$(document).on('click', '.delete_img', function(){
			var sp_img_id = $(this).attr("id");
			var img_path = $(this).attr("img_path");
			
			if(confirm("Are you sure you want to delete this?"))
			{
				$.ajax({
					url:"action.php",
					method:"POST",
					data:{"sp_img_id":sp_img_id,
						 "img_path":img_path,
						"operation":"delete_image"
						},
					success:function(data)
					{
						alert(data);
						shopdataTable.ajax.reload();
					}
				});
			}
			else
			{
				return false; 
			}
		});
		
		
		
		$(document).on('submit', '#prod_form', function(event){
			event.preventDefault();
			var prod_price = $('#prod_price').val();
			
			if(prod_price != '' )
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
						$('#prod_form')[0].reset();
						$('#prodModal').modal('hide');
						shopdataTable.ajax.reload();
						dataTable.ajax.reload();
					}
				});
			}
			else
			{
				alert("All Fields are Required");
			} 
		});
		
		
		
		
		$(document).on('submit', '#img_form', function(event){
			event.preventDefault();
			
			
			var extension = $('#prod_image').val().split('.').pop().toLowerCase();
			
			
			if(extension != '')
			{
				if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
				{
					alert("Invalid Image File");
					$('#prod_image').val('');
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
						$('#img_form')[0].reset();
						$('#imgModal').modal('hide');
						shopdataTable.ajax.reload();
					}
				});
			} 
			else
			{
				alert("All Fields are Required");
			} 
		});
		
		
		
		
		
		
		
		var shopdataTable = $('#shop_prod_data').DataTable({
			"processing":true,
			"serverSide":true,
			"order":[],
			"ajax":{
				url:"fetch.php",
				data: {
					"shop_id" : shop_id,
					"operation" : "shop_data"
				},	
				type:"POST"
			},
			"columnDefs":[
			{
				"targets":[0,3,4,5],
				"orderable":false
			},
			{
				"className":'details-control',
				"defaultContent": '',
				"data": null,
				"targets" : [0]
			}
			
			],
			
		});
		
		
		
		
		$('#shop_prod_data tbody').on('click', 'td.details-control', function() {
			
			var tr = $(this).closest('tr');
			var row = shopdataTable.row(tr);
			
			if(row.child.isShown() ){
				
				$('div.slider', row.child()).slideUp( function () {
					row.child.hide();
					tr.removeClass('shown');
					
				});
				
				
				
			}
			else {
				row.child(format(row.data()), 'no-padding').show();
				tr.addClass('shown');
				
				$('div.slider', row.child()).slideDown();
			}
			
		}); 
		
		
		
		function format(d) {
			
			
			var child_row  = '<div class="slider">';
			child_row += '<table class="table"  >';
			
			child_row += '<tr><td><b>Attribute</b></td></tr>';
			$.each(d[7],function(index){ 
				
				child_row += '<tr>';
				child_row += '<td>' +d[7][index][0]+'</td>';
				child_row += '<td>' +d[7][index][1]+'</td>';
				child_row += '</tr>'
				
			});	
			
			
			child_row += '<tr><td><b>Feature</b></td></tr>';
			$.each(d[11],function(index){ 
				
				child_row += '<tr>';
				child_row += '<td>' +d[11][index][0]+'</td>';
				child_row += '</tr>'
				
			}); 
			
			child_row += '<tr><td><b>Image</b></td></tr>';
			$.each(d[8],function(index){ 
				
				child_row += '<tr>';
				child_row += '<td><img src="../../image/'+d[8][index][0]+'" class="img-thumbnail" width="50" height="35" /></td>';
				child_row += '</tr>'
				
			});	
			
			
			child_row += '<tr><td><button type="button" id="'+d[10]+'" idn="'+d[2]+'" data-toggle="modal" data-target="#imgModal" class="btn btn-success btn-xs add_img">Add Image</button></td></tr>';
			
			$.each(d[9],function(index){ 
				
				child_row += '<tr>';
				child_row += '<td><img src="../../image/'+d[9][index][0]+'" class="img-thumbnail" width="50" height="35" /></td>';
				child_row += '<td>' +d[9][index][1]+'</td>';
				child_row += '</tr>'
				
			});	
			
			
			
			child_row += '</table>';
			child_row +=  '</div>';
			
			return child_row;
			
			
		}
		
		
		
		
		
		
		
		
	});
	
	
	$(function(){
		$("#category").change(function(){
			if($(this).val() == '0')
			{
				$("#subcat").hide();
				$("#subcat").val('0');
				if(subcat_id != null)
				{
					subcat_id = null;
					if ($.fn.dataTable.isDataTable('#product_data'))
					{
						
						$('#product_data').DataTable().destroy();
					}
					show_data();
				}
				
			} else 
			{
				var cat_id = $(this).val();
				var subcat_name = '';
				subcat_name += '<option value="0" selected>Please Select</option>'
				$.each(subcategory, function(index){
					if(subcategory[index][1] == cat_id)
					{
						subcat_name += '<option value="'+subcategory[index][0]+'">'+subcategory[index][2]+'</option>';
					}
					
				});
				
				$("#subcat").html(subcat_name);
				$("#subcat").show();
				
				if(subcat_id != null)
				{
					subcat_id = null;
					if ($.fn.dataTable.isDataTable('#product_data'))
					{
						
						$('#product_data').DataTable().destroy();
					}
					show_data();
				}
			}
		});
		
		
		$("#subcat").change(function(){
			if($(this).val() == '0')
			{
				if(subcat_id != null)
				{
					subcat_id = null;
					if ($.fn.dataTable.isDataTable('#product_data'))
					{
						
						$('#product_data').DataTable().destroy();
					}
					show_data();
				}
				
			} else 
			{
				subcat_id = $(this).val();
				
				if ($.fn.dataTable.isDataTable('#product_data'))
				{
					
					$('#product_data').DataTable().destroy();
					
				}
				show_data();
			}
		});
	});
	
	
	function show_data(){
		
		    dataTable = $('#product_data').DataTable({
			"processing":true,
			"serverSide":true,
			"order":[],
			"ajax":{
				url:"fetch.php",
				data: {
					"subcat_id" : subcat_id,
					"shop_id" : shop_id,
					"operation" : "prod_data"
				},	
				type:"POST"
			},
			"columnDefs":[
			{
				"targets":[0,3,4,5],
				"orderable":false
			},
			{
				"className":'details-control',
				"defaultContent": '',
				"data": null,
				"targets" : [0]
			}
			
			],
			
		});
		
		
		
		
		$('#product_data tbody').on('click', 'td.details-control', function() {
			
			var tr = $(this).closest('tr');
			var row = dataTable.row(tr);
			
			if(row.child.isShown() ){
				
				$('div.slider', row.child()).slideUp( function () {
					row.child.hide();
					tr.removeClass('shown');
					
				});
				
				
				
			}
			else {
				row.child(format(row.data()), 'no-padding').show();
				tr.addClass('shown');
				
				$('div.slider', row.child()).slideDown();
			}
			
		}); 
		
		
		
		function format(d) {
			
			
			var child_row  = '<div class="slider">';
			child_row += '<table class="table"  >';
			
			child_row += '<tr><td><b>Attribute</b></td></tr>';
			$.each(d[7],function(index){ 
				
				child_row += '<tr>';
				child_row += '<td>' +d[7][index][0]+'</td>';
				child_row += '<td>' +d[7][index][1]+'</td>';
				child_row += '</tr>'
				
			});	
			
			child_row += '<tr><td><b>Feature</b></td></tr>';
			$.each(d[9],function(index){ 
				
				child_row += '<tr>';
				child_row += '<td>' +d[9][index][0]+'</td>';
				child_row += '</tr>'
				
			});
			
			child_row += '<tr><td><b>Image</b></td></tr>';
			$.each(d[8],function(index){ 
				
				child_row += '<tr>';
				child_row += '<td><img src="../../image/'+d[8][index][0]+'" class="img-thumbnail" width="50" height="35" /></td>';
				child_row += '</tr>'
				
			});	
			
			
			
			child_row += '</table>';
			child_row +=  '</div>';
			
			return child_row;
			
			
		}
		
		
	}
</script>						