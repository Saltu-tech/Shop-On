<?php
	include('../../../asset/db.php');
	session_start();
	if(!isset($_SESSION['admin_id'])){
		$_SESSION['alert'] = "Log in first To continue to Admin Panel";
		header('Location:../../?redirect='.$_SERVER['REQUEST_URI']);
	}
	
	
	
	$query = "SELECT * FROM `prod_mfrs`";
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	
	
	$query2 = "SELECT * FROM `attrib_list`";
	$statement2 = $connection->prepare($query2);
	$statement2->execute();
	$result2 = $statement2->fetchAll();
	
	
	$query3 = "SELECT * FROM `attrib_val_list`";
	$statement3 = $connection->prepare($query3);
	$statement3->execute();
	$result3 = $statement3->fetchAll();
	
?>	



<html>
	<head>
		<title>Manage Product | ShopOn</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>  
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" /> 
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
			<h1 align="center"><?= $_SESSION['name'] ?>'s Admin Product Management</h1>
			<br />
			<div class="table-responsive">
				<br />
				<div align="right">
					<button type="button" id="add_button" data-toggle="modal" data-target="#productModal" class="btn btn-info btn-lg">Add product</button>
				</div>
				<br /><br />
				<table id="product_data" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th width="5%"> </th> 
							<th width="20%">Product Name</th>
							<th width="10%">Product Price</th>
							<th width="30%">Product Desc</th>
							<th width="5%">Keyword</th>
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






<div id="productModal" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="product_form" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add Product</h4>
				</div>
				<div class="modal-body">
					
					<label>Product Name</label>
					<input type="text" name="prod_name" id="prod_name" class="form-control" />
					<br />
					<label>Product Price</label>
					<input type="text" name="prod_price" id="prod_price" class="form-control" />
					<br />
					<label>Product Desc</label>
					<input type="text" name="prod_desc" id="prod_desc" class="form-control" />
					<br />
					<label>Keyword List</label>
					<input type="text" name="keyword" id="keyword" class="form-control" />
					<br />
					<label>Manufacturer</label>
					<select  name="mfrs" id="mfrs" class="form-control" >
						<option value = ''>No Manufacturer </option>
						<?php foreach($result as $row) { ?>
							<option value="<?=$row['mfrs_id'] ?>"><?= $row['name'] ?> </option>
						<?php }  ?>
					</select>
					<br />
					<label>Type (Service / Product)</label>
					<select  name="service_type" id="service_type" class="form-control" >
						<option value="0" > Service </option>
						<option value="1"> Product </option>
					</select>
					
				</div>
				<div class="modal-footer">
					<input type="hidden" name="prod_id" id="prod_id" />
					<input type="hidden" name="operation" id="operation" />
					<input type="submit" name="action" id="action" class="btn btn-success" value="Add Product" />
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>


<div id="attribModal" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="attrib_form" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add attribute</h4>
				</div>
				<div class="modal-body">
					
					
					
					<center>
						<label>Attribute</label>
						<select class="custome-select" id="attrib_id" >
							<option value="0" selected>Please Select</option>
							<?php foreach($result2 as $row) { ?>
								<option value="<?=$row['attrib_id'] ?>"><?= $row['attrib_name'] ?> </option>
							<?php }  ?>
							
						</select><br/><br/><br/>
						
						<select class="custome-select" name="attrib_val_id" id="attrib_val_id" style="display:none">
							
							
						</select> 
					</center>
					
					
				</div>
				<div class="modal-footer">
					<input type="hidden" name="prod_id" id="prod_ids" />
					<input type="hidden" name="operation" id="operation3" />
					<input type="submit" name="action" id="action3" class="btn btn-success" value="Add Attribute" />
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>

