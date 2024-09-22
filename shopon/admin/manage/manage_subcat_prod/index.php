<?php
	include('../../../asset/db.php');
	session_start();
	if(!isset($_SESSION['admin_id'])){
		$_SESSION['alert'] = "Log in first To continue to Admin Panel";
		header('Location:../../?redirect='.$_SERVER['REQUEST_URI']);
	}
	
	
	$query = "SELECT * FROM `category`";
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	
	
	$query = "SELECT * FROM `subcategory`";
	$statement = $connection->prepare($query);
	$statement->execute();
	$result2 = $statement->fetchAll();
?>	



<html>
	<head>
		<title>Manage Subcategory & Product | ShopOn</title>
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
			background:url('../../../asset/details_open.png') no-repeat center center; 
			cursor: pointer;
			
			}
			tr.shown td.details-control{
			background: url('../../../asset/details_close.png') no-repeat center center;
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
			<h1 align="center"><?= $_SESSION['name'] ?>'s Subcategory & its Product Type</h1>
			<br />
			
			
			
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
			
			
			
			
			<center style="margin:150px 20% 50px 20%;">
				
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
				<center><h1><b> Subcategory & product </b> </h1></center>
				<table id="subcat_prod_data" class="table table-bordered table-striped">
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
















<div id="subcatprodModal" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="subcatprod_form" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add Subcategory</h4>
				</div>
				<div class="modal-body">
					
					<center>
						
						<select class="custome-select" id="subcatprod_category" >
							<option value="0" selected>Please Select</option>
							<?php foreach($result as $row) { ?>
								<option value="<?=$row['cat_id'] ?>"><?= $row['cat_name'] ?> </option>
							<?php }  ?>
							
						</select><br/><br/><br/>
						
						<select class="custome-select" name="subcat_id" id="subcatprod_subcat" style="display:none">
							
							
						</select> 
					</center>
					
				</div>
				<div class="modal-footer">
					<input type="hidden" name="operation" id="operation" />
					<input type="hidden" name="prod_id" id="prod_id" />
					<input type="submit" name="action" id="action" class="btn btn-success" value="Add subcategory" />
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>


<script type="text/javascript" language="javascript" >
	
	
	var subcategory = <?= json_encode($result2) ?>;
	var subcat_id = null;
	var subcatprod_dataTable;
	$(function(){
		$("#subcatprod_category").change(function(){
			if($(this).val() == '0')
			{
				$("#subcatprod_subcat").hide();
				$("#subcatprod_subcat").val('0');
				
				
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
				
				$("#subcatprod_subcat").html(subcat_name);
				$("#subcatprod_subcat").show();
				
				
			}
		});
		
		
		
	});
	
	
	
	$(document).ready(function(){
		show_data();
		
		$(document).on('click', '.add_prod', function(){
			var prod_id = $(this).attr("id");
			var prod_name = $(this).attr("idn");
			
			$('.modal-title').text("Add product " +prod_name );
			$('#prod_id').val(prod_id);
			$('#action').val("Add Product");
			$('#operation').val("add_product");
			
			$('#subcatprodModal').modal('show');
			
			
		});
		
		$(document).on('click', '.delete_prod', function(){
			
			var subcatp_id = $(this).attr('id');
			
			
			if(confirm("Are you sure you want to delete this?"))
			{
				$.ajax({
					url:"action.php",
					method:"POST",
					data:{"subcatp_id":subcatp_id,
						"operation":"delete_prod"
						},
					success:function(data)
					{
						alert(data);
						productdataTable.ajax.reload();
						subcatprod_dataTable.ajax.reload();
						
					}
				});
			}
			else
			{
				return false; 
			}
			
		});
		
		
		
		
		$(document).on('submit', '#subcatprod_form', function(event){
			event.preventDefault();
			var subcatprod_subcat = $('#subcatprod_subcat').val();
			
			if(subcatprod_subcat != '' && subcatprod_subcat != 0 )
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
						$('#subcatprod_form')[0].reset();
						$('#subcatprodModal').modal('hide');
						productdataTable.ajax.reload();
						subcatprod_dataTable.ajax.reload();
					}
				});
			}
			else
			{
				alert("All Fields are Required");
			} 
		});
		
		
		
		
		
		
		
		
		var productdataTable = $('#product_data').DataTable({
			"processing":true,
			"serverSide":true,
			"order":[],
			"ajax":{
				url:"fetch.php",
				data: {
					"operation" : "product_data"
				},	
				type:"POST"
			},
			"columnDefs":[
			{
				"targets":[0,3,6],
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
			var row = productdataTable.row(tr);
			
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
				child_row += '<td><img src="../../../image/'+d[8][index][0]+'" class="img-thumbnail" width="50" height="35" /></td>';
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
					if ($.fn.dataTable.isDataTable('#subcat_prod_data'))
					{
						
						$('#subcat_prod_data').DataTable().destroy();
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
					if ($.fn.dataTable.isDataTable('#subcat_prod_data'))
					{
						
						$('#subcat_prod_data').DataTable().destroy();
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
					if ($.fn.dataTable.isDataTable('#subcat_prod_data'))
					{
						
						$('#subcat_prod_data').DataTable().destroy();
					}
					show_data();
				}
				
			} else 
			{
				subcat_id = $(this).val();
				
				if ($.fn.dataTable.isDataTable('#subcat_prod_data'))
				{
					
					$('#subcat_prod_data').DataTable().destroy();
					
				}
				show_data();
			}
		});
	});
	
	
	function show_data(){
		
		    subcatprod_dataTable = $('#subcat_prod_data').DataTable({
			"processing":true,
			"serverSide":true,
			"order":[],
			"ajax":{
				url:"fetch.php",
				data: {
					"subcat_id" : subcat_id,
					"operation" : "subcat_data"
				},	
				type:"POST"
			},
			"columnDefs":[
			{
				"targets":[0,3,6],
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
		
		
		
		
		$('#subcat_prod_data tbody').on('click', 'td.details-control', function() {
			
			var tr = $(this).closest('tr');
			var row = subcatprod_dataTable.row(tr);
			
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
				child_row += '<td><img src="../../../image/'+d[8][index][0]+'" class="img-thumbnail" width="50" height="35" /></td>';
				child_row += '</tr>'
				
			});	
			
			
			
			child_row += '</table>';
			child_row +=  '</div>';
			
			return child_row;
			
			
		}
		
		
	}
	
</script>					