<div id="featModal" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="feat_form" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add Feature</h4>
				</div>
				<div class="modal-body">
					
					<label>Feature</label>
					<input type="text" name="feature" id="feature" class="form-control" />
					<br />
					
					
				</div>
				<div class="modal-footer">
					<input type="hidden" name="prod_id" id="prod_idf" />
					<input type="hidden" name="operation" id="operation5" />
					<input type="submit" name="action" id="action5" class="btn btn-success" value="Add Feature" />
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
					<input type="hidden" name="img_id" id="img_id" />
					<input type="hidden" name="prod_id" id="prod_idg" />
					<input type="hidden" name="operation" id="operation4" />
					<input type="submit" name="action" id="action4" class="btn btn-success" value="Add Image" />
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.min.js"></script> 
<script type="text/javascript" language="javascript" >
	var attrib_val_list = <?= json_encode($result3) ?>;
	$(function () {
		$('#attrib_id').select2({width : '100%'});
		$('#attrib_val_id').select2({width : '100%'});
		
		$("#attrib_id").change(function(){
			if($(this).val() == '0')
			{
				$("#attrib_val_id").hide();
				$("#attrib_val_id").val('0');
				
				
			} else 
			{
				var attrib_id = $(this).val();
				var attrib_val = '';
				attrib_val += '<option value="0" selected>Please Select</option>'
				$.each(attrib_val_list, function(index){
					if(attrib_val_list[index][1] == attrib_id)
					{
						attrib_val += '<option value="'+attrib_val_list[index][0]+'">'+attrib_val_list[index][2]+'</option>';
					}
					
				});
				
				$("#attrib_val_id").html(attrib_val);
				$("#attrib_val_id").show();
				
				
			}
		});
	});
	
	
	$(document).ready(function(){
		$('#add_button').click(function(){
			$('#product_form')[0].reset();
			$('.modal-title').text("Add Product");
			$('#action').val("Add");
			$('#operation').val("Add");
		});
		
		
		
		
		
		$(document).on('click', '.add_attrib', function(){
			var prod_id = $(this).attr("id");
			var prod_n = $(this).attr("idn");
			//$("#attrib_select").html(data_option);
			
			$('#attrib_form')[0].reset();
			$('.modal-title').text("Add attribute for " +prod_n);
			$('#action3').val("Add attribute");
			$('#operation3').val("add_attrib");
			$('#prod_ids').val(prod_id);
			
		}); 
		
		$(document).on('click', '.add_feat', function(){
			var prod_id = $(this).attr("id");
			var prod_n = $(this).attr("idn");
			
			$('#attrib_form')[0].reset();
			$('.modal-title').text("Add Feature for " +prod_n);
			$('#action5').val("Add Feature");
			$('#operation5').val("add_feat");
			$('#prod_idf').val(prod_id);
			
		}); 
		
		$(document).on('click', '.add_img', function(){
			var prod_id = $(this).attr("id");
			var prod_n = $(this).attr("idn");
			$('#img_form')[0].reset();
			$('.modal-title').text("Add Image for " +prod_n);
			$('#action4').val("Add Image");
			$('#operation4').val("add_image");
			$('#prod_idg').val(prod_id);
			
		}); 
		
		
		var dataTable = $('#product_data').DataTable({
			"processing":true,
			"serverSide":true,
			"order":[],
			"ajax":{
				url:"fetch.php",
				type:"POST"
			},
			"columnDefs":[
			{
				"targets":[0,3,4,5,6,7],
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
		
		$(document).on('submit', '#product_form', function(event){
			event.preventDefault();
			var prod_name = $('#prod_name').val();
			var prod_price = $('#prod_price').val();
			var service_type = $('#service_type :selected').val();
			
			if(prod_name != '' && prod_price != ''  && service_type != '')
			{
				$.ajax({
					url:"insert.php",
					method:'POST',
					data:new FormData(this),
					contentType:false,
					processData:false,
					success:function(data)
					{
						alert(data);
						$('#product_form')[0].reset();
						$('#productModal').modal('hide');
						dataTable.ajax.reload();
					}
				});
			}
			else
			{
				alert("All Fields are Required");
			} 
		});
		
		
		
		
		
		$(document).on('submit', '#attrib_form', function(event){
			event.preventDefault();
			
			var attrib_val_id = $('#attrib_val_id :selected').val();
			
			if(attrib_val_id != '' && attrib_val_id != 0 && attrib_val_id != null)
			{
				$.ajax({
					url:"insert.php",
					method:'POST',
					data:new FormData(this),
					contentType:false,
					processData:false,
					success:function(data)
					{
						alert(data);
						$('#attrib_form')[0].reset();
						//$('#attribModal').modal('hide');
						dataTable.ajax.reload();
						//location.reload();
					}
				});
			}
			else
			{
				alert("All Fields are Required");
			} 
		});
		
		
		$(document).on('submit', '#feat_form', function(event){
			event.preventDefault();
			
			var feature = $('#feature').val();
			
			if(feature != '' )
			{
				$.ajax({
					url:"insert.php",
					method:'POST',
					data:new FormData(this),
					contentType:false,
					processData:false,
					success:function(data)
					{
						alert(data);
						$('#feat_form')[0].reset();
						//$('#attribModal').modal('hide');
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
			
			//var image_path = $('#prod_image').val();
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
					url:"insert.php",
					method:'POST',
					data:new FormData(this),
					contentType:false,
					processData:false,
					success:function(data)
					{
						alert(data);
						$('#img_form')[0].reset();
						//$('#imgModal').modal('hide');
						dataTable.ajax.reload();
					}
				});
			} 
			else
			{
				alert("All Fields are Required");
			} 
		});
		
		$(document).on('click', '.update', function(){
			var prod_id = $(this).attr("id");
			var prod_name = $(this).attr("prod_name");
			var prod_price = $(this).attr("prod_price");
			var prod_desc = $(this).attr("prod_desc");
			var keyword = $(this).attr("keyword");
			var mfrs = $(this).attr("mfrs_id");
			var service_type = $(this).attr("service_type");
			
			
			$('#prod_name').val(prod_name);
			$('#prod_price').val(prod_price);
			$('#prod_desc').val(prod_desc);
			$('#keyword').val(keyword);
			$('#mfrs').val(mfrs);
			$('#service_type').val(service_type);
			
			
			$('.modal-title').text("Update Product");
			$('#prod_id').val(prod_id);
			$('#action').val("Edit");
			$('#operation').val("Edit");
			
			$('#productModal').modal('show');
			
			
		});
		
		
		
		
		
		
		$(document).on('click', '.delete_attrib', function(){
			var prod_attrib_id = $(this).attr("id");
			if(confirm("Are you sure you want to delete this?"))
			{
				$.ajax({
					url:"delete.php",
					method:"POST",
					data:{prod_attrib_id:prod_attrib_id},
					success:function(data)
					{
						alert(data);
						dataTable.ajax.reload();
					}
				});
			}
			else
			{
				return false; 
			}
		});
		
		
		
		$(document).on('click', '.delete_feat', function(){
			var feat_id = $(this).attr("id");
			if(confirm("Are you sure you want to delete this?"))
			{
				$.ajax({
					url:"delete.php",
					method:"POST",
					data:{feat_id:feat_id},
					success:function(data)
					{
						alert(data);
						dataTable.ajax.reload();
					}
				});
			}
			else
			{
				return false; 
			}
		});
		
		
		$(document).on('click', '.delete_img', function(){
			var img_id = $(this).attr("id");
			var img_path = $(this).attr("img_path");
			if(confirm("Are you sure you want to delete this?"))
			{
				$.ajax({
					url:"delete.php",
					method:"POST",
					data:{img_id:img_id, img_path:img_path},
					success:function(data)
					{
						alert(data);
						//dataTable.ajax.reload();
					}
				});
			}
			else
			{
				return false; 
			}
		});
		//'#product_data tbody'
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
			child_row += '<tr><td><button type="button" id="'+d[8]+'" idn="'+d[1]+'" data-toggle="modal" data-target="#attribModal" class="btn btn-success btn-xs add_attrib">Add attribute</button></td></tr>';
			$.each(d[9],function(index){ 
				
				child_row += '<tr>';
				child_row += '<td>' +d[9][index][0]+'</td>';
				child_row += '<td>' +d[9][index][1]+'</td>';
				child_row += '<td>' +d[9][index][2]+'</td>';
				child_row += '</tr>'
				
			});	
			
			child_row += '<tr><td><button type="button" id="'+d[8]+'" idn="'+d[1]+'" data-toggle="modal" data-target="#featModal" class="btn btn-success btn-xs add_feat">Add Feature</button></td></tr>';
			
			$.each(d[11],function(index){ 
				
				child_row += '<tr>';
				child_row += '<td>'+d[11][index][0]+'</td>';
				child_row += '<td>' +d[11][index][1]+'</td>';
				child_row += '</tr>'
				
			});	
			
			
			
			
			
			
			child_row += '<tr><td><button type="button" id="'+d[8]+'" idn="'+d[1]+'" data-toggle="modal" data-target="#imgModal" class="btn btn-success btn-xs add_img">Add Image</button></td></tr>';
			
			$.each(d[10],function(index){ 
				
				child_row += '<tr>';
				child_row += '<td><img src="../../../image/'+d[10][index][0]+'" class="img-thumbnail" width="50" height="35" /></td>';
				child_row += '<td>' +d[10][index][1]+'</td>';
				child_row += '</tr>'
				
			});	
			
			
			
			
			
			child_row += '</table>';
			child_row +=  '</div>';
			
			return child_row;
			
			
		}
		
		
	});
</script>					